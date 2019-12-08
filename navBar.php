	<!-- Barra de Manú -->
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
  ?>

  <nav class="navbar navbar-expand-lg bg-light border-bottom shadow">
    <div class="container">
      <a class="navbar-brand" href="<?php echo(RUTA_RAIZ . $usuario['ruta']) ?>">
        <img width="50px" src="<?php echo $ruta_raiz; ?>img/logo.png" alt="">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img class="rounded-circle" width="40px" src="<?php echo($ruta_raiz)?>img/fotoPerfil.png">
            </a>  
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" onclick="top.cerrarSesion();"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>

