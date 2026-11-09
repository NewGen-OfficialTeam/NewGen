# Manual de Administración de Sistemas Operativos - NewGen Server
**Carrera:** 3er. Año B.T. – Tecnologías de la Información  
**Materia:** Administración de Sistemas Operativos  
**Entorno:** VirtualBox + Debian GNU/Linux (64-bit)

---

## 1. Relevamiento y Justificación del Sistema Operativo

Para la infraestructura de servidor de **NewGen**, se seleccionó **Debian GNU/Linux (64-bit)** como sistema operativo base por las siguientes razones técnicas:

* **Estabilidad y Confiabilidad:** Debian es reconocido en la industria como una de las distribuciones más sólidas para servidores de producción. Su estricto ciclo de pruebas garantiza que los paquetes de software estén libres de fallos críticos.
* **Seguridad y Actualizaciones:** Cuenta con un equipo dedicado a la seguridad que provee parches rápidos a través del gestor de paquetes `APT`.
* **Optimización de Recursos (Rendimiento Headless):** Al operar como servidor sin entorno de escritorio gráfico (CLI puro), consume menos de 250 MB de memoria RAM en reposo, dedicando casi el 100% del hardware a Apache, MariaDB y PHP.
* **Costo Total de Propiedad (TCO):** Es software 100% libre y de código abierto, eliminando costos de licencias para la empresa.

---

## 2. Configuración de la Máquina Virtual en VirtualBox

La máquina virtual fue creada con el nombre **`NewGen-Server`** con las siguientes especificaciones:

| Componente | Configuración Asignada | Justificación |
| :--- | :--- | :--- |
| **Memoria RAM** | 2048 MB (2 GB) | Sobrado para el stack LAMP y servicios en segundo plano. |
| **Procesadores** | 2 CPUs virtuales | Garantiza fluidez en tareas simultáneas de backups y Apache. |
| **Almacenamiento** | 20 GB (Formato VDI dinámico) | Espacio para el sistema, base de datos y retención de backups. |
| **Medio de Instalación**| `debian-13.7.0-amd64-netinst.iso` | Instalación mínima vía red. |
| **Red (Adaptador 1)** | NAT con Reenvío de Puertos (*Port Forwarding*) | Permite acceso desde el host sin depender de la IP del router. |

### Reglas de Reenvío de Puertos (Port Forwarding):
* **SSH:** Puerto anfitrión `2222` &rarr; Puerto invitado `22`
* **HTTP (Web):** Puerto anfitrión `8080` &rarr; Puerto invitado `80`
* **MariaDB:** Puerto anfitrión `3307` &rarr; Puerto invitado `3306`

---

## 3. Scripts de Administración y Gestión

Los scripts se encuentran en `/opt/newgen/scripts/` con permisos de ejecución (`chmod +x`):

### A. `backup_total.sh` (Respaldo Completo)
* **Objetivo:** Genera una copia integral de la base de datos `sistema_de_gestion` y del directorio web `/var/www/html/NewGen`.
* **Mecanismo:** Utiliza `mysqldump` con codificación UTF-8, comprime todo en un paquete `.tar.gz` con marca de tiempo en `/var/backups/newgen/total/`.
* **Depuración:** Aplica una política de retención automática eliminando respaldos que superen los 15 días (`find -mtime +15 -delete`).
* **Auditoría:** Registra cada paso con timestamp en `/var/log/newgen_backups.log`.

### B. `backup_estructura.sh` (Respaldo de Estructura DDL)
* **Objetivo:** Respalda únicamente la arquitectura de tablas, claves foráneas y disparadores sin datos (`mysqldump --no-data`).
* **Mecanismo:** Genera un archivo `.sql` comprimido con `gzip` en `/var/backups/newgen/estructura/`.
* **Frecuencia:** Ideal para auditorías diarias de cambios en el esquema.

### C. `monitoreo_servicios.sh` (Autorecuperación de Servicios)
* **Objetivo:** Verifica que `apache2` y `mariadb` se encuentren activos (`systemctl is-active`).
* **Resiliencia:** Si detecta un servicio caído, intenta reiniciarlo automáticamente y registra la incidencia en `/var/log/newgen_servicios.log`.

### D. `admin_usuarios.sh` (Gestión Interactiva de Usuarios Linux)
* **Objetivo:** Menú interactivo en terminal para el administrador de sistemas:
  1. Alta de nuevos usuarios del sistema con creación de `/home`.
  2. Bloqueo temporal de cuentas (`passwd -l`).
  3. Desbloqueo de cuentas (`passwd -u`).
  4. Asignación a grupos con privilegios (`usermod -aG sudo`).
  5. Listado de usuarios humanos (UID &ge; 1000).

---

## 4. Automatización con Cron Daemon (`configurar_cron.sh`)

La planificación periódica se instala en `/etc/cron.d/newgen_tareas`:

```cron
# 1. Respaldo de estructura de base de datos diario a la 01:00 AM
0 1 * * * root /opt/newgen/scripts/backup_estructura.sh >/dev/null 2>&1

# 2. Respaldo total del sistema todos los domingos a las 02:00 AM
0 2 * * 0 root /opt/newgen/scripts/backup_total.sh >/dev/null 2>&1

# 3. Monitoreo de servicios cada hora en punto
0 * * * * root /opt/newgen/scripts/monitoreo_servicios.sh >/dev/null 2>&1
```

---

## 5. Puesta en Marcha Rápida

1. Iniciar la máquina virtual **`NewGen-Server`** en VirtualBox.
2. Completar la instalación guiada de Debian.
3. Copiar y ejecutar el script `instalar_servidor.sh` como `root`.
4. Ejecutar `configurar_cron.sh` para dejar activos los respaldos automáticos.
