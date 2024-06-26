<?php

include_once 'BaseDatos.php';
include_once 'Persona.php';
include_once 'Pasajero.php';
include_once 'ResponsableV.php';
include_once 'Viaje.php';
include_once 'Empresa.php';

$objEmpresa = New Empresa();
    $enombre = "Viaje Feliz";
    $edomicilio = "Belgrano 600";
    $objEmpresa->cargar(null, $enombre, $edomicilio);
$objEmpresa->insertar();

$objViaje = New Viaje();
$objPasajero = New Pasajero();
$objResponsable = New ResponsableV();


function opciones(){ 
        echo "+--------------------------------------------------+\n";
        echo "MENU DE OPCIONES PRINCIPAL". "\n";
        echo "1: Ingresar Nuevo Viaje". "\n";
        echo "2: Modificar un Viaje existente". "\n";
        echo "3: Ingresar Pasajeros". "\n";
        echo "4: Opciones para eliminar". "\n";
        echo "5: Mostrar datos del viaje". "\n";
        echo "6: Salir". "\n";
        echo "Elija una opcion: \n";
        echo "+--------------------------------------------------+\n";
        $opcion = trim(fgets(STDIN));
    
        
    return $opcion;
}
function opcionesModViaje(){ 
        echo "+====================================+\n";
        echo "OPCIONES PARA MODIFICAR.". "\n";
        echo "1.Datos del viaje". "\n";
        echo "2.Responsable del viaje". "\n";
        echo "3.Datos de Pasajeros". "\n";
        echo "Eliga una opcion: \n";
        echo "+====================================+\n";
        $opcion = trim(fgets(STDIN));
        
    return $opcion;
}
function opcionesEliminar(){
        echo "+====================================+\n";
        echo "OPCIONES PARA ELIMINAR.". "\n";
        echo "1. Eliminar viaje". "\n";
        echo "2. Eliminar pasajero.". "\n";
        echo "3. Salir \n";
        echo "Elija una opcion: \n";
        echo "+====================================+\n";
        $opcion = trim(fgets(STDIN));
    
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
            if($valor == -1|| $valor == -2){
                $opviaje = 4;
            }else{
                $opviaje = opcionesModViaje();
            }
            switch ($opviaje) {
                case 1:
                    modificarDatosViaje($valor);
                    break;
                case 2:
                    modificarDatosResponsable($valor, $objViaje);
                    break;
                case 3:
                    modificarDatosPasajero($valor, $objPasajero);
                    break;
                case 4:
                    echo "SALIENDO AL MENU PRINCIPAL \n";
                    break;
            }
            break;
        case 3:
            $valor = seleccionarIdViaje($objViaje);
            insertarPasajeros($valor, $objViaje);
            break;
        case 4:
            
            do{
                $opcionesEliminar = opcionesEliminar();
                switch ($opcionesEliminar){
                    case 1:
                        eliminarDatosViaje();
                        break;
                    case 2:
                        eliminarDatosPasajero();
                        break;
                    case 3:
                        echo "SALIENDO AL MENU PRINCIPAL \n";
                        break;    
                    default:
                        echo "Opción no válida. Intente nuevamente.\n";
                        break;
                }
            }while ($opcionesEliminar != 3);
            break;
            
        case 5:
            mostrarDatosViaje($objViaje);
            break;
        case 6:
            echo "*<<<<<<<<<<<<<<<< FIN DEL PROGRAMA >>>>>>>>>>>>>>>>*" ;
            break;
    }

} while ($opcion != 6);

//Incorpora un nuevo viaje a la Empresa (OPCION 1)
function ingresarNuevoViaje($objEmpresa){

    echo "Ingrese el destino del viaje: ";
    $destino = trim(fgets(STDIN));
    echo "Ingrese la cantidad máxima de pasajeros: ";
    $cantMaxPasajeros = trim(fgets(STDIN));

    $nuevoResponsable = insertarResponsable();

    echo "Ingrese el importe del viaje: ";
    $importe = trim(fgets(STDIN));

    $viaje = new Viaje();
    $viaje->cargar(null, $destino, $cantMaxPasajeros,$nuevoResponsable,$objEmpresa, $importe);
    $seAgrego = $viaje->insertar();
    if($seAgrego){
        echo "Viaje agregado!"."\n";
    }else {
        echo "(!!!)El viaje no se pudo agregar\n";
    }

}

