<?php

include 'Persona.php';
include 'Pasajero.php';
include 'ResponsableV.php';
include 'Viaje.php';
include 'Empresa.php';

$objEmpresa = New Empresa(1906, "Viaje Feliz", "Belgrano 10");
$objViaje = New Viaje();

do{
    echo "Menu de Opciones";
    echo "1.Ingresar Nuevo Viaje";
    echo "2.Modificar un Viaje existente";
    echo "3.Ingresar Pasajeros";
    echo "4.Eliminar datos de viaje";
    echo "5.Mostrar datos del viaje";
    $opcion = trim(fgets(STDIN));

    switch ($opcion) {
        case '1':
            ingresarNuevoViaje($objEmpresa);
            break;
        case '2':
            echo "Modificar Viaje existente";
            echo "1.Modificar datos del viaje";
            echo "2.Modificar Responsable del viaje";
            echo "3.Modificar datos de Pasajeros";
            $modificacion = trim(fgets(STDIN));
            switch ($modificacion) {
                case '1':
                    modificarViaje();
                    break;
                default:
                   break;
            }
        default:
            # code...
            break;
    }

}while($opcion != 0);

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
    if ($rta== 's') {
        echo "Ingrese el nombre del pasajero: ";
            $nombre = trim(fgets(STDIN));
            echo "Ingrese el apellido del pasajero: ";
            $apellido = trim(fgets(STDIN));
            echo "Ingrese el número de documento del pasajero: ";
            $nroDoc = trim(fgets(STDIN));
            echo "Ingrese el teléfono del pasajero: ";
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
            $arregloPasajeros[] = new Pasajero($nombre, $apellido, $nroDoc, $telefono, $nroPasajeroFrecuente, $idViaje);
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





echo " HOLAAAAAAAAAAAAAAAAAAAAAA"

?>