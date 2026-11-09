#!/bin/bash
# ==============================================================================
# NewGen IT Solutions - Script de Respaldo Total del Sistema
# Materia: Administración de Sistemas Operativos - 3° BT TI
# ==============================================================================

FECHA=$(date +'%Y-%m-%d_%H-%M-%S')
DIR_DESTINO="/var/backups/newgen/total"
ARCHIVO_LOG="/var/log/newgen_backups.log"
RETENCION_DIAS=15

# Variables de Base de Datos y Web
DB_USER="root"
DB_PASS="root" # Ajustar según contraseña configurada en MariaDB
DB_NAME="sistema_de_gestion"
DIR_WEB="/var/www/html/NewGen"

# 1. Asegurar directorios
mkdir -p "$DIR_DESTINO"
mkdir -p "$(dirname "$ARCHIVO_LOG")"

echo "==========================================================" >> "$ARCHIVO_LOG"
echo "[$(date +'%Y-%m-%d %H:%M:%S')] INICIO: Respaldo Total NewGen" >> "$ARCHIVO_LOG"

# 2. Respaldo de Base de Datos (Estructura + Datos)
TEMP_SQL="/tmp/${DB_NAME}_${FECHA}.sql"
mysqldump -u "$DB_USER" -p"$DB_PASS" --default-character-set=utf8mb4 "$DB_NAME" > "$TEMP_SQL" 2>> "$ARCHIVO_LOG"

if [ $? -eq 0 ]; then
    echo "[$(date +'%Y-%m-%d %H:%M:%S')] Base de datos '$DB_NAME' exportada correctamente." >> "$ARCHIVO_LOG"
else
    echo "[$(date +'%Y-%m-%d %H:%M:%S')] ERROR: Fallo al exportar la base de datos." >> "$ARCHIVO_LOG"
fi

# 3. Empaquetado comprimido (Archivos Web + Dump SQL)
ARCHIVO_FINAL="${DIR_DESTINO}/backup_total_${FECHA}.tar.gz"

tar -czf "$ARCHIVO_FINAL" -C "/var/www/html" "NewGen" -C "/tmp" "$(basename "$TEMP_SQL")" 2>> "$ARCHIVO_LOG"

if [ $? -eq 0 ]; then
    TAMANIO=$(du -h "$ARCHIVO_FINAL" | cut -f1)
    echo "[$(date +'%Y-%m-%d %H:%M:%S')] Respaldo total creado con éxito: $ARCHIVO_FINAL ($TAMANIO)" >> "$ARCHIVO_LOG"
else
    echo "[$(date +'%Y-%m-%d %H:%M:%S')] ERROR al crear el archivo comprimido." >> "$ARCHIVO_LOG"
fi

# 4. Limpieza de archivos temporales
rm -f "$TEMP_SQL"

# 5. Política de retención (eliminar respaldos de más de 15 días)
find "$DIR_DESTINO" -type f -name "*.tar.gz" -mtime +"$RETENCION_DIAS" -exec rm -f {} \;
echo "[$(date +'%Y-%m-%d %H:%M:%S')] Política de retención aplicada: copias con más de $RETENCION_DIAS días depuradas." >> "$ARCHIVO_LOG"
echo "[$(date +'%Y-%m-%d %H:%M:%S')] FIN: Proceso finalizado exitosamente." >> "$ARCHIVO_LOG"
