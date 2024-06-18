<?php

class Viaje{
    private $idV;
    private $destino;
    private $cantMaxPasajeros;
    private $objResponsable;
    private $arrayPasajeros;
    private $importe;

    // CONSTRUCTOR
    public function __construct(){
        $this->idV = "";
        $this->destino = "";
        $this->cantMaxPasajeros = "";
        $this->objResponsable = "";
        $this->arrayPasajeros = [];
        $this->importe = "";
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

    public function getObjResponsable(){
        return $this->objResponsable;
    }

    public function getColPasajeros(){
        return $this->arrayPasajeros;
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

    public function setObjResponsable($obj_Responsable){
        $this->objResponsable = $obj_Responsable;
    }

    public function setColPasajeros($colPasajeros){
        $this->arrayPasajeros = $colPasajeros;
    }

    public function setImporte($vImporte){
        $this->importe = $vImporte;
    }

    // TO STRING
    public function __toString(){
        return "Id viaje: " . $this->getIdViaje() . "\n" . 
        "Destino: " . $this->getDestino() . "\n" . 
        "Cant. máxima de pasajeros: " . $this->getCantMaxPasajeros() . "\n" . 
        "Responsable del viaje: \n" . $this->getObjResponsable() . 
        "Pasajeros: \n" . $this->mostrarColeccion($this->getColPasajeros()) . "\n" . 
        "Importe del viaje: $" . $this->getImporte() . "\n";
    }

    private function mostrarColeccion($coleccion){
        $retorno = "";
        foreach ($coleccion as $obj) {
            $retorno .= $obj . "\n";
            $retorno .= "----------------------------------------------------------------------\n";
        }
        return $retorno;
    }

    public function cargar($idViaje, $vDestino, $cantMaxPasajeros,$obj_Responsable, $vImporte)
    {
        $this->setIdViaje($idViaje);
        $this->setDestino($vDestino);
        $this->setCantMaxPasajeros($cantMaxPasajeros);
        $this->setObjResponsable($obj_Responsable);
        $this->setImporte($vImporte);
    }

}