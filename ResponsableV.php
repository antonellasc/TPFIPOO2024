<?php

class ResponsableV extends Persona{
    private $nroEmpleado;
    private $nroLicencia;

    public function __construct(){
        parent :: __construct();
        $this->nroEmpleado = "";
        $this->nroLicencia = "";
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
    public function cargar($datosResponsable){
        parent :: cargar($datosResponsable);
		$this->setNroEmpleado($datosResponsable['rnumeroempleado']);
		$this->setNroLicencia($datosResponsable['rnumerolicencia']);
    }


    public function insertar(){
        $base=new BaseDatos();
		$resp= false;

		if($resp = parent :: insertar()){
			$consultaInsertar="INSERT INTO responsable(rnumeroempleado, rnumerolicencia, rdocumento) 
            VALUES ('".$this->getNroEmpleado()."','".$this->getNroLicencia()."','".$this->getNroDoc()."')";

			if($base->Iniciar()){
				if($base->Ejecutar($consultaInsertar)){
					$resp=  true;
				}else {
					$this->setmensajeoperacion($base->getError());	
				}
			} else {
				$this->setmensajeoperacion($base->getError());
			}
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
				    parent::Buscar($row2['rdocumento']);			
				    $this->setNroEmpleado($row2['rnumeroempleado']);
					$this->setNroLicencia($row2['rnumerolicencia']);

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
		if(parent::modificar()){
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
		}
		return $resp;
	}


    public function eliminar($nroDoc){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM responsable WHERE rnumeroempleado ='".$this->getNroEmpleado()."";
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

	public function listar($condicion = ""){
		$arregloResponsables = [];
		$base = new BaseDatos();
		$consultaResponsables = "SELECT * FROM responsable ";
	
		if ($condicion != "") {
			$consultaResponsables .= ' WHERE ' . $condicion;
		}
	
		$consultaResponsables .= " ORDER BY apellido";
	
		if ($base->Iniciar()) {
			if ($base->Ejecutar($consultaResponsables)) {
				$arregloResponsables = [];
				while ($row = $base->Registro()) {
					$responsable = new ResponsableV();
					$responsable->Buscar($row['rdocumento']); 
	
					array_push($arregloResponsables, $responsable);
				}
			} else {
				$this->setmensajeoperacion($base->getError());
			}
		} else {
			$this->setmensajeoperacion($base->getError());
		}
	
		return $arregloResponsables;
	}

}