//Selecciona el viaje correspondiente a travez de su clave primaria, chequea que exista
function seleccionarIdViaje($objViaje){
    $esValida = 0;

    $coleccionViajes = $objViaje->listar("");
    for($i=0;$i<count($coleccionViajes);$i++){
        $viaje = $coleccionViajes[$i];
        echo "\n>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n";
        echo "ID Viaje: ". $viaje->getIdViaje(). "\n";
        echo "Destino: ". $viaje->getDestino(). "\n";
        echo "Cantidad de Pasajeros: ". $viaje->getCantMaxPasajeros(). "\n";
        echo "\n>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n";

    }

    if(count($coleccionViajes) < 1){
        echo "No hay ningún viaje registrado. \n";
        $esValida = -1;
    }else{
        echo "Ingrese el id del Viaje a seleccionar: \n";
        $idViaje_modificar = trim(fgets(STDIN));

        $viajes = new Viaje();
        $viajeEncontrado = $viajes->buscar($idViaje_modificar);
        if($viajeEncontrado){
            $esValida = $idViaje_modificar;
        }else{
            echo "(!!!)El id del Viaje no existe.". "\n";
            $esValida = -2;
        }
    }
    return $esValida;
}

//Modificar datos de un viaje (OPCION 1 <<OPCION2>>)
function modificarDatosViaje($codigoViaje){
    $viajes = new Viaje();

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

        $exito = $viajes->modificar($codigoViaje);
        if ($exito) {
            echo "La modificacion se realizo con exito !\n";
        } else {
            echo "(!!!) No es posible realizar la modificacion\n";
        }
}

//Modificar datos del responsable del viaje (OPCION 2 <<OPCION 2>>)
function modificarDatosResponsable($idViaje, $viaje) {
    if ($viaje->Buscar($idViaje)) {
        $responsable = $viaje->getObjResponsable();

        if($viaje->getObjResponsable() == null){
            $mensaje = "No hay viaje cargado, cargue uno";
            return $mensaje;
        }else{
            echo "Responsable actual:\n";
            echo $responsable->__toString();
        }
        echo "Ingrese Numero de documento del Responsable a modificar:";
        $nroDoc_modificar = trim(fgets(STDIN));

        $persona = new Persona();
        $busqueda = $persona->Buscar($nroDoc_modificar);

        if($busqueda){
            $nroEmpleado = $responsable->getNroEmpleado();
            $nuevoNombre = trim(readline("Nombre: "));
            $nuevaApellido = trim(readline("Apellido: "));
            $nuevoTelefono = trim(readline("Telefono: "));
            $nuevoNroLic= trim(readline("Numero de licencia: "));

            $datosResponsable= [
                'nombre' => $nuevoNombre, 
                'apellido' => $nuevaApellido, 
                'nrodoc' => $nroDoc_modificar, 
                'telefono' => $nuevoTelefono,
                'rnumeroempleado' => $nroEmpleado, 
                'rnumerolicencia' => $nuevoNroLic
            ];

            $responsable->cargar($datosResponsable);
            $seLogro = $responsable->modificar();
            if ($seLogro) {
                echo "Se cambiaron los datos con exito!\n";
            } else {
                echo "(!!!) No es posible realizar la modificacion\n";
            }
        }else{
            echo "(!!!) No hay Responsable que figure con ese numero de documento ingresado."."\n";
        }
    } else {
        echo "No se encontró el responsable con ID: $idViaje\n";
    }
}

//Modificar datos de un pasajero (OPCION 3 <<OPCION 2>>)
function modificarDatosPasajero($idViaje, $objPasajero){
    $condicion = "idviaje = $idViaje";
    $arregloPasajeros = $objPasajero->listar($condicion);
        foreach ($arregloPasajeros as $pasajero) {
            echo $pasajero;
            echo "\n>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n";
        }

        if(count($arregloPasajeros) == null){
            echo "No es posible modificar ya que no hay pasajeros previamente cargados.\n";
        }else{
            $numTicket = $pasajero->getTicket();
            echo "Ingrese Numero de documento del Pasajero a modificar:";
            $nroDoc_modificar = trim(fgets(STDIN));
            $persona = new Persona();
            $busqueda = $persona->Buscar($nroDoc_modificar);

            if($busqueda){
                $nuevoNombre = trim(readline("Nombre: "));
                $nuevaApellido = trim(readline("Apellido: "));
                $nuevoTelefono = trim(readline("Telefono: "));
                $nuevoAsiento = trim(readline("Numero de asiento: "));

                $datosPas= [
                    'nombre' => $nuevoNombre, 
                    'apellido' => $nuevaApellido, 
                    'nrodoc' => $nroDoc_modificar, 
                    'telefono' => $nuevoTelefono,
                    'nroticket' => $numTicket,
                    'nroasiento' => $nuevoAsiento,
                    'idviaje' => $idViaje,
                ];

                $pasajero->cargar($datosPas);
                $seLogro = $pasajero->modificar();
                if ($seLogro) {
                    echo "Se cambiaron los datos con exito!\n";
                } else {
                    echo "(!!!) No es posible realizar la modificacion\n";
                }
            }else{
                echo "(!!!) No hay pasajero que figure con ese numero de documento ingresado."."\n";
            }

        }

}

