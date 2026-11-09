#!/bin/bash
# ==============================================================================
# NewGen IT Solutions - Panel de Administración de Usuarios del Sistema Linux
# Materia: Administración de Sistemas Operativos - 3° BT TI
# ==============================================================================

# Validar permisos de root
if [ "$EUID" -ne 0 ]; then
    echo "ERROR: Debe ejecutar este script como superusuario (root o con sudo)."
    exit 1
fi

while true; do
    clear
    echo "=========================================================="
    echo "       NEWGEN IT - ADMINISTRACIÓN DE USUARIOS LINUX       "
    echo "=========================================================="
    echo " 1. Crear nuevo usuario de sistema (Técnico / Operador)"
    echo " 2. Bloquear acceso a un usuario"
    echo " 3. Desbloquear acceso a un usuario"
    echo " 4. Asignar usuario al grupo sudo (Privilegios)"
    echo " 5. Listar usuarios reales del sistema (UID >= 1000)"
    echo " 6. Salir"
    echo "=========================================================="
    read -p " Seleccione una opción [1-6]: " OPCION

    case $OPCION in
        1)
            echo ""
            read -p "Ingrese el nombre del nuevo usuario: " NUEVO_USUARIO
            if id "$NUEVO_USUARIO" &>/dev/null; then
                echo "El usuario '$NUEVO_USUARIO' ya existe en el sistema."
            else
                useradd -m -s /bin/bash "$NUEVO_USUARIO"
                passwd "$NUEVO_USUARIO"
                echo "Usuario '$NUEVO_USUARIO' creado exitosamente con directorio home."
            fi
            read -p "Presione [Enter] para continuar..."
            ;;
        2)
            echo ""
            read -p "Ingrese el nombre de usuario a bloquear: " USER_LOCK
            if id "$USER_LOCK" &>/dev/null; then
                passwd -l "$USER_LOCK"
                echo "Acceso del usuario '$USER_LOCK' bloqueado."
            else
                echo "El usuario '$USER_LOCK' no existe."
            fi
            read -p "Presione [Enter] para continuar..."
            ;;
        3)
            echo ""
            read -p "Ingrese el nombre de usuario a desbloquear: " USER_UNLOCK
            if id "$USER_UNLOCK" &>/dev/null; then
                passwd -u "$USER_UNLOCK"
                echo "Acceso del usuario '$USER_UNLOCK' restaurado."
            else
                echo "El usuario '$USER_UNLOCK' no existe."
            fi
            read -p "Presione [Enter] para continuar..."
            ;;
        4)
            echo ""
            read -p "Ingrese el usuario al que desea otorgar sudo: " USER_SUDO
            if id "$USER_SUDO" &>/dev/null; then
                usermod -aG sudo "$USER_SUDO"
                echo "El usuario '$USER_SUDO' fue agregado al grupo sudo."
            else
                echo "El usuario '$USER_SUDO' no existe."
            fi
            read -p "Presione [Enter] para continuar..."
            ;;
        5)
            echo ""
            echo "--- Usuarios del Sistema con UID >= 1000 ---"
            awk -F: '$3 >= 1000 && $1 != "nobody" { printf "Usuario: %-15s UID: %-6s Shell: %s\n", $1, $3, $7 }' /etc/passwd
            echo ""
            read -p "Presione [Enter] para continuar..."
            ;;
        6)
            echo "Saliendo del administrador..."
            exit 0
            ;;
        *)
            echo "Opción inválida. Intente de nuevo."
            sleep 1
            ;;
    esac
done
