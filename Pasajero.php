<?php

class Pasajero extends Persona {
	private $nroTicket;
	private $nroAsiento;
	private $objViaje;
	private $mensajeoperacion;

    public function __construct(){
        parent :: __construct();
		$this->nroTicket = "";
		$this->nroAsiento = "";
        $this->objViaje = null;
    }

	public function getTicket(){
        return $this->nroTicket;
    }

	public function getAsiento(){
		return $this->nroAsiento;
	}

    public function getObjViaje(){
        return $this->objViaje;
    }

	public function setTicket($nroTicket){
        $this->nroTicket = $nroTicket;
    }

	public function setAsiento($nroAsiento){
		$this->nroAsiento=$nroAsiento;
	}

    public function setObjViaje($obj_Viaje){
        $this->objViaje = $obj_Viaje;
    }

    public function __toString(){
        return parent :: __toString() . 
		"Nro de ticket:" . $this->getTicket() . "\n" . 
		"Nro de Asiento:". $this->getAsiento(). "\n". 
        "ID viaje: " . $this->getObjViaje() ;
    }

    // 
    public function cargar($datosPasajero){
        parent :: cargar($datosPasajero);
		$this->setTicket($datosPasajero['nroticket']);
		$this->setAsiento($datosPasajero['nroasiento']);
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
					$this->setTicket($row2['nroticket']);
					$this->setAsiento($row2['nroasiento']);
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
		$consultaPasajeros.=" order by nroticket";
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
        	$base=new BaseDatos();
		    $resp= false;

			if(parent :: insertar()){
				$idReferenciaViaje = $this->getObjViaje();

				$consultaInsertar="INSERT INTO pasajero( nroasiento, idviaje,nrodoc) 
                VALUES ('".$this->getAsiento()."','" . $idReferenciaViaje . "','". parent::getNroDoc()."')";

				if($base->Iniciar()){
					$nroTicket = $base->devuelveIDInsercion($consultaInsertar);
            		if ($nroTicket) {
                		$this->setTicket($nroTicket);
                		$resp = true;
            		} else {
                		$this->setMensajeOperacion($base->getError());
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
		if(parent::modificar()){
			$consultaModifica="UPDATE pasajero SET nroasiento =".$this->getAsiento().", nroticket =".$this->getTicket().",idviaje=".$this->getObjViaje()."
							 WHERE nrodoc =". $this->getNroDoc();
			if($base->Iniciar()){
				if($base->Ejecutar($consultaModifica)){
			    	$resp=  true;
				}else{
				$this->setmensajeoperacion($base->getError());
				}
			}else{
				$this->setmensajeoperacion($base->getError());
			}
		}
		return $resp;
	}


    public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
			$consultaBorra="DELETE FROM pasajero WHERE nrodoc ='".$this->getNroDoc()."'";
			if($base->Ejecutar($consultaBorra)){
			    if (parent::eliminar()) {
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
