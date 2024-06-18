<?php

class Empresa{
    private $idEmpresa;
    private $nombreEm;
    private $domicilioEm;
    private $arregloViajes;


    public function __construct(){
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

    public function __toString(){
        return "Id empresa: " . $this->getIdEmpresa() . "\n" . 
        "Nombre empresa: " . $this->getNombreEmpresa() . "\n" . 
        "Domicilio: " . $this->getDomicilioEmpresa() . "\n". 
        "Coleccion de Viajes: ". $this->getArregloViajes(). "\n";
    }
}