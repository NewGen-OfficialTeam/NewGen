#!/bin/bash
# ==============================================================================
# NewGen IT Solutions - Script de Monitoreo y Autorecuperación de Servicios
# Materia: Administración de Sistemas Operativos - 3° BT TI
# ==============================================================================

ARCHIVO_LOG="/var/log/newgen_servicios.log"
mkdir -p "$(dirname "$ARCHIVO_LOG")"

SERVICIOS=("apache2" "mariadb")

for SERVICIO in "${SERVICIOS[@]}"; do
    if systemctl is-active --quiet "$SERVICIO"; then
        echo "[$(date +'%Y-%m-%d %H:%M:%S')] OK: Servicio '$SERVICIO' operativo." >> "$ARCHIVO_LOG"
    else
        echo "[$(date +'%Y-%m-%d %H:%M:%S')] ALERTA: '$SERVICIO' CAÍDO. Intentando reiniciar..." >> "$ARCHIVO_LOG"
        systemctl restart "$SERVICIO"
        
        sleep 2
        if systemctl is-active --quiet "$SERVICIO"; then
            echo "[$(date +'%Y-%m-%d %H:%M:%S')] RECUPERADO: Servicio '$SERVICIO' reiniciado con éxito." >> "$ARCHIVO_LOG"
        else
            echo "[$(date +'%Y-%m-%d %H:%M:%S')] CRÍTICO: No se pudo reiniciar '$SERVICIO'. Se requiere intervención manual." >> "$ARCHIVO_LOG"
        fi
    fi
done
