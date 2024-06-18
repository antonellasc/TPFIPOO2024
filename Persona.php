<?php 

class Persona {
    private $nombre;
    private $apellido;
    private $nroDoc;
    private $telefono;
	private $mensajeoperacion;

    public function __construct(){
        $this->nombre = "";
        $this->apellido = "";
        $this->nroDoc = "";
        $this->telefono = "";
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getApellido(){
        return $this->apellido;
    }

    public function getNroDoc(){
        return $this->nroDoc;
    }

    public function getTelefono(){
        return $this->telefono;
    }

    public function setNombre($nom){
        $this->nombre = $nom;
    }

    public function setApellido($ap){
        $this->apellido = $ap;
    }

    public function setNroDoc($documento){
        $this->nroDoc = $documento;
    }

    public function setTelefono($nrotel){
        $this->telefono = $nrotel;
    }

    public function __toString(){
        return "Nombre: " . $this->getNombre() . "\n" . 
        "Apellido: " . $this->getApellido() . "\n" . 
        "Nro documento: " . $this->getNroDoc() . "\n" . 
        "Nro telefono: " . $this->getTelefono() . "\n";
    }

    //
    public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}

    public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}

    public function cargar($NroD, $Nom, $Ape, $telefono){		
		$this->setNrodoc($NroD);
		$this->setNombre($Nom);
		$this->setApellido($Ape);
		$this->setTelefono($telefono);
    }

    public function Buscar($dni){
		$base=new BaseDatos();
		$consultaPersona="Select * from persona where nrodoc=".$dni;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersona)){
				if($row2=$base->Registro()){					
				    $this->setNroDoc($dni);
					$this->setNombre($row2['nombre']);
					$this->setApellido($row2['apellido']);
					$this->setTelefono($row2['telefono']);
					$resp= true;
				}				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }		
		 return $resp;
	}	
 

	public function listar($condicion=""){
	    $arreglo = null;
		$base=new BaseDatos();
		$consultaPersonas="Select * from persona ";
		if ($condicion!=""){
		    $consultaPersonas=$consultaPersonas.' where '.$condicion;
		}
		$consultaPersonas.=" order by apellido ";
		//echo $consultaPersonas;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersonas)){				
				$arreglo= array();
				while($row2=$base->Registro()){
					
					$NroDoc=$row2['nrodoc'];
					$Nombre=$row2['nombre'];
					$Apellido=$row2['apellido'];
					$Telefono=$row2['telefono'];
				
					$perso=new Persona();
					$perso->cargar($NroDoc,$Nombre,$Apellido,$Telefono);
					array_push($arreglo,$perso);
	
				}
				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }	
		 return $arreglo;
	}


    public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO persona(nombre, apellido, nrodoc, telefono) 
                VALUES ('".$this->getNombre()."','".$this->getApellido()."','".$this->getNroDoc()."','".$this->getTelefono()."')";
		
		if($base->Iniciar()){

			if($base->Ejecutar($consultaInsertar)){

			    $resp=  true;

			}	else {
					$this->setmensajeoperacion($base->getError());
					
			}

		} else {
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
	}

    public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
		$consultaModifica="'UPDATE persona SET apellido ='".$this->getApellido()."', nombre ='".$this->getNombre()."'
                           , telefono ='".$this->getTelefono()."' WHERE nrodoc ='".$this->getNroDoc()."";
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
			    $resp=  true;
			}else{
				$this->setmensajeoperacion($base->getError());
				
			}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
	}

    public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="'DELETE FROM persona WHERE nrodoc ='".$this->getNroDoc()."";
				if($base->Ejecutar($consultaBorra)){
				    $resp=  true;
				}else{
						$this->setmensajeoperacion($base->getError());
					
				}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp; 
	}


}