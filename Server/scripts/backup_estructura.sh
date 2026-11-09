#!/bin/bash
# ==============================================================================
# NewGen IT Solutions - Script de Respaldo de Estructura (DDL)
# Materia: Administración de Sistemas Operativos - 3° BT TI
# ==============================================================================

FECHA=$(date +'%Y-%m-%d_%H-%M-%S')
DIR_DESTINO="/var/backups/newgen/estructura"
ARCHIVO_LOG="/var/log/newgen_backups.log"
RETENCION_DIAS=30

DB_USER="root"
DB_PASS="root"
DB_NAME="sistema_de_gestion"

# 1. Asegurar directorios
mkdir -p "$DIR_DESTINO"
mkdir -p "$(dirname "$ARCHIVO_LOG")"

echo "----------------------------------------------------------" >> "$ARCHIVO_LOG"
echo "[$(date +'%Y-%m-%d %H:%M:%S')] INICIO: Respaldo de Estructura (DDL)" >> "$ARCHIVO_LOG"

ARCHIVO_SQL="${DIR_DESTINO}/estructura_${DB_NAME}_${FECHA}.sql"

# 2. Respaldo solo de estructura (sin datos) con comentarios y rutinas
mysqldump -u "$DB_USER" -p"$DB_PASS" \
    --no-data \
    --routines \
    --events \
    --default-character-set=utf8mb4 \
    "$DB_NAME" > "$ARCHIVO_SQL" 2>> "$ARCHIVO_LOG"

if [ $? -eq 0 ]; then
    gzip -f "$ARCHIVO_SQL"
    TAMANIO=$(du -h "${ARCHIVO_SQL}.gz" | cut -f1)
    echo "[$(date +'%Y-%m-%d %H:%M:%S')] Estructura respaldada: ${ARCHIVO_SQL}.gz ($TAMANIO)" >> "$ARCHIVO_LOG"
else
    echo "[$(date +'%Y-%m-%d %H:%M:%S')] ERROR: No se pudo respaldar la estructura." >> "$ARCHIVO_LOG"
fi

# 3. Limpieza por retención
find "$DIR_DESTINO" -type f -name "*.sql.gz" -mtime +"$RETENCION_DIAS" -exec rm -f {} \;
echo "[$(date +'%Y-%m-%d %H:%M:%S')] FIN: Respaldo de estructura completado." >> "$ARCHIVO_LOG"
