<?php

include_once 'BaseDatos.php';
include_once 'Persona.php';
include_once 'Pasajero.php';
include_once 'ResponsableV.php';
include_once 'Viaje.php';
include_once 'Empresa.php';

$objEmpresa = New Empresa();
$objViaje = New Viaje();
$objPasajero = New Pasajero();
$objResponsable = New ResponsableV();

function checkEmpresa($objEmpresa){
    $hayEmpresaCreada = false;
    $arregloEmpresa  = $objEmpresa->listar();
    if(count($arregloEmpresa) == null){
        $empresaNombre = "Viaje Feliz";
        $empresaDomicilio = "Belgrano 600";
        $objEmpresa->cargar(null, $empresaNombre, $empresaDomicilio);
        $objEmpresa->insertar();
        $hayEmpresaCreada = true;
    }else{
        $hayEmpresaCreada = true;
    }
    return $hayEmpresaCreada;
}

function opciones(){ 
        echo "\n+--------------------------------------------------+\n";
        echo "MENU DE OPCIONES PRINCIPAL". "\n\n";
        echo "1: Ingresar nuevo Viaje". "\n";
        echo "2: Ingresar nueva empresa \n";
        echo "3: Modificar un Viaje existente". "\n";
        echo "4: Ingresar Pasajeros". "\n";
        echo "5: Opciones para eliminar". "\n";
        echo "6: Mostrar datos del viaje". "\n";
        echo "7: Modificar datos de la Empresa". "\n";
        echo "8: Salir". "\n";
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
        echo "Elija una opcion: \n";
        echo "+====================================+\n";
        $opcion = trim(fgets(STDIN));
        
    return $opcion;
}
function opcionesEliminar(){
        echo "+====================================+\n";
        echo "OPCIONES PARA ELIMINAR.". "\n";
        echo "1. Eliminar viaje". "\n";
        echo "2. Eliminar pasajero.". "\n";
        echo "3. Eliminar empresa.". "\n";
        echo "4. Salir \n";
        echo "Elija una opcion: \n";
        echo "+====================================+\n";
        $opcion = trim(fgets(STDIN));
    
    return $opcion;
}

do{
    $advertencia = checkEmpresa($objEmpresa);

    if($advertencia == true){
        $opcion = opciones();
    }else{
        $opcion = 7;
    }
    switch ($opcion) {
        case 1:
            ingresarNuevoViaje($objEmpresa);
            break;
        case 2;
        ingresarNuevaEmpresa($objEmpresa);
            break;  
        case 3:
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
        case 4:
            $valor = seleccionarIdViaje($objViaje);
            insertarPasajeros($valor, $objViaje);
            break;
        case 5:
            
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
                        eliminarDatosEmpresa();
                        break;
                    case 4:
                        echo "SALIENDO AL MENU PRINCIPAL \n";
                        break; 

                    default:
                        echo "Opción no válida. Intente nuevamente.\n";
                        break;
                }
            }while ($opcionesEliminar != 4);
            break;
            
        case 6:
            mostrarDatosViaje($objViaje);
            break;
        case 7:
            modificarDatosEmpresa($objEmpresa);
        case 8:
            echo "*<<<<<<<<<<<<<<<< FIN DEL PROGRAMA >>>>>>>>>>>>>>>>* \n" ;
            break;
    }

} while ($opcion != 8);

function ingresarNuevaEmpresa($objEmpresa){
    $colEmpresas = $objEmpresa->listar();

    echo "Ingrese el nombre de la empresa: \n";
    $nombreEmpresa = trim(fgets(STDIN));
    echo "Ingrese el domicilio de la empresa: \n";
    $domicilioEmpresa = trim(fgets(STDIN));

    $empresa = new Empresa();
    $empresa->cargar(null, $nombreEmpresa, $domicilioEmpresa);
    if ($empresa->insertar()){
        echo "Empresa agregado con exito \n";
    } else {
        echo "(!!!)La emopresa no se pudo agregar\n";
    }
    
}

