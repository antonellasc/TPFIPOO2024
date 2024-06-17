<?php

class Viaje{
    private $idV;
    private $destino;
    private $cantMaxPasajeros;
    private $objEmpresa;
    private $objResponsable;
    private $importe;

    // CONSTRUCTOR
    public function __construct($idViaje, $vDestino, $cantMaxPasajeros, $obj_Empresa, $obj_Responsable, $vImporte){
        $this->idV = $idViaje;
        $this->destino = $vDestino;
        $this->cantMaxPasajeros = $cantMaxPasajeros;
        $this->objEmpresa = $obj_Empresa;
        $this->objResponsable = $obj_Responsable;
        $this->importe = $vImporte;
    }

    // GETTERS
    public function getIdViaje(){
        return $this->idV;
    }

    public function getDestino(){
        return $this->destino;
    }

    public function getCantMaxPasajeros(){
        return $this->cantMaxPasajeros;
    }

    public function getObjEmpresa(){
        return $this->objEmpresa;
    }

    public function getObjResponsable(){
        return $this->objResponsable;
    }

    public function getImporte(){
        return $this->importe;
    }

    // SETTERS 
    public function setIdViaje($idViaje){
        $this->idV = $idViaje;
    }

    public function setDestino($vDestino){
        $this->destino = $vDestino;
    }

    public function setCantMaxPasajeros($cantMaxPasajeros){
        $this->cantMaxPasajeros = $cantMaxPasajeros;
    }

    public function setObjEmpresa($obj_Empresa){
        $this->objEmpresa = $obj_Empresa;
    }

    public function setObjResponsable($obj_Responsable){
        $this->objResponsable = $obj_Responsable;
    }

    public function setImporte($vImporte){
        $this->importe = $vImporte;
    }

    // TO STRING
    public function __toString(){
        return "Id viaje: " . $this->getIdViaje() . "\n" . 
        "Destino: " . $this->getDestino() . "\n" . 
        "Cant. máxima de pasajeros: " . $this->getCantMaxPasajeros() . "\n" . 
        "Empresa: \n" . $this->getObjEmpresa() . 
        "Responsable del viaje: \n" . $this->getObjResponsable() . 
        "Importe del viaje: $" . $this->getImporte() . "\n";
    }
}