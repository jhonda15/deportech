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

  require_once($ruta_raiz . "clases/Conectar.php");
  require_once($ruta_raiz . "clases/funciones_generales.php");
  

  //----------------funciones para los jugadores-----------------------
      
      function listarJugadores(){
        $db = new Bd();
        $db->conectar();
    
        $sql = $db->consulta("SELECT * FROM jugadores");
    
        $db->desconectar();
    
        return json_encode($sql);
      }
    
      function formCrearjugadores(){
        $db = new Bd();
        $db->conectar();
    
        $db->sentencia("INSERT INTO jugadores (j_nroDocumento, j_nombre , j_apellido, j_direccion, j_telefono, j_correo,j_eps,j_talla,j_peso,j_dominacion,j_numeroCamisa,j_edad,j_foto, ) VALUES(:j_nroDocumento, :j_nombre,:j_apellido,:j_direccion,:j_telefono,:j_correo,:j_eps,:j_talla,:j_peso,:j_dominacion,:j_numeroCamisa,:j_edad,:j_foto)", array(":j_nroDocumento" => $_REQUEST['documento'], ":j_nombre" => $_REQUEST['nombre'], ":j_apellido" => $_REQUEST['apellido'], ":j_direccion" => $_REQUEST['direccion'], ":j_telefono" => $_REQUEST['telefono'] ,":j_correo" => $_REQUEST['correo'], ":j_eps" => $_REQUEST['eps'],":j_talla" => $_REQUEST['talla'],":j_peso" => $_REQUEST['peso'],":j_dominacion" => $_REQUEST['dominacion'],":j_numeroCamisa" => $_REQUEST['numeroCamisa'],":j_edad" => $_REQUEST['edad'],":j_foto" => $_REQUEST['foto']));
    
        $db->desconectar();
      
        return json_encode(array("success" => true, "msj" => "Se ha creado correctamente."));
      }
    
      function formEditarjugadores(){
        $db = new Bd();
        $resp;
        $db->conectar();
    
        $sql_validar = $db->consulta("SELECT * FROM jugadores WHERE j_id != :j_id AND e_nombre = :e_nombre", array(":e_id" => $_REQUEST['idEstudiante'], ":e_nombre" => $_REQUEST['nombre']));
    
        if ($sql_validar['cantidad_registros'] == 0) {
          $db->sentencia("UPDATE jugadores SET e_nombre = :e_nombre WHERE e_id = :e_id", array(":e_id" => $_REQUEST['idEstudiante'], ":e_nombre" => $_REQUEST['nombre']));
          $resp = array("success" => true, "msj" => "El nombre se ha actualizado correctamente.");
        }else{
          $resp = array("success" => false, "msj" => "El nombre de la materia ya se encuentra en uso.");
        }
        $db->desconectar();

    return json_encode($resp);
      }


      //----------------funciones para los partidos-----------------------
      
      function listarPartidos(){
        $db = new Bd();
        $db->conectar();
    
        $sql = $db->consulta("SELECT * FROM partidos INNER JOIN jugadores ON j_id = j_id");
    
        $db->desconectar();
    
        return json_encode($sql);
      }
      

  if(@$_REQUEST['accion']){
    if(function_exists($_REQUEST['accion'])){
      echo($_REQUEST['accion']());
    }
  }
?>