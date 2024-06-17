<?php

class ResponsableV extends Persona{
    private $nroEmpleado;
    private $nroLicencia;

    public function __construct($nom, $ap, $documento, $nrotel, $rNroEmpleado, $rNroLicencia){
        parent :: __construct($nom, $ap, $documento, $nrotel);
        $this->nroEmpleado = $rNroEmpleado;
        $this->nroLicencia = $rNroLicencia;
    }

    public function getNroEmpleado(){
        return $this->nroEmpleado;
    }

    public function getNroLicencia(){
        return $this->nroLicencia;
    }

    public function setNroEmpleado($rNroEmpleado){
        $this->nroEmpleado = $rNroEmpleado;
    }

    public function setNroLicencia($rNroLicencia){
        $this->nroLicencia = $rNroLicencia;
    }

    public function __toString(){
        return parent :: __toString() . 
        "Nro empleado: " . $this->getNroEmpleado() . "\n" . 
        "Nro licencia: " . $this->getNroLicencia() . "\n";
    }

    // 
    public function cargar($NroD, $Nom, $Ape, $telefono){
        parent :: cargar($NroD, $Nom, $Ape, $telefono);
        $nroempleado = $this->getNroEmpleado();
        $nrolicencia = $this->getNroLicencia();
		$this->setNroEmpleado($nroempleado);
		$this->setNroLicencia($nrolicencia);
    }


    public function insertar(){
        $resp = parent :: insertar();        
    	    $base=new BaseDatos();
		    $resp= false;
    		$consultaInsertar="INSERT INTO responsable(rnumeroempleado, rnumerolicencia, rdocumento) 
                    VALUES ('".$this->getNroEmpleado()."','".$this->getNroLicencia()."','".$this->getNroDoc()."')";
		
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

    public function Buscar($nroempleado){
		$base=new BaseDatos();
		$consultaResp="Select * from resposable where rnumeroempleado=".$nroempleado;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaResp)){
				if($row2=$base->Registro()){					
				    $this->setNroEmpleado($nroempleado);
					$this->setNroLicencia($row2['rnumerolicencia']);
					$this->setNroDoc($row2['rdocumento']);
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
		$consultaModifica="'UPDATE responsable SET apellido ='".$this->getApellido()."', nombre ='".$this->getNombre()."'
                           , telefono ='".$this->getTelefono()."', rnumerolicencia ='".$this->getNroLicencia()."'
                           , rdocumento ='".$this->getNroDoc()."' WHERE rnumeroempleado ='".$this->getNroEmpleado()."";
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
				$consultaBorra="'DELETE FROM responsable WHERE rnumeroempleado ='".$this->getNroEmpleado()."";
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