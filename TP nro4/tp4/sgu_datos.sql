INSERT INTO tipodocumento
VALUES  (1,'DNI','Documento Nacional de Identidad'),
        (2,'LC', 'Libreta Civica'),
        (3,'LE', 'Libreta de Enrolamiento');

INSERT INTO tipousuario
VALUES  (1,'Administrador', 'Usuario Administrador'),
        (2,'Normal', 'Usuario Normal');

INSERT INTO persona(idpersona,idtipodocumento,apellidos,nombre,numerodocumento,sexo,email)
VALUES  (1,1,'Administrador','Usuario',0,'M','admin@gugler.com.ar');

INSERT INTO usuario(idusuario,idpersona,idtipousuario,nombre,contrasenia)
VALUES (1,1,1,'admin','admin');