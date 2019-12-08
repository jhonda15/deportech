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

  include_once($ruta_raiz . 'clases/librerias.php');
  include_once($ruta_raiz . 'clases/sessionActiva.php');
  include_once($ruta_raiz . 'clases/Conectar.php');

  $usuario = $session->get("usuario");

  if ($usuario['tipo'] != 1) {
    header('Location: ' . $ruta_raiz . "clases/sessionCerrar.php");
  }

  $lib = new Libreria;

?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
  <?php  
    echo $lib->jquery();
    echo $lib->bootstrap();
    echo $lib->fontAwesome();
    echo $lib->proyecto();
  ?>
</head>
<body>
  <?php 
      include_once($ruta_raiz . 'navBar.php'); 
  ?>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-12 col-md-4 mt-3 mt-md-0 card-deck">
        <div class="card">
          <div class="card-body">
            <div class="text-center">
            <i class="fas fa-futbol fa-4x"></i>
            </div>
            <h5 class="card-title text-center">Partidos</h5>
            <p class="card-text">Podras llevar minuto a minuto los partidos de tu equipo con su informacion detallada</p>
          </div>
          <div class="card-footer text-center">
            <a href="partidos.php" class="btn btn-primary">Ver</a>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4 mt-3 mt-md-0 card-deck">
        <div class="card">
          <div class="card-body">
            <div class="text-center">
            <i class="fas fa-users fa-4x"></i>
            </div>
            <h5 class="card-title text-center">Jugadores</h5>
            <p class="card-text">Podras crear, editar y inhabilitar jugadores</p>
          </div>
          <div class="card-footer text-center">
            <a href="jugadores" class="btn btn-primary">Ver</a>
          </div>
        </div>
      </div>
      
    </div>
  </div>
<?php 
  echo $lib->cambioPantalla();
?>
</body>
</html>