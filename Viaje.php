<?php
include_once 'Empresa.php';
include_once 'ResponsableV.php';

class Viaje{
    private $idV;
    private $destino;
    private $cantMaxPasajeros;
    private $objResponsable;
    private $objEmpresa;
    private $arrayPasajeros;
    private $importe;
    private $mensajeoperacion;


    // CONSTRUCTOR
    public function __construct(){
        $this->idV = "";
        $this->destino = "";
        $this->cantMaxPasajeros = "";
        $this->objResponsable = "";
        $this->objEmpresa = "";
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

    public function getObjEmpresa(){
        return $this->objEmpresa;
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

    public function setObjResponsable($rNroEmpleado){
        $this->objResponsable = $rNroEmpleado;
    }

    public function setObjEmpresa($idEmpresa){
        $this->objEmpresa = $idEmpresa;
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
            "\nResponsable del viaje \n" . $this->getObjResponsable() . 
            "\nEmpresa de viajes: \n" . $this->getObjEmpresa() . "\n" .  
            "Pasajeros: \n" . $this->mostrarColeccionPasajeros() . "\n" . 
            "Importe del viaje: $" . $this->getImporte() . "\n";
    }

    public function mostrarColeccionPasajeros(){
        // pasa el array de pasajeros a string para que pueda ser mostrado por consola
        $mostrar = "";
        $pasajeros= $this->getColPasajeros();
        if($pasajeros == null){
            $mostrar= "No hay pasajeros cargados!\n";
        }else{
            foreach ($pasajeros as $pasajero) {
                $mostrar .= $pasajero . "\n";
                $mostrar.= "------------------------------\n";
            }
        }
        return $mostrar;
    }

    public function mostrarCol($unaColeccion){
        // función generica para pasar un array a string
        $mostrarC = "";
        foreach ($unaColeccion as $elemento) {
            $mostrarC.= ">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n";
            $mostrarC .= $elemento . "\n";
            $mostrarC.= ">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n";
        }
        return $mostrarC;
    }

    public function cargar($idViaje, $vDestino, $cantMaxPasajeros,$obj_Responsable, $obj_Empresa, $vImporte)
    {
        $this->setIdViaje($idViaje);
        $this->setDestino($vDestino);
        $this->setCantMaxPasajeros($cantMaxPasajeros);
        $this->setObjResponsable($obj_Responsable);
        $this->setObjEmpresa($obj_Empresa);
        $this->setImporte($vImporte);
    }

    public function getmensajeoperacion(){
        return $this->mensajeoperacion;
    }
    public function setmensajeoperacion($mensajeoperacion){
        $this->mensajeoperacion= $mensajeoperacion;
    }
    public function listar($condicion)
    //prueba listar, funciona !! 
    {
        $arregloViaje = [];
        $base = new BaseDatos();
        $consultaViajes = "SELECT * FROM viaje ";
        if ($condicion != "") {
            $consultaViajes = $consultaViajes . ' WHERE ' . $condicion;
        }
        $consultaViajes .= " ORDER BY idviaje";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaViajes)) {
                $arregloViaje = [];
                while ($row = $base->Registro()) {
                    $id_viaje = $row['idviaje'];
                    $viaje = new Viaje();
                    $viaje->Buscar($id_viaje);
                    array_push($arregloViaje, $viaje);
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $arregloViaje;
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
                    $idEmpresa = $row['idempresa']; 
                    $empresa = new Empresa();
                    if ($empresa->Buscar($idEmpresa)) {
                        $this->setObjEmpresa($empresa);
                    }

                    // Cargar el arreglo de Pasajeros asociados al viaje
                    $consultaPasajeros = "SELECT * FROM pasajero WHERE idviaje = " . $idViaje;
                    if ($base->Ejecutar($consultaPasajeros)) {
                        while ($rowPasajero = $base->Registro()) {
                            $dniPasajero = $rowPasajero['nrodoc']; 
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
        
        $idemp = $this->getObjEmpresa()->getIdEmpresa();
        $nroEmp = $this->getObjResponsable()->getNroEmpleado();
        
        $importe = $this->getImporte();

        $consulta_insertar = "INSERT INTO viaje(vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte)
		VALUES ('".$destino."','".$max_pasajeros."','".$idemp."','".$nroEmp."','".$importe."')";

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
            $datosPasaj = ['nombre' => $nuevoNombre, 'apellido' => $nuevaApellido, 'nrodoc' => $nuevoDoc, 'telefono' => $nuevoTelefono, 'nropfrecuente' => $nuevaFrec, 'idviaje' => $idViaje];
            // $pasajeros->setNroPFrecuente($nuevaFrec);
            // $pasajeros->setObjViaje($idViaje);
            $pasajeros->cargar($datosPasaj);
            $seAgrego = true; 
        }

        return $seAgrego ;
    }


}
