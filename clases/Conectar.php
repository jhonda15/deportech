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

  //Se llama la configuracion inicial
  require_once($ruta_raiz . 'clases/config.php');
  
  class Bd{

    private $servidor;
    private $user;
    private $pass;
    private $bd;
    private $type;
    private $conexion;
    private $result;
    private $vector_consulta = array();

    public function __construct($bd=BDNAME_MYSQL,$servidor=BDSERVER_MYSQL,$user=BDUSER_MYSQL,$pass=BDPASS_MYSQL,$type=BDTYPE_MYSQL){
      $this->servidor = $servidor;
      $this->user = $user;
      $this->pass = $pass;
      $this->bd = $bd;
      $this->type = $type;
    }

    public function conectar(){
      switch ($this->type) {
        case 1: //MySQl
          try {
            $this->conexion = new PDO('mysql:host='. $this->servidor .'; dbname=' . $this->bd, $this->user, $this->pass);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexion->exec('SET CHARACTER SET utf8');
          } catch (Exception $e) {
            die("Error " . $e->getMessage() . "\n
            Línea del Error " . $e->getLine());
          }
          break;

        case 2: //Oracle
              try {
            $this->conexion = new PDO('oci:dbname=' . $this->servidor .  '/' . $this->bd .';charset=AL32UTF8', $this->user, $this->pass);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          } catch (Exception $e) {
            die("Error " . $e->getMessage() . "\n
            Línea del Error " . $e->getLine());
          }
          break;
          break;

        case 3: //SQL server
          try {
            $this->conexion = new PDO('sqlsrv:Server=' . $this->servidor . ';Database=' . $this->bd, $this->user, $this->pass);
            $this->conexion->exec("SET NAMES utf8 COLLATE utf8_unicode_ci");
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );   
          } catch (Exception $e) {
            die("Error " . $e->getMessage() . "\n
            Línea del Error " . $e->getLine());
          }

          break;
        default:
          # code...
          break;
      }
    }

    public function consulta($sql, $prepare=array()){
      
      $this->vector_consulta = array();

      $this->result = $this->conexion->prepare($sql); 


      $this->result->execute($prepare);

      $cont = 0;
      $this->vector_consulta['sql'] = $this->remplazarSQL($sql, $prepare);
      $this->vector_consulta['cantidad_registros'] = 0;
      $this->vector_consulta['cantidad_columnas'] = $this->result->columnCount();


      while ($reg = $this->result->fetch(PDO::FETCH_BOTH)) {
        $this->vector_consulta[] = $reg;
        $cont++;
      }

      $this->vector_consulta['cantidad_registros'] = $cont;

      $this->result->closeCursor();
      return($this->vector_consulta);
    }

    public function sentencia($sql,$prepare=array()){
      $this->result = $this->conexion->prepare($sql); 
      $this->result->execute($prepare);
    }


    public function desconectar(){
      $this->vector_consulta = array();
      $this->result = null;
      $this->conexion = null;
    }

    public function remplazarSQL($sql, $array = array()){
      if(!count($array)){
        return($sql);
      }
      
      $sql_final = "";
      foreach ($array as $fila => $valor) {
        $sql_final = str_replace($fila, $valor, $sql);
      }

      return $sql_final;
    }

    public function campo_array($campo=''){
      $array=array();
      if($campo!=''){
        for($i=0;$i<$this->vector_consulta['cantidad_registros'];$i++){
          $array[]=@$this->vector_consulta[$i][$campo];
        }
      }
      if( count($array)>0 ){
        return($array);
      }
      return(false);
    }

  }

?>
