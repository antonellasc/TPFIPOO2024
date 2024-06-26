-- Active: 1718317633486@@127.0.0.1@3306@bdviajes

CREATE DATABASE bdviajes; 

CREATE TABLE empresa(
    idempresa bigint AUTO_INCREMENT,
    enombre varchar(150),
    edireccion varchar(150),
    PRIMARY KEY (idempresa)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE responsable (
    rnumeroempleado bigint AUTO_INCREMENT,
    rnumerolicencia bigint,
    nrodoc varchar(15), 
    PRIMARY KEY (rnumeroempleado),
    FOREIGN KEY (nrodoc) REFERENCES persona (nrodoc)
    ON UPDATE CASCADE ON DELETE CASCADE
    )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
	
CREATE TABLE viaje (
    idviaje bigint AUTO_INCREMENT, /*codigo de viaje*/
	vdestino varchar(150),
    vcantmaxpasajeros int,
	idempresa bigint,
    rnumeroempleado bigint,
    vimporte float,
    PRIMARY KEY (idviaje),
    FOREIGN KEY (idempresa) REFERENCES empresa (idempresa),
	FOREIGN KEY (rnumeroempleado) REFERENCES responsable (rnumeroempleado)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 1;
	

CREATE TABLE persona (
nombre varchar(150),
apellido varchar(150),
nrodoc varchar(15),
telefono int,
PRIMARY KEY (nrodoc)
)ENGINE=InnoDB DEFAULT CHARSET=utf8; 


CREATE TABLE pasajero (
    nroticket bigint AUTO_INCREMENT,
    nroasiento bigint,
	idviaje bigint,
    nrodoc varchar(15),
    PRIMARY KEY (nroticket),
    FOREIGN KEY (idviaje) REFERENCES viaje (idviaje)
    ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (nrodoc) REFERENCES persona (nrodoc)
    ON UPDATE CASCADE ON DELETE CASCADE
    )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 1; 
 
  
