<?php 


$lifetime=3600;
@session_start();
@setcookie(session_name(),session_id(),time()+$lifetime);


define("RUTA_RAIZ","/ceg_desarrollo/");   //esta es la ruta disco desde la raiz del serviddor hasta donde se encuentran los scripts



//conexion general a bd, son las contantes que usa la clase Bd por defecto
define("BDNAME","ceg_db_dev");
define("BDSERVER","192.168.1.209\SQLEXPRESS,1433");
define("BDUSER","ceg_user2");
define("BDPASS","#515t3ma5*");
define("BDTYPE",3);


//conexiones para geminus BD oracle, para el proceso con forecast
define("BDNAME_GEMINUS","CONSUMER");
define("BDSERVER_GEMINUS","192.168.1.2:1521");
define("BDUSER_GEMINUS","PRUEBAS");// GEMINUSI4
define("BDPASS_GEMINUS","ad43");
define("BDTYPE_GEMINUS",2);

//conexiones para geminus BD oracle, base de datos administrativas de usuario
define("BDNAME_GEMINUS_ADMIN","CONSUMER");
define("BDSERVER_GEMINUS_ADMIN","192.168.1.2:1521");
define("BDUSER_GEMINUS_ADMIN","ADMIN_GEM");// GEMINUSI4
define("BDPASS_GEMINUS_ADMIN","ad43");
define("BDTYPE_GEMINUS_ADMIN",2);


//time zone
date_default_timezone_set('America/Bogota');


//indica en que carpeta estan los modulos dentro de los scripts
define("RUTA_MODULOS",RUTA_RAIZ."modulos/");


define("RUTA_ALMACENAMIENTO",'almacenamiento/');


define('CORREO_SERVIDOR','ssl://imap.gmail.com'); //ssl://mail.hyundailatinoamerica.com ssl://imap.gmail.com
define('CORREO_SERVIDOR_PUERTO',993);
define('CORREO_SERVIDOR_SALIDA','ssl://imap.gmail.com');
define('CORREO_SERVIDOR_SALIDA_PUERTO', 465);
define('CORREO_ENVIO', 'no-reply@hyundaielectronics.com.co'); //no-reply@hyundailatinoamerica.com
define('CORREO_ENVIO_PASS', '515t3ma5'); 
define('IsSMTP', true);
define('SMTPSecure', false);
define('CORREO_PHP', false);
define('TITULO_NOTIFICACION', 'Notificaciónes Consumer Electronics Group');

?>