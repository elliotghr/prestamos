# Sistema MVC

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 02 Estructura de un proyecto MVC

Definimos la estrucura del proyecto, pegamos algunos archivos en las vistas
Generamos el index del cual arrancará el proyecto

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 03 Como configurar htaccess para proyectos MVC

Creamos y definimos las reglas en nuestro .htaccess

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 04 Archivos de configuraciones

Configuramos nuestros archivos de configuración

1. En App.php definimos las configuraciones generales del sistema, como la ruta del sistema, el nombre de la compania, la moneada y el uso horario para poder manejarlo en todo el sistema

1. En SERVER.php configuramos las variables para el acceso a la DB, el string para la conexión por PDO y los valores de encriptación

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 05 Modelo y controlador vistas

1. Definimos el modelo que devolverá que vista se va a renderizar

   - Se define estatico para un acceso rápido por clase
   - Se genera un filtro de palabras claves para nuestas vistas
   - Se realizan las siguientes comprobaciones, si no existe la vista se retorna un _404_, si la vista es login o index se devuelve la vista _login_, si la vista existe se devuelve la misma vista

2. Se define el controlador, que hereda el metodo del modelo anterior y se crean sus métodos para devolver la plantilla y para devolver la vista, si está definido el parametro $_GET['views'] se hace uso de las validaciones del método obtener_vistas_modelo() de la clase vistasModelo, si no está definido se devuelve como \_login_
3. En el index se importa la configuración global, se importa el controlador, se instancia nuestro objeto vistasControlador y se trae la plantilla
