Al iniciar la aplicación se muestra una pantalla de login.
Desde allí se puede ingresar como Administrador, Técnico o Usuario. 
Dependiendo del rol seleccionado, el sistema habilita distintas opciones y funcionalidades.

En esta versión del proyecto los usuarios están hardcodeados, 
ya que todavía no se implementó la conexión con la base de datos. 
Esto se hizo únicamente para poder realizar pruebas y mostrar cómo funcionarán los diferentes permisos.

El usuario podrá crear tickets para informar problemas o solicitar soporte. 
El técnico podrá ver esos tickets, tomarlos y resolver las incidencias. 
Por su parte, el administrador tendrá la función de supervisar la actividad de los demás usuarios y el funcionamiento general del sistema.

Actualmente algunas opciones del menú y sus enlaces todavía no están implementados. 
Sin embargo, la aplicación ya permite visualizar claramente la estructura del sistema y cómo funcionarán los permisos 
y las tareas de cada tipo de usuario una vez que el proyecto esté completo.

USUARIO

Cuando entrás como usuario vas a ver 4 opciones, nueva solicitud, mis tickets, mi historial, y cerrar sesión.
La idea es que al crear un ticket el técnico determine su prioridad (baja, media, alta).
Y de ahí, con un archivo llamado solicitud.php o algo del estilo se va a procesar la creación de los nuevos tickets.
Aún nada es funcional, en los .php de la carpeta de usuario (historial.php y mis_tickets.php), se está usa una variable que se llama $id_usuario_actual = 1; como un placeholder, cuando el sistema de inicio de sesión esté completamente conectado con la base de datos, este valor se reemplazará por la variable superglobal $_SESSION para obtener el ID real del usuario logueado.