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


  //---------------funciones para las materias-----------------------


  function listaMaterias(){
    $db = new Bd();
    $db->conectar();

    $sql = $db->consulta("SELECT * FROM materias");

    $db->desconectar();

    return json_encode($sql);
  }

  function formCrearMateria(){
    $db = new Bd();
    $db->conectar();

    $db->sentencia("INSERT INTO materias(m_nombre, m_fechaCreacion) VALUES(:m_nombre, :m_fechaCreacion)", array(":m_nombre" => $_REQUEST['nombreMateria'], ":m_fechaCreacion" => date("Y-m-d")));

    $db->desconectar();
  
    return json_encode(array("success" => true, "msj" => "Se ha creado correctamente."));
  }

  function formEditarMateria(){
    $db = new Bd();
    $resp;
    $db->conectar();

    $sql_validar = $db->consulta("SELECT * FROM materias WHERE m_id != :m_id AND m_nombre = :m_nombre", array(":m_id" => $_REQUEST['idMateria'], ":m_nombre" => $_REQUEST['editNombreMateria']));

    if ($sql_validar['cantidad_registros'] == 0) {
      $db->sentencia("UPDATE materias SET m_nombre = :m_nombre WHERE m_id = :m_id", array(":m_id" => $_REQUEST['idMateria'], ":m_nombre" => $_REQUEST['editNombreMateria']));
      $resp = array("success" => true, "msj" => "El nombre se ha actualizado correctamente.");
    }else{
      $resp = array("success" => false, "msj" => "El nombre de la materia ya se encuentra en uso.");
    }

    $db->desconectar();

    return json_encode($resp);
  }

   

  //----------------funciones para los estudiantes-----------------------
      
      function listaEstudiantes(){
        $db = new Bd();
        $db->conectar();
    
        $sql = $db->consulta("SELECT * FROM estudiantes");
    
        $db->desconectar();
    
        return json_encode($sql);
      }
    
      function formCrearEstudiante(){
        $db = new Bd();
        $db->conectar();
    
        $db->sentencia("INSERT INTO estudiantes(e_nroDocumento, e_nombre ,e_nombre1, e_apellido, e_apellido2, e_telefono, e_direccion, e_correo, e_password,e_fechaCreacion) VALUES(:e_nroDocuemnto, :e_nombre,:e_nombre1,:e_apellido,:e_apellido2,:e_telefono,:e_direccion,:e_correo,:e_password,:e_fechaCreacion)", array(":e_nroDocumento" => $_REQUEST['documento'], ":e_nombre" => $_REQUEST['Pnombre'], ":e_nombre1" => $_REQUEST['Snombre'], ":e_apellido" => $_REQUEST['Papellido'], ":e_apellido2" => $_REQUEST['Sapellido'], ":e_telefono" => $_REQUEST['telefono'], ":e_direccion" => $_REQUEST['direccion'], ":e_correo" => $_REQUEST['correo'], ":e_password" => $_REQUEST['password'], ":e_fechaCreacion" => date("Y-m-d")));
    
        $db->desconectar();
      
        return json_encode(array("success" => true, "msj" => "Se ha creado correctamente."));
      }
    
      function formEditarEstudiante(){
        $db = new Bd();
        $resp;
        $db->conectar();
    
        $sql_validar = $db->consulta("SELECT * FROM estudiantes WHERE e_id != :e_id AND e_nombre = :e_nombre", array(":e_id" => $_REQUEST['idEstudiante'], ":e_nombre" => $_REQUEST['nombre']));
    
        if ($sql_validar['cantidad_registros'] == 0) {
          $db->sentencia("UPDATE estudiantes SET e_nombre = :e_nombre WHERE e_id = :e_id", array(":e_id" => $_REQUEST['idEstudiante'], ":e_nombre" => $_REQUEST['nombre']));
          $resp = array("success" => true, "msj" => "El nombre se ha actualizado correctamente.");
        }else{
          $resp = array("success" => false, "msj" => "El nombre de la materia ya se encuentra en uso.");
        }
        $db->desconectar();

    return json_encode($resp);
      }

      //------------funciones para los profesores---------------

      function listaProfesor(){
        $db = new Bd();
        $db->conectar();
    
        $sql = $db->consulta("SELECT * FROM profesores join materias ");
    
        $db->desconectar();
    
        return json_encode($sql);
      }
    
      function formCrearProfesor(){
        $db = new Bd();
        $db->conectar();
    
        $db->sentencia("INSERT INTO profesores(e_nroDocumento, e_nombre ,e_nombre1, e_apellido, e_apellido2, e_telefono, e_direccion, e_correo, e_password, fk_materia,e_fechaCreacion) VALUES(:e_nroDocuemnto, :e_nombre,:e_nombre1,:e_apellido,:e_apellido2,:e_telefono,:e_direccion,:e_correo,:e_password,:fk_materia,:e_fechaCreacion)", array(":e_nroDocumento" => $_REQUEST['documento'], ":e_nombre" => $_REQUEST['Pnombre'], ":e_nombre1" => $_REQUEST['Snombre'], ":e_apellido" => $_REQUEST['Papellido'], ":e_apellido2" => $_REQUEST['Sapellido'], ":e_telefono" => $_REQUEST['telefono'], ":e_direccion" => $_REQUEST['direccion'], ":e_correo" => $_REQUEST['correo'], ":e_password" => $_REQUEST['password'], ":fk_materia" => $_REQUEST['materia'], ":e_fechaCreacion" => date("Y-m-d")));
    
        $db->desconectar();
      
        return json_encode(array("success" => true, "msj" => "Se ha creado correctamente."));
      }
    
      function formEditarProfesor(){
        $db = new Bd();
        $resp;
        $db->conectar();
    
        $sql_validar = $db->consulta("SELECT * FROM profesores  WHERE p_id != :p_id AND p_nombre = :p_nombre", array(":p_id" => $_REQUEST['idProfesor'], ":m_nombre" => $_REQUEST['editNombreProfesor']));
    
        if ($sql_validar['cantidad_registros'] == 0) {
          $db->sentencia("UPDATE profesores SET p_nombre = :p_nombre WHERE p_id = :p_id", array(":p_id" => $_REQUEST['idProfesor'], ":p_nombre" => $_REQUEST['editNombreProfesor']));
          $resp = array("success" => true, "msj" => "El nombre se ha actualizado correctamente.");
        }else{
          $resp = array("success" => false, "msj" => "El nombre de la materia ya se encuentra en uso.");
        }
        $db->desconectar();

    return json_encode($resp);
      }

  if(@$_REQUEST['accion']){
    if(function_exists($_REQUEST['accion'])){
      echo($_REQUEST['accion']());
    }
  }
?>