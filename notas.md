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

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 06 Configurando plantilla base para proyecto MVC

1.  Generamos el marcado HTML en nuestro archivo plantilla.php
    - Separamos en componentes la NavBar, la Nav Lateral, los Links, los Scripts js, todos dentro de una carpeta inc.
    - Escribimos correctamente su ruta, la cual debe de partir desde el index.

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 07 Como crear vistas en PHP & MVC

1. Generamos las vistas de la aplicación en la carpeta contenidos
2. En nuestra plantilla instanciamos el objeto vistasControlador para hacer uso de su método obtener_vistas_controlador();
3. Creamos un renderizado condicional, si la vista es _login_ o _404_ no renderizaremos las navbars, si es cualquier otra vista sí renderizaremos las navbars

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 09 Modelo principal y conexion a BD

1. Generamos un archivo mainModel.php que tendrá la conexión a la DB y un método de consultas generales (simples)
2. Dependiendo de si hay una petición ajax o no configuramos la ruta al importar las variables del servidor (SERVER.php)
3. En nuestra clase MainModel generamos 2 metodos
   1. conectar()
      - Generamos la conexión via PDO y
      - configuramos el juego de caracteres
   2. ejecutar_consulta_simple()
      - Generamos este método que recibirá una consulta simple
      - preparamos y ejecutamos la consulta

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 10 modelos de hash y codigos aleatorios

1. Añadimos funciones de encriptación y desencriptación para cadenas, esto con el fin de poder hashear ids por la url y tener un medio de seguridad (que no se puedan manipular los ids por la url)
2. Generamos el método generar_codigo_aleatorio(), el cual nos servirá para llevar el número de prestamo