<?php

include 'Persona.php';
include 'Pasajero.php';
include 'ResponsableV.php';
include 'Viaje.php';
include 'Empresa.php';

$objEmpresa = New Empresa(1906, "Viaje Feliz", "Belgrano 10");
$objViaje = New Viaje();
$objPasajero = New Pasajero();

do{

    $opcion = opciones();

    switch ($opcion) {
        case 1:
            ingresarNuevoViaje($objEmpresa);
            break;
        case 2:
            $opviaje = opcionesModViaje();
            switch ($opviaje) {
                case 1:
                    modificarViaje();
                    break;

            }
            break;
        case 3:
            break;

        case 4:

            break;

        case 5:

            break;

        case 0:
            echo "-------------------- FIN DEL PROGRAMA --------------------" ;
            break;
    }

}while($opcion != 0);


//OPCION 1
function ingresarNuevoViaje($objEmpresa){
    // Solicitar al usuario el ingreso de datos para crear un nuevo viaje
    echo "Ingrese codigo del Viaje: ";
    $idViaje = trim(fgets(STDIN));
    echo "Ingrese el destino del viaje: ";
    $destino = trim(fgets(STDIN));
    echo "Ingrese la cantidad máxima de pasajeros: ";
    $cantMaxPasajeros = trim(fgets(STDIN));

    echo "¿Desea ingresar datos del responsable del viaje? (s/n): ";
    $rta = strtolower(trim(fgets(STDIN)));
    $objResponsable = null; //en caso de que la respuesta sea "n"
    if ($rta == 's') {
        echo "Ingrese el nombre del responsable: ";
            $nombre = trim(fgets(STDIN));
            echo "Ingrese el apellido del responsable: ";
            $apellido = trim(fgets(STDIN));
            echo "Ingrese el número de documento del responsable: ";
            $nroDoc = trim(fgets(STDIN));
            echo "Ingrese el teléfono del responsable: ";
            $telefono = trim(fgets(STDIN));
            echo "Ingrese Nro de empleado:";
            $numEmpleado = trim(fgets(STDIN));
            echo "Ingrese Nro de Licencia: ";
            $numLicencia = trim(fgets(STDIN));
        $objResponsable = new ResponsableV($nombre, $apellido, $nroDoc, $telefono, $numEmpleado, $numLicencia);
    }

    $arregloPasajeros = []; // Arreglo para almacenar los pasajeros
    do {
        echo "¿Desea ingresar datos de un pasajero? (s/n): ";
        $rta1 = strtolower(trim(fgets(STDIN)));

        if ($rta1 == 's') {
            echo "Ingrese el nombre del pasajero: ";
            $nombre = trim(fgets(STDIN));
            echo "Ingrese el apellido del pasajero: ";
            $apellido = trim(fgets(STDIN));
            echo "Ingrese el número de documento del pasajero: ";
            $nroDoc = trim(fgets(STDIN));
            echo "Ingrese el teléfono del pasajero: ";
            $telefono = trim(fgets(STDIN));
            echo "Ingrese el número de pasajero frecuente: ";
            $nroPasajeroFrecuente = trim(fgets(STDIN));
            $arregloPasajsoeros[] = new Pasajero($nombre, $apellido, $nroDoc, $telefono, $nroPasajeroFrecuente, $idViaje);
        }
    } while ($rta1 != 'n');


    echo "Ingrese el importe del viaje: ";
    $importe = trim(fgets(STDIN));

    $nuevoViaje = new Viaje($idViaje, $destino, $cantMaxPasajeros, $objResponsable, $arregloPasajeros, $importe);

    $exito = $objEmpresa->incorporarViaje($nuevoViaje);
    if ($exito) {
        echo "Viaje agregado correctamente\n";
    } else {
        echo "Error al agregar el viaje\n";
    }
}

function modificarViaje(){

}
function ingresarPasajero(){

}

function eliminarDatosViaje(){

}

function mostrarDatosViaje($objEmpresa){
    echo "Ingrese el id del viaje: ";
    $idViaje = trim(fgets(STDIN));
    $viajeEncontrado = null;
    $colViajes = $objEmpresa->getArregloViajes();

    foreach ($colViajes as $viaje){
        if ($viaje->getIdViaje() == $idViaje){
                $viajeEncontrado = $viaje-> __toString();
                break;
            } 
            if($viajeEncontrado !== null){
                echo $viajeEncontrado;
        }else {
            echo "No se encontró el viaje con el ID especificado. \n";
        }
        return $viajeEncontrado;
    }

}









function opciones(){ 
echo "+--------------------------------------------------+\n";
    echo "MENU DE OPCIONES PRINCIPAL";
    echo "1: Ingresar Nuevo Viaje";
    echo "2: Modificar un Viaje existente";
    echo "3: Ingresar Pasajero";
    echo "4: Eliminar datos de viaje";
    echo "5: Mostrar datos del viaje";
    echo "0: Salir";
    echo "Elija una opcion: ";
    $opcion = trim(fgets(STDIN));
    echo "+--------------------------------------------------+\n";
    
    return $opcion;
}
function opcionesModViaje(){ 
    echo "*------------------------------------*\n";
    echo "OPCIONES DE VIAJE. \n";
    echo "Modificar Viaje existente";
    echo "1.Modificar datos del viaje";
    echo "2.Modificar Responsable del viaje";
    echo "3.Modificar datos de Pasajeros";
    echo "Eliga una opcion: ";
    $opcion = trim(fgets(STDIN));
    echo "*------------------------------------*\n";
        
        return $opcion;
    }


?>