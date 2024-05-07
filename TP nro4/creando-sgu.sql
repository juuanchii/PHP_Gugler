CREATE DATABASE IF NOT EXISTS sgu;
USE sgu;

CREATE TABLE tipodocumento(
    idtipodocumento     int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre              varchar(5) NOT NULL,
    descripcion         varchar(60)          
);

CREATE TABLE tipousuario(
    idtipousuario       int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre              varchar(60) NOT NULL,
    descripcion         varchar(60)
);

CREATE TABLE persona(
    idpersona           int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idtipodocumento     int(11) NOT NULL,
    apellidos           varchar(50) NOT NULL,
    nombre              varchar(50) NOT NULL,
    numerodocumento     int(8) NOT NULL,
    sexo                varchar(1) NOT NULL,
    nacionalidad        varchar(11),
    email               varchar(100) NOT NULL,
    celular             varchar(20),
    provincia           varchar(100),
    localidad           varchar(100),
    FOREIGN KEY (idtipodocumento) REFERENCES tipodocumento(idtipodocumento)
);

CREATE TABLE usuario(
    idusuario           int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idpersona           int(11) NOT NULL,
    idtipousuario       int(11) NOT NULL,
    nombre              varchar(50) NOT NULL,
    contrasenia         varchar(50) NOT NULL,
    FOREIGN KEY (idpersona) REFERENCES persona(idpersona),
    FOREIGN KEY (idtipousuario) REFERENCES tipousuario(idtipousuario)
);