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
  //Esta es la ruta disco desde la raiz del serviddor hasta donde se encuentran los scripts
  define("RUTA_RAIZ","/deportech/"); 

  //Zona Horaria
  date_default_timezone_set('America/Bogota');

    //Valida que los campso no esten en blanco
  function textoblanco($texto){
    $conv= array(" " => "");
    //Guardamos el resultado en una variable
    $textblanco = strtr($texto, $conv);
    /* Cuenta cuantos caracteres tiene el texto */
    $cont = strlen($textblanco);
    /* Retornamos la cantidad */
    return $cont;
  }

  //Encripta el password en el formato deseado
  function encriptarPass($pass){
    return md5($pass);
  }

  function fecha_db_insertar($fecha,$formato='Y-m-d H:i:s'){ 
    switch (BDTYPE) {
      case 1: //mysql
        
        break;
      case 2: //oracle
          $mystring = $fecha;
        $findme   = 'TO_DATE';
        $pos = strpos($mystring, $findme);
        if ($pos === false) {
              $reemplazos=array('M'=>'MON','H'=>'HH24','d'=>'DD','m'=>'MM','Y'=>'YYYY','y'=>'YY','h'=>'HH','i'=>'MI','s'=>'SS','yyyy'=>'YYYY' );
              $resfecha=$formato;
              foreach ($reemplazos as $ph => $mot){ 
                $resfecha=preg_replace('/'.$ph.'/', "$mot", $resfecha);
              }
      
            $fsql="TO_DATE('$fecha','$resfecha')";
        }else{
          $fsql=$fecha;
        } 
        $fecha=$fsql;
              
        break;
      case 3: //sqlServer 
        $fecha=trim($fecha);
        $fecha=str_replace(' ', 'T', $fecha);
        break;
      default:
        break;
    }
    
    return($fecha);
      
  }

  function cadena_db_insertar($cadena){
    $cadena=htmlentities($cadena, ENT_NOQUOTES, "UTF-8",false);
    $cadena=htmlspecialchars_decode($cadena,ENT_NOQUOTES);    
    switch (BDTYPE) {
      case 1: //mysql
        
        break;
      case 2: //oracle
        
        break;
      case 3: //sqlServer 
        
        break;
      default:
        break;
    }
      
    return($cadena);    
  }

  function fecha_db_obtener($fecha,$formato='Y-m-d'){
    $fecha_retornar='';
    switch (BDTYPE) {
      case 1: //mysql
        if($fecha){
          $date = new DateTime($fecha);
          $fecha_retornar= $date->format($formato);       
        }

        break;
      case 2: //oracle
        
        break;
      case 3: //sqlServer 
        if(is_object($fecha)){
          $fecha_retornar=$fecha->format($formato);
        }elseif ($fecha) {
          $date = new DateTime($fecha);
          $fecha_retornar= $date->format($formato);       
        }
        break;
      default:
        break;
    }
    return($fecha_retornar);  
  }


?>