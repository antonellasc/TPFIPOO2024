<?php

class Pasajero extends Persona {
    private $nroPasajeroFrecuente;
    private $objViaje;

    public function __construct($nom, $ap, $documento, $nrotel, $nroPFrecuente, $obj_Viaje){
        parent :: __construct($nom, $ap, $documento, $nrotel);
        $this->nroPasajeroFrecuente = $nroPFrecuente;
        $this->objViaje = $obj_Viaje;
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
