<?php

class Pasajero extends Persona {
    private $nroPasajeroFrecuente;
	private $objViaje;
	private $mensajeoperacion;

    public function __construct(){
        parent :: __construct();
        $this->nroPasajeroFrecuente = "";
        $this->objViaje = "";
    }

    public function getNroPFrecuente(){
        return $this->nroPasajeroFrecuente;
    }

    public function getObjViaje(){
        return $this->objViaje;
    }

    public function setNroPFrecuente($nroPFrecuente){
        $this->nroPasajeroFrecuente = $nroPFrecuente;
    }

    public function setObjViaje($obj_Viaje){
        $this->objViaje = $obj_Viaje;
    }

    public function __toString(){
        return parent :: __toString() . 
        "Nro pasajero frecuente: " . $this->getNroPFrecuente() . "\n" . 
        "Datos del viaje: \n" . $this->getObjViaje() ;
    }

    // 
    public function cargar($NroD, $Nom, $Ape, $telefono){
        parent :: cargar($NroD, $Nom, $Ape, $telefono);
        $nropfrecuente = $this->getNroPFrecuente();
        $obj_Viaje = $this->getObjViaje();
		$this->setNroPFrecuente($nropfrecuente);
		$this->setObjViaje($obj_Viaje);
    }

	public function getmensajeoperacion()
	{
		return $this->mensajeoperacion;
	}
	public function setmensajeoperacion($mensajeoperacion)
	{
		$this->mensajeoperacion = $mensajeoperacion;
	}
	public function Buscar($dni){
		$base=new BaseDatos();
		$consultaPas="Select * from pasajero where pdocumento=".$dni;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPas)){
				if($row2=$base->Registro()){					
				    $this->setNroDoc($dni);
					$this->setNroPFrecuente($row2['nropfrecuente']);
					$this->setObjViaje($row2['idviaje']);
					// $this->setTelefono($row2['telefono']);
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
		$consultaPasajeros="Select * from pasajero ";
		if ($condicion!=""){
		    $consultaPasajeros=$consultaPasajeros.' where '.$condicion;
		}
		$consultaPasajeros.=" order by apellido ";
		//echo $consultaPasajeros;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPasajeros)){				
				$arreglo= array();
				while($row2=$base->Registro()){
					
					$NroDoc=$row2['nrodoc'];
					$Nombre=$row2['nombre'];
					$Apellido=$row2['apellido'];
					$Telefono=$row2['telefono'];
					$NroPFrecuente=$row2['nropfrecuente'];
					$ObjViaje=$row2['idviaje'];
				
					$pasaj=new Pasajero();
					$pasaj->cargar($NroDoc,$Nombre,$Apellido,$Telefono, $NroPFrecuente, $ObjViaje);
					array_push($arreglo,$pasaj);
	
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
        $resp = parent :: insertar();
        	$base=new BaseDatos();
		    $resp= false;
		    $consultaInsertar="INSERT INTO pasajero(nrodoc, nropfrecuente, idviaje) 
                VALUES ('".$this->getNroDoc()."','".$this->getNroPFrecuente()."','".$this->getObjViaje()."')";
		
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
		$consultaModifica="'UPDATE pasajero SET apellido ='".$this->getApellido()."', nombre ='".$this->getNombre()."'
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
				$consultaBorra="'DELETE FROM pasajero WHERE nrodoc ='".$this->getNroDoc()."";
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