//Incorpora un nuevo viaje a la Empresa (OPCION 1)
function ingresarNuevoViaje($objEmpresa){
    $empresas = $objEmpresa->listar();
    
    if (count($empresas) > 0) {
        echo "Listado de empresas existentes: \n";
        foreach ($empresas as $unaEmpresa) {
            echo "\n" . $unaEmpresa . "\n";
            echo "**************************\n";
        }
        
        echo "Ingrese el ID de la empresa a la que desea agregar el viaje: ";
        $idEmpresaSeleccionada = trim(fgets(STDIN));
        
        // Verificar que el ID ingresado sea válido y exista en la lista de empresas
        $empresaSeleccionada = null;
        foreach ($empresas as $unaEmpresa) {
            if ($unaEmpresa->getIdEmpresa() == $idEmpresaSeleccionada) {
                $empresaSeleccionada = $unaEmpresa;
            }
        }
        
        if ($empresaSeleccionada) {
            echo "Ingrese el destino del viaje: ";
            $destino = trim(fgets(STDIN));
            echo "Ingrese la cantidad máxima de pasajeros: ";
            $cantMaxPasajeros = trim(fgets(STDIN));

            $nuevoResponsable = insertarResponsable();

            echo "Ingrese el importe del viaje: ";
            $importe = trim(fgets(STDIN));

            $viaje = new Viaje();
            $viaje->cargar(null, $destino, $cantMaxPasajeros, $nuevoResponsable, $empresaSeleccionada, $importe);
            $seAgrego = $viaje->insertar();
            if($seAgrego){
                echo "Viaje agregado con éxito!\n";
            } else {
                echo "(!!!)El viaje no se pudo agregar\n";
            }
        } else {
            echo "ID de empresa no válido.\n";
        }
    } else {
        echo "No hay empresas registradas.\n";
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
    // $empresa = new Empresa();
    $resp = new ResponsableV();

    echo "--------------------------------------------------------\n";
        echo "Nuevo destino: \n";
        $nuevoDestino = trim(fgets(STDIN));
        echo "Nueva cantidad maxima de Pasajeros: \n";
        $nuevaCapacidad = trim(fgets(STDIN));
        echo "Nuevo Importe: \n";
        $nuevoImporte = trim(fgets(STDIN));
        // echo "¿Desea cambiar al responsable del viaje? s/n \n";
        // $rta = strtolower(trim(fgets(STDIN)));
        // if($rta == "s"){
	        
	    //     $colResponsables = $responsable->listar("");
        //     echo $viajes->mostrarCol($colResponsables);
	    //     echo "A continuación, ingrese el número de empleado del responsable por el que desea cambiar: \n";
	    //     $nronuevo = trim(fgets(STDIN));
	    //     if(is_integer($nronuevo)){
		//     if($responsable->buscar($nronuevo)){
		// 	$viajes->setObjResponsable($nronuevo);
        //     }}}

        
        $viajes->setDestino($nuevoDestino);
        $viajes->setCantMaxPasajeros($nuevaCapacidad);
        // $viajes->setObjEmpresa($nuevoIdEm);
        // $viajes->setObjResponsable($nuevoNroEmpleado);
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

        if($responsable == null){
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
function eliminarDatosEmpresa(){
    $empresa = new Empresa();
    $colEmpresa = $empresa->listar("");
    echo "Listado de empresas: \n";
    foreach($colEmpresa as $unaEmpresa){
        echo "\n". $unaEmpresa ."\n";
        echo "*************\n";
    }
    
    if(count($colEmpresa) > 0 ){
        echo "Ingrese el id de la empresa a eliminar: \n";
        $idEmpresa = trim(fgets(STDIN));

        if((is_numeric ($idEmpresa)) && $idEmpresa != "" && $empresa->Buscar($idEmpresa)){
            if($empresa->eliminar()){
                echo "Se elimino la empresa con exito!\n";
            } else {
                echo "(!!!) La empresa no puede ser eliminada porque hay Viajes que dependen de ella.\n";
            }
        } else {
            echo "la empresa con id $idEmpresa no existe.\n";
        }
    } else {
        echo "No se encuentran empresas registradas.\n";
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
        }  
		// }else{
        //   echo "No existe un viaje con ese id. \n";  
		// }
}

//Modifica datos de una empresa(OPCION 6)
function modificarDatosEmpresa($objEmpresa){
    $empresaMod  = $objEmpresa->listar();
    foreach($empresaMod as $empresa){
        echo $empresa->__toString();
    }
    echo ">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n";
    echo "Ingrese el ID de la empresa a modificar: \n";
    $idEmpresa = trim(fgets(STDIN));
    echo "Ingrese el nuevo nombre: \n";
    $modEmpresa = trim(fgets(STDIN));
    echo "Ingrese la nueva dirección: \n";
    $modDireccion = trim(fgets(STDIN));
    if($modEmpresa != "" && $modDireccion != ""){
        $empresa->setNombreEmpresa($modEmpresa);
        $empresa->setDomicilioEmpresa($modDireccion);
        $cambio = $empresa->modificar($idEmpresa);
        if($cambio){
            echo "Cambios realizados con éxito! \n";
        }else{
            echo "No es posible modificar la empresa. \n";
        }
        }else{
        echo "Por favor, ingrese datos válidos. \n";    
    }
}
?>