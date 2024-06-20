<?php

include_once 'BaseDatos.php';
include_once 'Persona.php';
include_once 'Pasajero.php';
include_once 'ResponsableV.php';
include_once 'Viaje.php';
include_once 'Empresa.php';

$objEmpresa = New Empresa(1906, "Viaje Feliz", "Belgrano 10");
$objViaje = New Viaje();
$objPasajero = New Pasajero();
$objResponsable = New ResponsableV();


function opciones(){ 
    echo "+--------------------------------------------------+\n";
        echo "MENU DE OPCIONES PRINCIPAL". "\n";
        echo "1: Ingresar Nuevo Viaje". "\n";
        echo "2: Modificar un Viaje existente". "\n";
        echo "3: Ingresar Pasajeros". "\n";
        echo "4: Eliminar datos de viaje". "\n";
        echo "5: Mostrar datos del viaje". "\n";
        echo "6: Salir". "\n";
        echo "Elija una opcion: ";
        $opcion = trim(fgets(STDIN));
    echo "+--------------------------------------------------+\n";
        
    return $opcion;
}
function opcionesModViaje(){ 
        echo "LAS OPCIONES DE VIAJE.". "\n";
        echo "1.Datos del viaje". "\n";
        echo "2.Responsable del viaje". "\n";
        echo "3.Datos de Pasajeros". "\n";
        echo "Eliga una opcion: ";
        $opcion = trim(fgets(STDIN));
    echo "------------------------------------\n";
            
    return $opcion;
}

do{
    $opcion = opciones();
    switch ($opcion) {
        case 1:
            ingresarNuevoViaje($objEmpresa);
            break;
        case 2:
            $valor = seleccionarIdViaje($objViaje);
            echo "ELIJA PARA MODIFICAR ";
            $opviaje = opcionesModViaje();
            switch ($opviaje) {
                case 1:
                    modificarDatosViaje($valor);
                    break;
                case 2:
                    modificarDatosResponsable();
                    break;
                case 3:
                    modificarDatosPasajero($valor, $objPasajero);
                    break;
            }
            break;
        case 3:
            $valor = seleccionarIdViaje($objViaje);
            insertarPasajeros($valor);
            break;
        case 4:
            $valor = seleccionarIdViaje(($objViaje));
            echo "ELIJA PARA ELIMINAR";
            $opviaje = opcionesModViaje();
            switch ($opviaje) {
                case 1:
                    eliminarDatosViaje();
                    break;
                case 2:
                    eliminarDatosResponsable();
                    break;
                case 3:
                    eliminarDatosPasajero();
                    break;
            }
            break;
        case 5:
            mostrarDatosViaje($objEmpresa);
            break;
        case 6:
            echo "-------------------- FIN DEL PROGRAMA --------------------" ;
            break;
    }

} while ($opcion != 6);

//OPCION 1
function ingresarNuevoViaje($objEmpresa){
    // Solicitar al usuario el ingreso de datos para crear un nuevo viaje
    echo "Ingrese codigo del Viaje: ";
    $idViaje = trim(fgets(STDIN));
    echo "Ingrese el destino del viaje: ";
    $destino = trim(fgets(STDIN));
    echo "Ingrese la cantidad máxima de pasajeros: ";
    $cantMaxPasajeros = trim(fgets(STDIN));
    $idEmp = $objEmpresa->getIdEmpresa();

    echo "¿Desea ingresar datos del responsable del viaje? (s/n): ";
    $rta = strtolower(trim(fgets(STDIN)));
    if ($rta == 's') {
        $objResponsable = insertarResponsable();
    }else{
        $objResponsable = null;
    }

    //agrega Pasajeros
    echo "¿Desea ingresar datos de pasajeros al viaje? (s/n): ";
    $rta = strtolower(trim(fgets(STDIN)));
    if ($rta == 's') {
        $objResponsable = insertarPasajeros($idViaje);
        $pasajerosOperacion = new Pasajero();
        $condicion = "idviaje = $idViaje";
        $coleccionPasajeros = $pasajerosOperacion->listar($condicion);
    }else{
        $coleccionPasajeros = null;
    }

    echo "Ingrese el importe del viaje: ";
    $importe = trim(fgets(STDIN));

    $viaje = new Viaje();
    $viaje->cargar($idViaje, $destino, $cantMaxPasajeros,$objResponsable, $idEmp, $coleccionPasajeros, $importe);
    $seAgrego = $viaje->insertar();
    if($seAgrego){
        echo "Viaje agregado!"."\n";
    }else {
        echo "(!!!)El viaje no se pudo agregar\n";
    }

}

