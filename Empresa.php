<?php

class Empresa{
    private $idEmpresa;
    private $nombreEm;
    private $domicilioEm;

    public function __construct($idE, $eNombre, $eDomicilio){
        $this->idEmpresa = $idE;
        $this->nombreEm = $eNombre;
        $this->domicilioEm = $eDomicilio;
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

    public function __toString(){
        return "Id empresa: " . $this->getIdEmpresa() . "\n" . 
        "Nombre empresa: " . $this->getNombreEmpresa() . "\n" . 
        "Domicilio: " . $this->getDomicilioEmpresa() . "\n";
    }
}