//Incorporar un pasajero nuevo a un viaje (OPCION 3)
function insertarPasajeros($idViaje, $viaje){
    $pasajero = new Pasajero();
    $persona = new Persona();
    
    if ($viaje->Buscar($idViaje)) {
        $cantMaxPasajeros = $viaje->getCantMaxPasajeros();
    }

    $condicionPasajero = "idviaje = $idViaje";
    $totalPasajeros = $pasajero->listar($condicionPasajero);

    if (count($totalPasajeros) < $cantMaxPasajeros) {
        do{
            echo "Ingrese el número de documento del pasajero: ";
            $nroDoc = trim(fgets(STDIN));
            $estaRepetido = $persona->Buscar($nroDoc);
            if($estaRepetido){
                echo "La persona ya estaba previamente registrada, ingrese otro.\n";
            }else{
                $estaRepetido = false;
            }
        }while($estaRepetido == true);
        echo "Nombre: ";
        $nombre = trim(fgets(STDIN));
        echo "Apellido: ";
        $apellido = trim(fgets(STDIN));
        echo "Telefono: ";
        $telefono = trim(fgets(STDIN));
        echo "Nro asiento: ";
        $asiento = trim(fgets(STDIN));

        $datosPas= [
            'nombre' => $nombre, 
            'apellido' => $apellido, 
            'nrodoc' => $nroDoc, 
            'telefono' => $telefono,
            'nroticket' => null,
            'nroasiento' => $asiento,
            'idviaje' => $idViaje,
        ];

        $pasajero->cargar($datosPas);
        $bandera = $pasajero->insertar();
    
        if ($bandera) {
            echo "Pasajero agregado!\n";
        } else {
            echo "(!!!)El pasajero no pudo ser agregado.\n";
        }
    } else {
        echo "La cantidad de pasajeros ha alcanzado el límite máximo.\n";
    }
}

//Incorpora un responsable a un nuevo viaje (<<OPCION 1>>)
function insertarResponsable(){
    $persona = new Persona();
    $estaRepetido = false;
    
    do{
        echo "Ingrese el número de documento del responsable: ";
        $nroDoc = trim(fgets(STDIN));
        $estaRepetido = $persona->Buscar($nroDoc);
        if($estaRepetido){
            echo "La persona ya estaba previamente registrada, ingrese otro.\n";
        }else{
            $estaRepetido = false;
        }
    }while($estaRepetido == true);
    
    if($estaRepetido == false){
        echo "Ingrese el nombre del responsable: ";
            $nombre = trim(fgets(STDIN));
            echo "Ingrese el apellido del responsable: ";
            $apellido = trim(fgets(STDIN));
            echo "Ingrese el teléfono del responsable: ";
            $telefono = trim(fgets(STDIN));
            echo "Ingrese Nro de Licencia: ";
            $numLicencia = trim(fgets(STDIN));

            $datosResp = [
                'nombre' => $nombre, 
                'apellido' => $apellido, 
                'nrodoc' => $nroDoc, 
                'telefono' => $telefono, 
                'rnumeroempleado' => null, 
                'rnumerolicencia' => $numLicencia
            ];

            $responsable = new ResponsableV();
            $responsable->cargar($datosResp);
            $bandera = $responsable->insertar();

        if($bandera){
            echo "Responsable del Viaje agregado!"."\n";
            return $responsable;
        }else {
            echo "El Responsable del viaje no se pudo agregar\n";
        }
    }
}

//Elimina un viaje (OPCION 4)
function eliminarDatosViaje(){
    $viaje = new Viaje();
    $colViajes = $viaje->listar("");
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

//Elimina un pasajero (OPCION 4)
function eliminarDatosPasajero(){
    $pasajero = new Pasajero();
    $colPasajeros = $pasajero->listar();

    echo "Listado de pasajeros: \n";
    foreach($colPasajeros as $unPasajero){
        echo "\n". $unPasajero ."\n";
        echo "**************************\n";
    }

    if(count($colPasajeros) > 0 ){
        echo "Ingrese el numero de documento del pasajero a eliminar: \n";
        $dniPasajero = trim(fgets(STDIN));
        if($dniPasajero != null && $pasajero->Buscar($dniPasajero)){
            if($pasajero->eliminar($dniPasajero)){
                echo "Se eliminó el pasajero con exito!\n";
            } else {
                echo "Ocurrió un error al intentar eliminar el pasajero.\n";
            }
        } else {
            echo "El pasajero con numero de documento: " . $dniPasajero . "no existe.\n";
        }
    } else {
        echo "No existen pasajeros registrados.\n";
    }
}

//Muestra los datos cargados de cada viaje (OPCION 5)
function mostrarDatosViaje($objViaje){
    $viajeInfo = null;
    $condicion = " idviaje = ";

	$id = seleccionarIdViaje($objViaje);
	if(!is_numeric($id) || $id == ""){
		echo "Por favor, ingrese un valor numérico. \n";
	}else{
        $condicion = $condicion . $id;
		$viajeInfo = $objViaje->listar($condicion);
    }

		if($viajeInfo != null){
          $retornaViaje = $objViaje->mostrarCol($viajeInfo); 
		  echo $retornaViaje;  
		}else{
          echo "No existe un viaje con ese id. \n";  
		}
}

?>