//selecciona el viaje correspondiente a travez de su clave primaria, chequea que exista
function seleccionarIdViaje($objViaje){
    $coleccionViajes = $objViaje->listar("");
    foreach ($coleccionViajes as $viaje) {
        echo $viaje;
        echo "\n>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n";
    }
    $esValida = -1;

    echo "Ingrese el id del Viaje al que desea modificar: \n";
    $idViaje_modificar = trim(fgets(STDIN));

    $viajes = new Viaje();
    $viajeEncontrado = $viajes->buscar($idViaje_modificar);
    if($viajeEncontrado){
        $esValida = $idViaje_modificar;
    }

    return $esValida;
}

//modificar datos de un viaje (OPCION 1 <<OPCION2>>)
function modificarDatosViaje($esValida){
    $viajes = new Viaje();
    if($esValida == -1){
        echo "(!!!) El id ingresado NO coincide con los id's cargados\n";
    }else{
        echo "--------------------------------------------------------\n";
        echo "Nuevo destino:";
        $nuevoDestino = trim(fgets(STDIN));
        echo "Nueva cantidad maxima de Pasajeros:";
        $nuevaCapacidad = trim(fgets(STDIN));
        echo "Nuevo Importe:";
        $nuevoImporte = trim(fgets(STDIN));

        $viajes->setDestino($nuevoDestino);
        $viajes->setCantMaxPasajeros($nuevaCapacidad);
        $viajes->setImporte($nuevoImporte);

        $exito = $viajes->modificar($esValida);
        if ($exito) {
            echo "La modificacion se realizo con exito !\n";
        } else {
            echo "(!!!) No es posible realizar la modificacion\n";
        }
    }
}

//modificar datos del responsable del viaje (OPCION 2 <<OPCION 2>>)
function modificarDatosResponsable(){
}

//modificar datos de un pasajero (OPCION 3 <<OPCION 2>>)
function modificarDatosPasajero($idViaje, $objPasajero){
    if($idViaje == -1){
        echo "(!!!) El id ingresado NO coincide con los id's cargados\n";
    }else{
        $condicion = "idviaje = $idViaje";
        $arregloPasajeros = $objPasajero->listar($condicion);
        foreach ($arregloPasajeros as $pasajero) {
            echo $pasajero;
            echo "\n>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n";
        }
        echo "Ingrese Numero de documento del Pasajero a modificar:";
        $nroDoc_modificar = trim(fgets(STDIN));

        $pasajeros = new Pasajero();
        $busqueda = $pasajeros->Buscar($nroDoc_modificar);
        if($busqueda){
            echo "Nombre:";
            $nuevoNombre = trim(fgets(STDIN));
            echo "Apellido:";
            $nuevaApellido= trim(fgets(STDIN));
            echo "Telefono:";
            $nuevoTelefono= trim(fgets(STDIN));
            echo "Nro de frecuencia:";
            $nuevaFrec= trim(fgets(STDIN));
            $pasajeros->setNombre($nuevoNombre);
            $pasajeros->setApellido($nuevaApellido);
            $pasajeros->setTelefono($nuevoTelefono);
            $pasajeros->setNroPFrecuente($nuevaFrec);
            
            $seLogro = $pasajero->modificar();
            if ($seLogro) {
                echo "Se cambiaron los datos con exito!\n";
            } else {
                echo "(!!!) No es posible realizar la modificacion\n";
            }
        }
    }

}

//incorporar un pasajero nuevo a la lista (OPCION 3)
function insertarPasajeros($idViaje){
    if($idViaje == -1){
        echo "(!!!) El id ingresado NO coincide con los id's cargados\n";
    }else{
        do{
            echo "Nombre:";
            $nuevoNombre = trim(fgets(STDIN));
            echo "Apellido:";
            $nuevaApellido= trim(fgets(STDIN));
            echo "Telefono:";
            $nuevoTelefono= trim(fgets(STDIN));
            echo "Documento:";
            $nuevoDoc = trim(fgets(STDIN));
            echo "Nro de frecuencia:";
            $nuevaFrec = trim(fgets(STDIN));

            $operacionViaje = new Viaje();
            $bandera = $operacionViaje->agregarPasajeros($nuevoNombre,$nuevaApellido,$nuevoTelefono, $nuevoDoc, $nuevaFrec, $idViaje);
            if($bandera){
                echo "Pasajero agregado!"."\n";
            }else {
                echo "El pasajero esta repetido en lav lista\n";
            }
            echo "Desea agregar una nuevo pasajero? (s/n)";
            $agregarPasajero = strtolower(trim(fgets(STDIN)));
        }while($agregarPasajero !="n");
    }
}

