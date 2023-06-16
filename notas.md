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

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 12 Funciones para validar datos y fechas

1. Creamos una función verificar datos que retorna si hubo un error o no al testear un pattern
2. Creamos una función para verificar que la fecha sea valida

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 13 y 14 Funcion paginador de tablas (parte 1 y 2)

1. creamos un método llamado paginacion() en el mainModel, el cual generará el contenido HTML de nuestra navegación con los parametros: $pagina, $n_paginas, $url, $botones.
2. Dependiendo de la página en la que nos ubicamos renderizamos o deshabilitamos ciertos botones
3. Creamos un ciclo para renderizar n cantidad de botones, y generamos un condicional para aplicar un estilo _active_ si es el botón de la página actual o no

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 15, 16 y 17 Funciones JavaScript (parte 1, 2 y 3)

1. Creamos un archivo alertas en nuestra carpeta vistas/js/
2. Incluimos el script de este archivo en Scripts.php
3. Haciendo uso de sweet alert 2 creamos una función que mostrará cierta alerta dependiendo del tipo de alerta que le pasemos, el objeto de las alertas se alimentará del json que le pasemos
4. Creamos un envío de datos con fetch con los atributos del formulario

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 18 Modelo y controlador usuario

1. Creamos nuestro usuarioModelo
   - Incluimos el mainModel
   - Heredamos el mainModel
2. Creamos nuestro usuarioControlador
   - Dependiendo de si realizamos una petición AJAX ejecutaremos el controlador desde el usuarioAjax, si no, entonces ejecutamos desde index.php, de ahi depende la ruta de importación del usuarioModelo
   - Incluimos el usuarioModelo
   - Heredamos el usuarioModelo
3. Creamos nuestro usuarioAjax
   - Este archivo recibirá los datos enviados desde los formularios
   - Asignamos a true la variable $peticionAjax
   - Generamos una condición para ejecutar los controladores si estamos realizando una petición ajax, si no, alguien intenta acceder a nuestro archivo y debemos iniciar y destruir su sesión y redirigirlo al login

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 19 Modelo agregar usuario (CRUD)

1. Creamos nuestro primero método _(agregar_usuario_modelo)_ en nuestro modelo usuariosModelo
   - recibimos los datos y generamos una consulta preparada, bindeamos los campos, ejecutamos y retornamos el valor de la consulta
2. Creamos y solo definimos nuestro primer método _(agregar_usuario_controlador)_ del controlador

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 20 Controlador agregar usuario [CRUD] (parte 1)

1. Definimos los metadatos en nuestra vista user-new (atributos)
   - metodo
   - action
   - data-form
   - clase .FormularioAjax
2. El archivo usuarioAjax es un archivo intermediario para recibir los datos antes de enviarlos al controlador, comprobamos la existencia de alguno de nuestros inputs, si coincide, verificamos otros campos obligatorios e imprimimos con echo el método que ocuparemos
3. En el controlador recibimos cada uno de los campos, validamos los campos obligatorios, en caso de error devolvemos un array asociativo codificado a json con las llaves necesarias para mostrar las alertas

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 21 Controlador agregar usuario [CRUD] (parte 2)

1. Comprobamos la integridad de los datos
   - Verificamos el pattern de cada uno de los inputs requeridos
   - Si no es un campo requerido primero validamos que el input tenga valor y posteriormente validamos su pattern

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 22 Controlador agregar usuario [CRUD] (parte 3)

1. Validamos los campos unicos, comprobamos con la DB que no existan
2. ? Corrección de el main model, linea 22
   ```php
    //-------- Función para ejecutar consultas simples --------
    protected static function ejecutar_consulta_simple($consulta)
    {
        // Haciendo uso del método conectar preparamos la consulta
        $sql = self::conectar()->prepare($consulta);
        // Ejecutamos
        $sql = $sql->execute(); // CORRECCIÓN -> cambiamos de esto
        $sql->execute(); // CORRECCIÓN -> a esto
        // retornamos el resultado
        return $sql;
    }
   ```

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 23 Controlador agregar usuario [CRUD] (parte 4)

