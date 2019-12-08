<?php  
	@session_start();


	class Session{

		private $ambiente;
		
		public function __construct(){
			$this->ambiente="deportech";
		}	
		
		public function set($nombre,$valor){
			if(isset($_SESSION[$nombre.$this->ambiente])){
				$_SESSION[$nombre.$this->ambiente]='';
				unset($_SESSION[$nombre.$this->ambiente]);
			}
			$_SESSION[$nombre.$this->ambiente]=$valor;
		}
		
		public function get($nombre){
			$retorno=false;
			if(isset($_SESSION[$nombre.$this->ambiente])){
				$retorno=$_SESSION[$nombre.$this->ambiente];
			}
			return($retorno);	
		}
		
		public function destroy($nombre){
			if( isset($_SESSION[$nombre.$this->ambiente]) ){
				$_SESSION[$nombre.$this->ambiente]='';
				unset($_SESSION[$nombre.$this->ambiente]);
			}
		}
		
		public function exist($nombre){
			$retorno=false;
			if( isset($_SESSION[$nombre.$this->ambiente]) ){
				$retorno=true;
			}
			return($retorno);
		}
		
		public function setCampo($nombre, $campo, $valor){
			if(isset($_SESSION[$nombre.$this->ambiente][$campo])){
				$_SESSION[$nombre.$this->ambiente][$campo]='';
				unset($_SESSION[$nombre.$this->ambiente][$campo]);
			}
			$_SESSION[$nombre.$this->ambiente][$campo]=$valor;
		}
	}
?>