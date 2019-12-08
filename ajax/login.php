<?php  
	@session_start();
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

  require($ruta_raiz . "clases/funciones_generales.php");
  require($ruta_raiz . "clases/Conectar.php");
  require($ruta_raiz . "clases/Session.php");

	$log_usuario = "";
	$log_password = "";

	if (isset($_REQUEST['nroDoc']) && isset($_REQUEST['password']) && isset($_REQUEST['tipo'])) {
		$usuario = htmlentities(addslashes($_REQUEST['nroDoc']), ENT_QUOTES);
		$pass = htmlentities(addslashes($_REQUEST['password']), ENT_QUOTES);
		$tipo = htmlentities(addslashes($_REQUEST['tipo']), ENT_QUOTES);
		
		$bd = new Bd();
		  $bd->conectar();
	
		switch ($tipo) {
		  case 1:
			$sql_admin = $bd->consulta("SELECT * FROM usuarios WHERE u_usuario = :u_usuario AND u_pass = :u_pass", array(":u_usuario" => $usuario, ":u_pass" => $pass));
	
			if ($sql_admin['cantidad_registros'] == 1) {
			  $session = new Session();
	
			  $array_session_usuario = array('id' => $sql_admin[0]['u_id'],
											  'usuario' => $sql_admin[0]['u_usuario'],
											  'ruta' => 'modulos/admin/',
											  'tipo' => 1
											);
	
			  $session->set('usuario', $array_session_usuario);
			  echo json_encode(array("success" => true, "mjs" => "Ok"));
			}else{
			  echo json_encode(array("success" => false, "mjs" => "El usuario no existe."));
			}
			break;
		  
		  
		  default:
			echo json_encode(array("success" => false, "mjs" => "No se ha definido el tipo de usuario"));
			break;
		}
	
		$bd->desconectar();
	
	  }else{
		echo json_encode(array("success" => false, "mjs" => "Algunos campos no estan definidos."));
	  }
?>