Seguimos validando y configurando el controlador:

1. Verificamos y encriptamos las claves
2. Verificamos y validamos los privilegios
3. Creamos el array que recibirá el modelo
4. Recibimos la respuesta del modelo y enviamos el resultado codificado en json

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 24 Modelo iniciar sesion

1. Creamos el archivo loginModelo, loginControlador y loginAjax para crear el inicio de sesión
   - Creamos sus clases correspondientes del modelo y controlador
   - Dejamos la parte del else en el loginAjax por si intentan acceder directamente a él
   - Creamos el método iniciar_sesion_modelo en el Modelo para obtener los datos del usuario si el usuario, clave y estado son válidos

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 25 Controlador iniciar sesion (parte 1)

1. El formulario no será enviado por ajax, el action se deja vacío
2. Recibimos los datos en el formulario
   - Verificamos que no vengan vacios
   - Verificamos su integridad
   - encriptamos la clave para compararla contra la DB
   - Solicitamos los datos al modelo
     - En caso de que no coincidan los datos mandamos un error
     - En casi de que coincidan los obtendremos para generar las variables de sesión

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 26 Controlador iniciar sesion (parte 2)

1. Corregimos nuestro controlador a public y no estatico, controladores deben ser publicos y no estaticos
2. Generamos las variables de session necesarias y redireccionamos a nuestra home
3. modificamos la view para enviar los datos al controlador
4. En nuestra vista login-view verificamos la existencia de las variables por POST para instanciar el controlador y hacer uso del método para comprobar las credenciales
5. En la plantilla (donde se alojan las vistas) iniciamos la sessión con su nombre correspondiente
6. Y en la NavLateral imprimimos los valores del usuario

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 27 Controlador forzar cierre de sesion

1. Creamos el método forzar_cierre_sesion_controlador() para forzar el cierre de sesión y redirigir al usuario al login cuando no se autentique e intente ingresar a nuestro sistema
   - Destruimos sesión
   - Redirigimos al login
2. En la plantilla, cuando se renderizan las vistas, creamos una validación, si no vienen nuestras variables de sessión hacemos uso del método anterior (forzar_cierre_sesion_controlador)

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 28 Seguridad en vistas del usuario

Ya que el acceso a las vistas de Usuarios solo está permitido para usuarios con privilegio 1...

1. En la NavLateral creamos una validación para mostrar el menú de Usuarios a los que tengan privilegio 1
2. En la vista home también aplicamos estos cambios para el recuadro de Usuarios
3. Ahora bloqueamos el acceso por la URL, poniendo una validación a cada vista de usuarios
   ```php
   <!-- Al inicio de cada vista -->
   if ($_SESSION["privilegio_spm"] != 1) {
   	$instancia_login->forzar_cierre_sesion_controlador();
   	exit();
   }
   ```
   - No aplica para user-update ya que este sí será para cualquier usuario, para acutalizar sus propios datos

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 29 Controlador cerrar sesion

1. Creamos un método en el controlador para el cierre de sesión
2. Guardamos en variables los datos que nos envíe el botón
   - En caso de que sean identicos a las variables de sesión cerramos la sesión
   - En caso contrario enviamos una alerta de fallo al intentar cerrar la sesión

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 30 Script LogOut

Vamos a generar el archivo js para detectar el click y cerrar la sesión

1. Creamos nuestro archivo inc/LogOut.php y lo incluimos en la plantilla.php cuando hay un log correcto
2. quitamos el script JS que viene por defecto en la plantilla asignado al botón de logout
3. Generamos el código para detectar el click en nuestro botón
   - encriptamos el token y el usuario
   - enviamos el código via fetch a nuestro archivo loginAjax
