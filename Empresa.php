<?php

class Empresa{
    private $idEmpresa;
    private $nombreEm;
    private $domicilioEm;
    private $arregloViajes;


    public function __construct($idEmpresa, $nombreEm, $domicilioEm){
        $this->idEmpresa = $idEmpresa;
        $this->nombreEm = $nombreEm;
        $this->domicilioEm = $domicilioEm;
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
}