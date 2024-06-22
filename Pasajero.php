<?php

class Pasajero extends Persona {
    private $nroPasajeroFrecuente;
	private $objViaje;
	private $mensajeoperacion;

    public function __construct(){
        parent :: __construct();
        $this->nroPasajeroFrecuente = "";
        $this->objViaje = null;
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
    public function cargar($datosPasajero){
        parent :: cargar($datosPasajero);
		$this->setNroPFrecuente($datosPasajero['nropfrecuente']);
		$this->setObjViaje($datosPasajero['idviaje']);
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
		$consultaPas="Select * from pasajero where nrodoc=".$dni;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPas)){
				if($row2=$base->Registro()){					
				    parent::Buscar($dni);

				    $this->setNroDoc($dni);
					$this->setNroPFrecuente($row2['nropfrecuente']);
					$this->setObjViaje($row2['idviaje']);
					
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
	    $arreglo = [];
		$base=new BaseDatos();
		$consultaPasajeros="Select * from pasajero ";
		if ($condicion!=""){
		    $consultaPasajeros=$consultaPasajeros.' where '.$condicion;
		}
		$consultaPasajeros.=" order by nrodoc ";
		//echo $consultaPasajeros;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPasajeros)){				
				$arreglo= array();
				while($row2=$base->Registro()){
					$nrodoc = $row2['nrodoc'];
					$pasajero=new Pasajero();

					$pasajero->Buscar($nrodoc);
					array_push($arreglo,$pasajero);
	
	
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
        $respP = parent :: insertar();
        	$base=new BaseDatos();
		    $resp= false;

			if($respP){
				$idReferenciaViaje = $this->getObjViaje()->getIdViaje();

				$consultaInsertar="INSERT INTO pasajero(nrodoc, nropfrecuente, idviaje) 
                VALUES ('".parent::getNroDoc()."','".$this->getNroPFrecuente()."','" . $idReferenciaViaje . "')";
				if($base->Iniciar()){

					if($base->Ejecutar($consultaInsertar)){
						$resp=  true;
					}	else {
							$this->setmensajeoperacion($base->getError());
					}

				} else {
						$this->setmensajeoperacion($base->getError());	
				}
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


    public function eliminar($nroDoc){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="'DELETE FROM pasajero WHERE nrodoc ='".$this->getNroDoc()."";
				if($base->Ejecutar($consultaBorra)){
				    if (parent::eliminar($nroDoc)) {
						$resp = true;
					}
				}else{
						$this->setmensajeoperacion($base->getError());
					
				}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp; 
	}
        
}
