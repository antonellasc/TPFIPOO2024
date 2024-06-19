<?php

class Empresa{
    private $idEmpresa;
    private $nombreEm;
    private $domicilioEm;
    private $arregloViajes;
    private $mensajeoperacion;

    public function __construct($idEmpresa, $nombreEm, $domicilioEm){
        $this->idEmpresa = "";
        $this->nombreEm = "";
        $this->domicilioEm = "";
        $this->arregloViajes = [];
    }

    public function getIdEmpresa(){
        return $this->idEmpresa;
    }

    public function getNombreEmpresa(){
        return $this->nombreEm;
    }

    public function getDomicilioEmpresa(){
        return $this->domicilioEm;
    }

    public function getArregloViajes(){
        return $this->arregloViajes;
    }

    public function setIdEmpresa($idE){
        $this->idEmpresa = $idE;
    }

    public function setNombreEmpresa($eNombre){
        $this->nombreEm = $eNombre;
    }

    public function setDomicilioEmpresa($eDomicilio){
        $this->domicilioEm = $eDomicilio;
    }

    public function setArregloViajes($arregloViajes){
        $this->arregloViajes = $arregloViajes;
    }

    public function getmensajeoperacio(){
        return $this->mensajeoperacion;
    }

    public function setmensajeoperacion($mensajeoperacion){
        $this->mensajeoperacion= $mensajeoperacion;
    }

    public function __toString(){
        return "Id empresa: " . $this->getIdEmpresa() . "\n" . 
        "Nombre empresa: " . $this->getNombreEmpresa() . "\n" . 
        "Domicilio: " . $this->getDomicilioEmpresa() . "\n". 
        "Coleccion de Viajes: ". $this->mostrarColeccionViajes($this->getArregloViajes()). "\n";
    }

    private function mostrarColeccionViajes($coleccion){
        $retorno = "";
        foreach ($coleccion as $obj) {
            $retorno .= $obj . "\n";
            $retorno .= "----------------------------------------------------------------------\n";
        }
        return $retorno;
    }

    public function incorporarViaje($viaje) {
        // Verificar si el $viaje ya existe en la empresa utilizando la función Buscar
        $existeViaje = $this->Buscar($viaje->getIdViaje());
        $seAgrego = true;
        if ($existeViaje) {
            echo "Error: El viaje con ID:". $viaje->getIdViaje(). " ya existe en la empresa.\n";
            $seAgrego= false;
        }
        $this->arregloViajes[] = $viaje;
        return $seAgrego; // Indica que el viaje se agregó correctamente
    }

    public function Buscar($idViaje) {
        $bandera = false;
        foreach ($this->arregloViajes as $viaje) {
            if ($viaje->getIdViaje() == $idViaje) {
                $bandera = true; 
            }
        }
        return $bandera; 
    }

    // funciones sql
    public function cargar($idE, $enombre, $edomicilio, $colviajes){
        $this->setIdEmpresa($idE);
		$this->setNombreEmpresa($enombre);
		$this->setDomicilioEmpresa($edomicilio);
        $this->setArregloViajes($colviajes);
    }

    public function buscar($id){
		$base=new BaseDatos();
		$consultaEmp="Select * from empresa where idempresa=".$id;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaEmp)){
				if($row2=$base->Registro()){					
				    $this->setIdEmpresa($id);
					$this->setNombreEmpresa($row2['enombre']);
					$this->setDomicilioEmpresa($row2['edireccion']);
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
		$consultaEmpresa="Select * from empresa ";
		if ($condicion!=""){
		    $consultaEmpresa=$consultaEmpresa.' where '.$condicion;
		}
		$consultaEmpresa.=" order by idempresa ";
		//echo $consultaPasajeros;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaEmpresa)){				
				$arreglo= array();
				while($row2=$base->Registro()){
					
					$id=$row2['idempresa'];
					$nombre=$row2['enombre'];
					$direccion=$row2['edireccion'];
					
				
					$empr=new Empresa();
					$empr->cargar($id,$nombre,$direccion, []);
					array_push($arreglo,$empr);
	
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
		    $consultaInsertar="INSERT INTO empresa(idempresa, enombre, edireccion) 
                VALUES ('".$this->getIdEmpresa()."','".$this->getNombreEmpresa()."','".$this->getDomicilioEmpresa()."')";
		
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
		$consultaModifica="'UPDATE empresa SET enombre ='".$this->getNombreEmpresa()."', edireccion ='".$this->getDomicilioEmpresa()."'
                           WHERE idempresa ='".$this->getIdEmpresa()."";
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
				$consultaBorra="'DELETE FROM empresa WHERE idempresa ='".$this->getIdEmpresa()."";
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