4. En el loginAjax validamos que vengan las variables por post, en caso de que si vengan las dos variables entonces instanciamos al controlador y hacemos uso del método cerrar_session_controlador(), el cual comparará los tokens y los usuarios y cerrará o no la sesión

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 31 Controlador paginador usuarios (parte 1)

Iniciamos el controlador para la paginación de usuarios, recibimos las variables necesarias para mostrar los botones y ciertos registros x pagina

1. validamos que la pagina sea un número valido

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 32 Controlador paginador usuarios (parte2)

En el método paginador_usuario_controlador de nuestro controlador de usuarios

1.  Generamos la query para listar nuestros usuarios

- Generamos una query si hay una busqueda
- Generamos otra query si no hay una busqueda
- La mandamos a la DB
- Traemos los datos y el número total de resultados para generar mi n_paginas

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 33 Controlador paginador usuarios (parte 3)

Trabajando en el controlador usuarioControlador

1. Se añadieron querys para traer los totales, esto se almacena en $consulta_total
2. Se lanzan las querys a la DB y con esos datos se renderiza la tabla copiando la estructura HTML de la vista
   - Dependiendo del resultado de la DB se muestran los datos o se envia un mensaje de que no hay registros o recargar el listado
   - Al final de renderizar la tabla se concatena los bototnes de navegación usando el método paginación del mainModel

En la vista user-list

1. Se elimina el marcado HTML (ya que el controlador lo renderizará)
2. Se instancia e imprime el método paginador_usuario_controlador del controlador y se pasan las variables necesarias para su funcionamiento

En la plantilla.php

1. Después de comprobar el inicio de sesión se crean las variables _$pagina_ y _$registros_ para que nuestra vista las puede utilizar en el método del controlador

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 34 Controlador paginador usuarios (parte 4)

En el controlador completamos parte de la vista y redirecciones

1. En los botones de actualizar y eliminar generamos la ruta a usuarioAjax con su respectivo id encriptado para evitar manipulación en la url por parte de los usuarios
2. Se genera una variable cantidad_registros_inicio y también la variable cantidad_registros_final para armar un parrafo mostrando cuantos usuarios del total se están mostrando

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 35 Modelo eliminar usuario (CRUD)

Corregimos un error en la validación al mostrar los registros totales cuando el usuario está en una pagina donde no hay registros
Creamos el modelo para eliminar un usuario

## 💻 CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 36 Controlador eliminar usuario (CRUD)

En el archivo usuarioAjax.php

1. El el archivo usuarioAjax validamos que exista el paso de la variable usuario_id_del por POST
2. En caso de que si exista, validamos de nuevo para enviar los datos al controlador

En el usuarioControlador.php

1. Creamos el método eliminar_usuario_controlador()
   - Recibimos y desencriptamos la variable
   - Validamos que no sea el usuario #1 (Administrador)
   - Validamos que el usuario exista
   - Comprobamos que el usuario no tenga prestamos
     - Debido a las reglas de restricción no se podrá eliminar este usuario
   - Si todo es correcto mandamos llamar al modelo, recibimos la respuesta y la enviamos con nuestro json al js
     Correción de bugs
1. Hacia falta una comilla doble en el action en el método paginador_usuario_controlador del controlador usuario al renderizar la tabla

## CURSO mi primer SISTEMA [PHP, MVC, MYSQL & POO] - 37 Modelo y controlador datos usuario (CRUD)

1. Creamos el método obtener_datos_usuario_modelo en el modelo usuarioModelo para enviar los datos
   - Este método enviará los datos para actualizar un usuario o el conteo de todos nuestros usuarios registrados en la db (ignorando al usuario admin)
   - Dependiendo del tipo de operación devolveremos ciertos datos
2. Creamos el controlador que recibirá y enviará los datos al modelo
3. En la NavBar corregimos la URL para que el usuario logueado pueda acceder a los datos de su cuenta para actualizarlos
