#!/bin/bash
# ==============================================================================
# NewGen IT Solutions - Configuración Automatizada de Tareas Cron
# Materia: Administración de Sistemas Operativos - 3° BT TI
# ==============================================================================

if [ "$EUID" -ne 0 ]; then
    echo "ERROR: Debe ejecutar este script como superusuario (root o con sudo)."
    exit 1
fi

CRON_FILE="/etc/cron.d/newgen_tareas"
SCRIPTS_DIR="/opt/newgen/scripts"

# Crear directorio estándar de scripts en Linux
mkdir -p "$SCRIPTS_DIR"
cp /tmp/*.sh "$SCRIPTS_DIR/" 2>/dev/null || cp ./*.sh "$SCRIPTS_DIR/" 2>/dev/null
chmod +x "$SCRIPTS_DIR"/*.sh

echo "Instalando tabla de tareas programadas en $CRON_FILE..."

cat << 'EOF' > "$CRON_FILE"
# ==============================================================================
# Rutinas Automatizadas NewGen IT (Cron Daemon)
# ==============================================================================
SHELL=/bin/bash
PATH=/usr/local/sbin:/usr/local/bin:/sbin:/bin:/usr/sbin:/usr/bin

# 1. Respaldo de estructura de base de datos diario a la 01:00 AM
0 1 * * * root /opt/newgen/scripts/backup_estructura.sh >/dev/null 2>&1

# 2. Respaldo total del sistema (Base de Datos + Archivos Web) todos los domingos a las 02:00 AM
0 2 * * 0 root /opt/newgen/scripts/backup_total.sh >/dev/null 2>&1

# 3. Monitoreo y auto-recuperación de servicios cada hora en punto
0 * * * * root /opt/newgen/scripts/monitoreo_servicios.sh >/dev/null 2>&1
EOF

chmod 644 "$CRON_FILE"
systemctl restart cron

echo "=========================================================="
echo " Tareas Cron instaladas exitosamente:"
echo " 1. Respaldo de estructura: Diario a la 01:00 AM"
echo " 2. Respaldo total: Domingos a las 02:00 AM"
echo " 3. Monitoreo de servicios: Cada 60 minutos"
echo "=========================================================="
