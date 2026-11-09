#!/bin/bash
# ==============================================================================
# NewGen IT Solutions - Instalación y Despliegue Automatizado Servidor LAMP
# Materia: Administración de Sistemas Operativos - 3° BT TI
# ==============================================================================

if [ "$EUID" -ne 0 ]; then
    echo "ERROR: Debe ejecutar este script como root."
    exit 1
fi

echo "=========================================================="
echo "    INICIANDO INSTALACIÓN DEL SERVIDOR WEB NEWGEN (LAMP)   "
echo "=========================================================="

# 1. Actualización de paquetes
echo "[1/5] Actualizando repositorios APT..."
apt update && apt upgrade -y

# 2. Instalación de Apache, MariaDB y PHP con módulos requeridos
echo "[2/5] Instalando Apache2, MariaDB y PHP..."
apt install -y apache2 mariadb-server php libapache2-mod-php php-mysql php-mbstring git ufw curl tar gzip

# 3. Habilitar servicios al inicio del sistema
echo "[3/5] Habilitando servicios Apache y MariaDB..."
systemctl enable apache2
systemctl start apache2
systemctl enable mariadb
systemctl start mariadb

# 4. Configuración básica de Base de Datos
echo "[4/5] Configurando base de datos 'sistema_de_gestion'..."
mariadb -e "CREATE DATABASE IF NOT EXISTS sistema_de_gestion CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
mariadb -e "GRANT ALL PRIVILEGES ON sistema_de_gestion.* TO 'root'@'localhost' IDENTIFIED BY 'root' WITH GRANT OPTION;"
mariadb -e "FLUSH PRIVILEGES;"

# 5. Configuración del Firewall UFW (Seguridad perimetral)
echo "[5/5] Configurando Firewall UFW..."
ufw allow 22/tcp
ufw allow 80/tcp
ufw allow 443/tcp
echo "y" | ufw enable

echo "=========================================================="
echo "  ¡SERVIDOR INSTALADO EXITOSAMENTE!                       "
echo "  Apache2: Activo en puerto 80                            "
echo "  MariaDB: Activo con base 'sistema_de_gestion'           "
echo "  Firewall UFW: Puertos 22, 80 y 443 abiertos             "
echo "=========================================================="
