<?php

class Empresa{
    private $idEmpresa;
    private $nombreEm;
    private $domicilioEm;
    private $mensajeoperacion;

    public function __construct(){
        $this->idEmpresa = "";
        $this->nombreEm = "";
        $this->domicilioEm = "";
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

    public function setIdEmpresa($idE){
        $this->idEmpresa = $idE;
    }

    public function setNombreEmpresa($eNombre){
        $this->nombreEm = $eNombre;
    }

    public function setDomicilioEmpresa($eDomicilio){
        $this->domicilioEm = $eDomicilio;
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
        "Domicilio: " . $this->getDomicilioEmpresa() . "\n";
    }

    // funciones sql
    public function cargar($idE, $enombre, $edomicilio){
        $this->setIdEmpresa($idE);
		$this->setNombreEmpresa($enombre);
		$this->setDomicilioEmpresa($edomicilio);
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
					
				
					$empr = new Empresa();
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