function insertarResponsable(){
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

    $operacionViaje = new Viaje();
    $bandera= $operacionViaje->agregarResponsable($nombre, $apellido, $nroDoc, $telefono, $numEmpleado);
    if($bandera){
        echo "Responsable del Viaje agregado!"."\n";
        return $numEmpleado;
    }else {
        echo "El Responsable del viaje no se pudo agregar\n";
    }

}

//elimina datos de un viaje (OPCION 4)
function eliminarDatosViaje(){
    $viaje = new Viaje();
    $colViajes = $viaje->listar();
    echo "Listado de viajes: \n";
    foreach($colViajes as $unViaje){
        echo "\n". $unViaje ."\n";
        echo "*************\n";
    }
    
    if(count($colViajes) > 0 ){
        echo "Ingrese el id del viaje a eliminar: \n";
        $idViaje = trim(fgets(STDIN));

        if((is_numeric ($idViaje)) && $idViaje != "" && $viaje->Buscar($idViaje)){
            if($viaje->eliminar()){
                echo "Se elimino el viaje con exito!\n";
            } else {
                echo "Ocurrió un error al intentar eliminar el viaje.\n";
            }
        } else {
            echo "El viaje con id $idViaje no existe.\n";
        }
    } else {
        echo "No se encuentran viajes registrados.\n";
    }
}


function eliminarDatosResponsable(){
    $responsable = new ResponsableV();
    $colResponsable = $responsable->listar();
    echo "Listado de responsables: \n";

    foreach($colResponsable as $unResponsable){
        echo "\n". $unResponsable ."\n";
        echo "*************\n";
    }
    if(count($colResponsable) > 0){ 
        echo "Ingrese el numero de empleado del responsable a eliminar: \n";
        $nroResponsable = trim(fgets(STDIN));
        if(is_numeric($nroResponsable) && $nroResponsable != " " && $responsable->buscar($nroResponsable)){
            if($responsable->eliminar()){
                echo "Se elimino el responsable con exito!\n";
            } else{
                echo "Ocurrió un error al intentar eliminar el responsable.\n";
            }
        }else{
            echo "El numero de empleado $nroResponsable no existe.\n";
        }
    }else{
        echo "No se encuentran responsables registrados.\n";
    }
}

    function eliminarDatosPasajero(){
        $pasajero = new Pasajero();
        $colPasajeros = $pasajero->listar();

        echo "Listado de pasajeros: \n";
        foreach($colPasajeros as $unPasajero){
            echo "\n". $unPasajero ."\n";
            echo "*************\n";
        }
        if(count($colPasajeros) > 0 ){
            echo "Ingrese el numero de documento del pasajero a eliminar: \n";
            $dniPasajero = trim(fgets(STDIN));
            if($dniPasajero != null && $pasajero->Buscar($dniPasajero)){
                if($pasajero->eliminar()){
                    echo "Se elimino el pasajero con exito!\n";
                } else {
                    echo "Ocurrió un error al intentar eliminar el pasajero.\n";
                }
            } else {
                echo "El pasajero con numero de documento: $dniPasajero no existe.\n";
            }
        } else {
            echo "No existen pasajeros registrados.\n";
        }
    }


// function mostrarDatosViaje($objEmpresa){
//     echo "Ingrese el id del viaje: ";
//     $idViaje = trim(fgets(STDIN));
//     $viajeEncontrado = null;
//     $colViajes = $objEmpresa->getArregloViajes();

//     foreach ($colViajes as $viaje){
//         if ($viaje->getIdViaje() == $idViaje){
//                 $viajeEncontrado = $viaje;
//                 break;
//             } 
//         if ($viajeEncontrado == null){
//             echo  "No se encontró el viaje con el ID especificado.\n";
//         }
//         else{
//             echo "VIAJE ENCONTRADO: \n";

//             echo $viajeEncontrado;
//         }
//     }
// }

function mostrarDatosViaje($objViaje){
    $viajeInfo = null;
    $condicion = "' idviaje = ";
	echo "Ingrese el id del viaje que desea ver: \n";
	$id = trim(fgets(STDIN));
	if(!is_numeric($id) || $id == ""){
		echo "Por favor, ingrese un valor numérico. \n";
	}else{
        $condicion = $condicion . $id . " '";
		$viajeInfo = $objViaje->Listar($condicion);
    }

		if($viajeInfo != null){
          $retornaViaje = $objViaje->mostrarColeccion($viajeInfo); 
		  echo $retornaViaje;  
		}else{
          echo "No existe un viaje con ese id. \n";  
		}
}

?>