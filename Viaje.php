<?php

class Viaje{
    private $idV;
    private $destino;
    private $cantMaxPasajeros;
    private $objResponsable;
    private $arrayPasajeros;
    private $importe;
    private $mensajeoperacion;


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

    public function getmensajeoperacio(){
        return $this->mensajeoperacion;
    }
    public function setmensajeoperacion($mensajeoperacion){
        $this->mensajeoperacion= $mensajeoperacion;
    }

    public function Listar($condicion = "")
    {
        $arregloViajes = [];
        $base = new BaseDatos();
        $consultaViajes = "SELECT * FROM viaje ";

        if ($condicion != "") {
            $consultaViajes .= ' WHERE ' . $condicion;
        }

        $consultaViajes .= " ORDER BY destino";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaViajes)) {
                $arregloViajes = [];
                while ($row = $base->Registro()) {
                    $viaje = new Viaje();
                    $viaje->setIdViaje($row['idviaje']);
                    $viaje->setDestino($row['vdestino']);
                    $viaje->setCantMaxPasajeros($row['vcantmaxpasajeros']);

                    $idResponsable = $row['rnumeroempleado']; 
                    $responsable = new ResponsableV();
                    if ($responsable->Buscar($idResponsable)) {
                        $this->setObjResponsable($responsable);
                    }

                    $arregloPasajeros = $this->listar($viaje->getIdViaje());
                    $viaje->setColPasajeros($arregloPasajeros);

                    $viaje->setImporte($row['vimporte']);

                    array_push($arregloViajes, $viaje);
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }

        return $arregloViajes;
    }

    public function Buscar($idViaje) {
        $base = new BaseDatos();
        $consulta = "SELECT * FROM viaje WHERE idviaje = " . $idViaje; 
        $resp = false;

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                if ($row = $base->Registro()) {
                    $this->setIdViaje($idViaje);
                    $this->setDestino($row['vdestino']);
                    $this->setCantMaxPasajeros($row['vcantmaxpasajeros']);
                    $this->setImporte($row['vimporte']);

                    // Cargar el objeto ResponsableV asociado al viaje
                    $idResponsable = $row['rnumeroempleado']; 
                    $responsable = new ResponsableV();
                    if ($responsable->Buscar($idResponsable)) {
                        $this->setObjResponsable($responsable);
                    }


                    // Cargar el arreglo de Pasajeros asociados al viaje
                    $consultaPasajeros = "SELECT * FROM pasajero WHERE idviaje = " . $idViaje;
                    if ($base->Ejecutar($consultaPasajeros)) {
                        while ($rowPasajero = $base->Registro()) {
                            $dniPasajero = $rowPasajero['pdocumento']; 
                            $pasajero = new Pasajero(); 
                            if ($pasajero->Buscar($dniPasajero)) {
                                $this->arrayPasajeros[] = $pasajero;
                            }
                        }
                    } else {
                        $this->setmensajeoperacion($base->getError());
                    }

                    $resp = true;
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }

        return $resp;
    }

    public function Insertar(){
        $base = new BaseDatos();
        $resp = false;
        $destino = $this->getDestino();
        $max_pasajeros = $this->getCantMaxPasajeros();
        $importe = $this->getImporte();

        $consulta_insertar = "INSERT INTO viaje(vdestino, vcantmaxpasajeros, vimporte)
		VALUES ('{$destino}', '{$max_pasajeros}', '{$importe}')";

        if ($base->Iniciar()) {
            $idViaje = $base->devuelveIDInsercion($consulta_insertar);
            if ($idViaje) {
                $this->setIdViaje($idViaje);
                $resp = true;
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }
        return $resp;
    }

    public function Modificar($id_viaje){
        $resp = false;
        $base = new BaseDatos();

        $consultaModificar = "UPDATE viaje 
        SET vdestino = '" . $this->getDestino() . 
        "', vcantmaxpasajeros = '" . $this->getCantMaxPasajeros() . 
        "', vimporte = '" .$this->getImporte(). 
        "' WHERE idviaje = " . $id_viaje;

        if($base->Iniciar()){
            if($base->Ejecutar($consultaModificar)){
                $resp = true;
            }else{
                $this->setmensajeoperacion($base->getError());
            }
        }else{
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }

    public function Eliminar (){
        $base = new BaseDatos();
        $resp = false;
        
        if($base->Iniciar()){
            $consultaEliminar = "DELETE FROM viaje WHERE idviaje = " . $this->getIdViaje();
            if($base->Ejecutar(($consultaEliminar))){
                $resp = true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        }else{
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }


    public function agregarPasajeros($nuevoNombre,$nuevaApellido,$nuevoTelefono, $nuevoDoc, $nuevaFrec, $idViaje){
        $seAgrego = false;

        $pasajeros = new Pasajero();
        $hayPasajeroRepetido = $pasajeros->Buscar($nuevoDoc);
        
        if(!$hayPasajeroRepetido){
            $pasajeros->setNroPFrecuente($nuevaFrec);
            $pasajeros->setObjViaje($idViaje);
            $pasajeros->cargar($nuevoDoc, $nuevoNombre, $nuevaApellido, $nuevoTelefono);
            $seAgrego = true; 
        }

        return $seAgrego ;
    }

    public function agregarResponsable($nombre, $apellido, $nroDoc, $telefono, $numEmpleado){
        $seAgrego = false;

        $responsable = new ResponsableV();
        $hayRepetido = $responsable->Buscar($nroDoc);
        
        if(!$hayRepetido){
            $responsable->setTelefono($telefono);
            $responsable->setNroLicencia($numEmpleado);
            $responsable->cargar($nroDoc,$nombre, $apellido, $telefono);
            $seAgrego = true; 
        }

        return $seAgrego ;
    }
}
