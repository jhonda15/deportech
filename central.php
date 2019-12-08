<?php  
	$max_salida=10; // Previene algun posible ciclo infinito limitando a 10 los ../
  $ruta_raiz=$ruta="";
  while($max_salida>0){
    if(@is_file($ruta.".htaccess")){
      $ruta_raiz=$ruta; //Preserva la ruta superior encontrada
      break;
    }
    $ruta.="../";
    $max_salida--;
  }

	require_once($ruta_raiz . 'clases/funciones_generales.php');
  require_once($ruta_raiz . 'clases/sessionActiva.php');
  require_once($ruta_raiz . 'clases/librerias.php');

  //Traemos la session del usuario
  $session = new Session();
  $usuario = $session->get('usuario');

  $lib = new Libreria();

?>
<!DOCTYPE html>
<html>
<head>
	<?php  
    echo $lib->metaTagsRequired();
  ?>
	<title>Deportech</title>

	<?php  
    echo $lib->iconoPag();
    echo $lib->jquery();
    echo $lib->bootstrap();
    echo $lib->fontAwesome();
    echo $lib->jqueryValidate();
    echo $lib->alertify();
    echo $lib->proyecto();
  ?>
</head>
<body class="overflow-hidden">
		
	<object type="text/html" id="contenido" name="contenido" data="" class="w-100 vh-100"></object>


  <!-- Modal de Cargando -->
  <div class="modal fade modal-cargando" id="cargando" tabindex="1" role="dialog" aria-labelledby="cargandoTitle" aria-hidden="true" data-keyboard="false" data-focus="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="box-loading">
        <div class="loader">
          <div class="loader-1">
            <div class="loader-2">
            </div>
          </div>
        </div>
        <div>
          <img class="w-50" src="<?php RUTA_RAIZ; ?>img/logo.png" alt="">
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Configuracion -->
  <div class="modal fade" id="modal-link" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <object type="text/html" id="contenido-modal" name="contenido-modal" class="w-100" style="height: 75vh"></object>
      </div>
    </div>
  </div>

  <!-- Modal Sesion Cerrada -->
  <div class="modal fade" id="cerrarSession" tabindex="-1" role="dialog" aria-labelledby="cerrarSessionTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-body text-center">
          <i class="fas fa-exclamation fa-7x text-warning mt-3 mb-3"></i>
          <h2>Lo sentimos, la sesión ha caducado</h2>
          Favor ingresar nuevamente, Gracias.
        </div>
        <div class="modal-footer d-flex justify-content-center">
          <a class="btn btn-primary" href="<?php echo $ruta_raiz; ?>">Cerrar <i class="fas fa-times"></i></i></a>
        </div>
      </div>
    </div>
  </div>
</body>
<script type="text/javascript">
	$("#cargando").modal("show");
	var idleTime = 0; 
	$(function(){
		//Tiempo en que valida la session
    window.idleInterval = setInterval(validarSession, 600000); // 10 minute 

    if (localStorage.proyectourl == null) {
      localStorage.removeItem("proyectourl");
      window.location.href='<?php echo RUTA_RAIZ ?>clases/sessionCerrar';
    }else{
      $("#contenido").attr("data", localStorage.proyectourl);
    }

		setTimeout(function() {
      $("#cargando").modal("hide");
    }, 1000);
	});

	function validarSession(){
    $.ajax({
      type: 'POST',
      url: "<?php echo($ruta_raiz); ?>ajax/usuarios",
      data: {accion: "sessionActiva"},
      success: function(data){
        if (data == 0) {
          localStorage.removeItem("proyectourl");
          $("#cerrarSession").modal("show");
        }
      },
      error: function(data){
        alertify.error("No se ha podido validar la session");
      }
    });
  }

	function cerrarSesion(){
    localStorage.removeItem("proyectourl");
    window.location.href='<?php echo RUTA_RAIZ ?>clases/sessionCerrar';
  }
</script>

</html>