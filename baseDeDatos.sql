
CREATE DATABASE sistemaHierroForjado CHARACTER SET utf8 COLLATE utf8_general_ci;
USE sistemaHierroForjado;

-- Volcando estructura para tabla el_salvador.zonesv
DROP TABLE IF EXISTS `zonesv`;
CREATE TABLE IF NOT EXISTS `zonesv` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ZoneName` varchar(15) NOT NULL COMMENT 'Nombre de las zonas geógraficas de El Salvador',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Zonas geográficas de El Salvador';

-- Volcando datos para la tabla el_salvador.zonesv: ~4 rows (aproximadamente)
DELETE FROM `zonesv`;
/*!40000 ALTER TABLE `zonesv` DISABLE KEYS */;
INSERT INTO `zonesv` (`ID`, `ZoneName`) VALUES
	(1, 'Occidental'),
	(2, 'Central'),
	(3, 'Paracentral'),
	(4, 'Oriental');

DROP TABLE IF EXISTS `depsv`;
CREATE TABLE IF NOT EXISTS `depsv` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DepName` varchar(30) NOT NULL COMMENT 'Nombre del departamento',
  `ISOCode` char(5) NOT NULL COMMENT 'Código ISO Departamentos',
  `ZONESV_ID` int(11) NOT NULL COMMENT 'Zona geográfica del departamento',
  PRIMARY KEY (`ID`),
  KEY `fk_DEPSV_ZONESV_idx` (`ZONESV_ID`),
  CONSTRAINT `fk_DEPSV_ZONESV` FOREIGN KEY (`ZONESV_ID`) REFERENCES `zonesv` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='Departamentos de El Salvador';

-- Volcando datos para la tabla el_salvador.depsv: ~0 rows (aproximadamente)
DELETE FROM `depsv`;
/*!40000 ALTER TABLE `depsv` DISABLE KEYS */;
INSERT INTO `depsv` (`ID`, `DepName`, `ISOCode`, `ZONESV_ID`) VALUES
	(1, 'Ahuachapán', 'SV-AH', 1),
	(2, 'Santa Ana', 'SV-SA', 1),
	(3, 'Sonsonate', 'SV-SO', 1),
	(4, 'La Libertad', 'SV-LI', 2),
	(5, 'Chalatenango', 'SV-CH', 2),
	(6, 'San Salvador', 'SV-SS', 2),
	(7, 'Cuscatlán', 'SV-CU', 3),
	(8, 'La Paz', 'SV-PA', 3),
	(9, 'Cabañas', 'SV-CA', 3),
	(10, 'San Vicente', 'SV-SV', 3),
	(11, 'Usulután', 'SV-US', 4),
	(12, 'Morazán', 'SV-MO', 4),
	(13, 'San Miguel', 'SV-SM', 4),
	(14, 'La Unión', 'SV-UN', 4);
/*!40000 ALTER TABLE `depsv` ENABLE KEYS */;

-- Volcando estructura para tabla el_salvador.munsv
DROP TABLE IF EXISTS `munsv`;
CREATE TABLE IF NOT EXISTS `munsv` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `MunName` varchar(100) NOT NULL COMMENT 'Nombre del Municipio',
  `DEPSV_ID` int(11) NOT NULL COMMENT 'Departamento al cual pertenece el municipio',
  PRIMARY KEY (`ID`,`DEPSV_ID`),
  KEY `fk_MUNSV_DEPSV1_idx` (`DEPSV_ID`),
  CONSTRAINT `fk_MUNSV_DEPSV1` FOREIGN KEY (`DEPSV_ID`) REFERENCES `depsv` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=263 DEFAULT CHARSET=utf8 COMMENT='Municipios de El Salvador';

-- Volcando datos para la tabla el_salvador.munsv: ~0 rows (aproximadamente)
DELETE FROM `munsv`;
/*!40000 ALTER TABLE `munsv` DISABLE KEYS */;
INSERT INTO `munsv` (`ID`, `MunName`, `DEPSV_ID`) VALUES
	(1, 'Ahuachapán', 1),
	(2, 'Jujutla', 1),
	(3, 'Atiquizaya', 1),
	(4, 'Concepción de Ataco', 1),
	(5, 'El Refugio', 1),
	(6, 'Guaymango', 1),
	(7, 'Apaneca', 1),
	(8, 'San Francisco Menéndez', 1),
	(9, 'San Lorenzo', 1),
	(10, 'San Pedro Puxtla', 1),
	(11, 'Tacuba', 1),
	(12, 'Turín', 1),
	(13, 'Candelaria de la Frontera', 2),
	(14, 'Chalchuapa', 2),
	(15, 'Coatepeque', 2),
	(16, 'El Congo', 2),
	(17, 'El Porvenir', 2),
	(18, 'Masahuat', 2),
	(19, 'Metapán', 2),
	(20, 'San Antonio Pajonal', 2),
	(21, 'San Sebastián Salitrillo', 2),
	(22, 'Santa Ana', 2),
	(23, 'Santa Rosa Guachipilín', 2),
	(24, 'Santiago de la Frontera', 2),
	(25, 'Texistepeque', 2),
	(26, 'Acajutla', 3),
	(27, 'Armenia', 3),
	(28, 'Caluco', 3),
	(29, 'Cuisnahuat', 3),
	(30, 'Izalco', 3),
	(31, 'Juayúa', 3),
	(32, 'Nahuizalco', 3),
	(33, 'Nahulingo', 3),
	(34, 'Salcoatitán', 3),
	(35, 'San Antonio del Monte', 3),
	(36, 'San Julián', 3),
	(37, 'Santa Catarina Masahuat', 3),
	(38, 'Santa Isabel Ishuatán', 3),
	(39, 'Santo Domingo de Guzmán', 3),
	(40, 'Sonsonate', 3),
	(41, 'Sonzacate', 3),
	(42, 'Alegría', 11),
	(43, 'Berlín', 11),
	(44, 'California', 11),
	(45, 'Concepción Batres', 11),
	(46, 'El Triunfo', 11),
	(47, 'Ereguayquín', 11),
	(48, 'Estanzuelas', 11),
	(49, 'Jiquilisco', 11),
	(50, 'Jucuapa', 11),
	(51, 'Jucuarán', 11),
	(52, 'Mercedes Umaña', 11),
	(53, 'Nueva Granada', 11),
	(54, 'Ozatlán', 11),
	(55, 'Puerto El Triunfo', 11),
	(56, 'San Agustín', 11),
	(57, 'San Buenaventura', 11),
	(58, 'San Dionisio', 11),
	(59, 'San Francisco Javier', 11),
	(60, 'Santa Elena', 11),
	(61, 'Santa María', 11),
	(62, 'Santiago de María', 11),
	(63, 'Tecapán', 11),
	(64, 'Usulután', 11),
	(65, 'Carolina', 13),
	(66, 'Chapeltique', 13),
	(67, 'Chinameca', 13),
	(68, 'Chirilagua', 13),
	(69, 'Ciudad Barrios', 13),
	(70, 'Comacarán', 13),
	(71, 'El Tránsito', 13),
	(72, 'Lolotique', 13),
	(73, 'Moncagua', 13),
	(74, 'Nueva Guadalupe', 13),
	(75, 'Nuevo Edén de San Juan', 13),
	(76, 'Quelepa', 13),
	(77, 'San Antonio del Mosco', 13),
	(78, 'San Gerardo', 13),
	(79, 'San Jorge', 13),
	(80, 'San Luis de la Reina', 13),
	(81, 'San Miguel', 13),
	(82, 'San Rafael Oriente', 13),
	(83, 'Sesori', 13),
	(84, 'Uluazapa', 13),
	(85, 'Arambala', 12),
	(86, 'Cacaopera', 12),
	(87, 'Chilanga', 12),
	(88, 'Corinto', 12),
	(89, 'Delicias de Concepción', 12),
	(90, 'El Divisadero', 12),
	(91, 'El Rosario (Morazán)', 12),
	(92, 'Gualococti', 12),
	(93, 'Guatajiagua', 12),
	(94, 'Joateca', 12),
	(95, 'Jocoaitique', 12),
	(96, 'Jocoro', 12),
	(97, 'Lolotiquillo', 12),
	(98, 'Meanguera', 12),
	(99, 'Osicala', 12),
	(100, 'Perquín', 12),
	(101, 'San Carlos', 12),
	(102, 'San Fernando (Morazán)', 12),
	(103, 'San Francisco Gotera', 12),
	(104, 'San Isidro (Morazán)', 12),
	(105, 'San Simón', 12),
	(106, 'Sensembra', 12),
	(107, 'Sociedad', 12),
	(108, 'Torola', 12),
	(109, 'Yamabal', 12),
	(110, 'Yoloaiquín', 12),
	(111, 'La Unión', 14),
	(112, 'San Alejo', 14),
	(113, 'Yucuaiquín', 14),
	(114, 'Conchagua', 14),
	(115, 'Intipucá', 14),
	(116, 'San José', 14),
	(117, 'El Carmen (La Unión)', 14),
	(118, 'Yayantique', 14),
	(119, 'Bolívar', 14),
	(120, 'Meanguera del Golfo', 14),
	(121, 'Santa Rosa de Lima', 14),
	(122, 'Pasaquina', 14),
	(123, 'Anamoros', 14),
	(124, 'Nueva Esparta', 14),
	(125, 'El Sauce', 14),
	(126, 'Concepción de Oriente', 14),
	(127, 'Polorós', 14),
	(128, 'Lislique', 14),
	(129, 'Antiguo Cuscatlán', 4),
	(130, 'Chiltiupán', 4),
	(131, 'Ciudad Arce', 4),
	(132, 'Colón', 4),
	(133, 'Comasagua', 4),
	(134, 'Huizúcar', 4),
	(135, 'Jayaque', 4),
	(136, 'Jicalapa', 4),
	(137, 'La Libertad', 4),
	(138, 'Santa Tecla', 4),
	(139, 'Nuevo Cuscatlán', 4),
	(140, 'San Juan Opico', 4),
	(141, 'Quezaltepeque', 4),
	(142, 'Sacacoyo', 4),
	(143, 'San José Villanueva', 4),
	(144, 'San Matías', 4),
	(145, 'San Pablo Tacachico', 4),
	(146, 'Talnique', 4),
	(147, 'Tamanique', 4),
	(148, 'Teotepeque', 4),
	(149, 'Tepecoyo', 4),
	(150, 'Zaragoza', 4),
	(151, 'Agua Caliente', 5),
	(152, 'Arcatao', 5),
	(153, 'Azacualpa', 5),
	(154, 'Cancasque', 5),
	(155, 'Chalatenango', 5),
	(156, 'Citalá', 5),
	(157, 'Comapala', 5),
	(158, 'Concepción Quezaltepeque', 5),
	(159, 'Dulce Nombre de María', 5),
	(160, 'El Carrizal', 5),
	(161, 'El Paraíso', 5),
	(162, 'La Laguna', 5),
	(163, 'La Palma', 5),
	(164, 'La Reina', 5),
	(165, 'Las Vueltas', 5),
	(166, 'Nueva Concepción', 5),
	(167, 'Nueva Trinidad', 5),
	(168, 'Nombre de Jesús', 5),
	(169, 'Ojos de Agua', 5),
	(170, 'Potonico', 5),
	(171, 'San Antonio de la Cruz', 5),
	(172, 'San Antonio Los Ranchos', 5),
	(173, 'San Fernando (Chalatenango)', 5),
	(174, 'San Francisco Lempa', 5),
	(175, 'San Francisco Morazán', 5),
	(176, 'San Ignacio', 5),
	(177, 'San Isidro Labrador', 5),
	(178, 'Las Flores', 5),
	(179, 'San Luis del Carmen', 5),
	(180, 'San Miguel de Mercedes', 5),
	(181, 'San Rafael', 5),
	(182, 'Santa Rita', 5),
	(183, 'Tejutla', 5),
	(184, 'Cojutepeque', 7),
	(185, 'Candelaria', 7),
	(186, 'El Carmen (Cuscatlán)', 7),
	(187, 'El Rosario (Cuscatlán)', 7),
	(188, 'Monte San Juan', 7),
	(189, 'Oratorio de Concepción', 7),
	(190, 'San Bartolomé Perulapía', 7),
	(191, 'San Cristóbal', 7),
	(192, 'San José Guayabal', 7),
	(193, 'San Pedro Perulapán', 7),
	(194, 'San Rafael Cedros', 7),
	(195, 'San Ramón', 7),
	(196, 'Santa Cruz Analquito', 7),
	(197, 'Santa Cruz Michapa', 7),
	(198, 'Suchitoto', 7),
	(199, 'Tenancingo', 7),
	(200, 'Aguilares', 6),
	(201, 'Apopa', 6),
	(202, 'Ayutuxtepeque', 6),
	(203, 'Cuscatancingo', 6),
	(204, 'Ciudad Delgado', 6),
	(205, 'El Paisnal', 6),
	(206, 'Guazapa', 6),
	(207, 'Ilopango', 6),
	(208, 'Mejicanos', 6),
	(209, 'Nejapa', 6),
	(210, 'Panchimalco', 6),
	(211, 'Rosario de Mora', 6),
	(212, 'San Marcos', 6),
	(213, 'San Martín', 6),
	(214, 'San Salvador', 6),
	(215, 'Santiago Texacuangos', 6),
	(216, 'Santo Tomás', 6),
	(217, 'Soyapango', 6),
	(218, 'Tonacatepeque', 6),
	(219, 'Zacatecoluca', 8),
	(220, 'Cuyultitán', 8),
	(221, 'El Rosario (La Paz)', 8),
	(222, 'Jerusalén', 8),
	(223, 'Mercedes La Ceiba', 8),
	(224, 'Olocuilta', 8),
	(225, 'Paraíso de Osorio', 8),
	(226, 'San Antonio Masahuat', 8),
	(227, 'San Emigdio', 8),
	(228, 'San Francisco Chinameca', 8),
	(229, 'San Pedro Masahuat', 8),
	(230, 'San Juan Nonualco', 8),
	(231, 'San Juan Talpa', 8),
	(232, 'San Juan Tepezontes', 8),
	(233, 'San Luis La Herradura', 8),
	(234, 'San Luis Talpa', 8),
	(235, 'San Miguel Tepezontes', 8),
	(236, 'San Pedro Nonualco', 8),
	(237, 'San Rafael Obrajuelo', 8),
	(238, 'Santa María Ostuma', 8),
	(239, 'Santiago Nonualco', 8),
	(240, 'Tapalhuaca', 8),
	(241, 'Cinquera', 9),
	(242, 'Dolores', 9),
	(243, 'Guacotecti', 9),
	(244, 'Ilobasco', 9),
	(245, 'Jutiapa', 9),
	(246, 'San Isidro (Cabañas)', 9),
	(247, 'Sensuntepeque', 9),
	(248, 'Tejutepeque', 9),
	(249, 'Victoria', 9),
	(250, 'Apastepeque', 10),
	(251, 'Guadalupe', 10),
	(252, 'San Cayetano Istepeque', 10),
	(253, 'San Esteban Catarina', 10),
	(254, 'San Ildefonso', 10),
	(255, 'San Lorenzo', 10),
	(256, 'San Sebastián', 10),
	(257, 'San Vicente', 10),
	(258, 'Santa Clara', 10),
	(259, 'Santo Domingo', 10),
	(260, 'Tecoluca', 10),
	(261, 'Tepetitán', 10),
	(262, 'Verapaz', 10);

CREATE TABLE tipoPago(
  idTipoPago tinyint primary key,
  nombre varchar(7) not null
);
insert into tipoPago values(1, 'contado');
insert into tipoPago values(2, 'tarjeta');

/*
CREATE TABLE administrador(
  idAdministrador tinyint PRIMARY KEY AUTO_INCREMENT,
  nombre varchar(30) not null,
  apellido varchar(30) not null,
  usuario varchar(30) not null,
  email varchar(100) not null,
  clave varchar(60) not null,
  idPreguntaSecreta tinyint,
  respuestaPregunta varchar(60),
  fechaCreacion datetime not null default current_timestamp,
  foreign key(idPreguntaSecreta) references preguntaSecreta(idPreguntaSecreta)
);
insert into administrador values(null, 'Administrador', 'Principal', 'admin', 'admin@gmail.com', '90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad', null, null, now());
*/

/*OK*/
CREATE TABLE sucursal(
  idSucursal tinyint PRIMARY KEY AUTO_INCREMENT,
  nombre varchar(30) not null,
  direccion varchar(200) not null,
  telefono varchar(10) not null,
  estado boolean default 1 not null
);
insert into sucursal values(null,'Sucursal Principal','San Salvador','',1);

/*OK*/
CREATE TABLE empleado(
  idEmpleado mediumint PRIMARY KEY AUTO_INCREMENT,
  idSucursal tinyint not null,
  idDepto int not null,
  idMunic int not null,
  dui varchar(10) not null,
  nit varchar(20) not null,
  nombre varchar(30) not null,
  apellido varchar(30) not null,
  estadoCivil varchar(30) not null,
  sexo enum("Hombre","Mujer") not null,
  fechaNacimiento date not null,
  direccion varchar(100) not null,
  nivelAcademico varchar(50) not null,
  area varchar(50) not null,
  telefono varchar(10) not null,
  activo boolean default 1 not null,
  foreign key(idDepto) references depsv(ID),
  foreign key(idMunic) references munsv(ID),
  foreign key(idSucursal) references sucursal(idSucursal)
);
/*
insert into empleado values(null,1,'02637456-8','1011-230290-101-2','Pedro','Lainez','Soltero/a','Hombre','1990-02-23','Col. El Rosario','Zacatecoluca','La Paz','Bachillerato','Pintar','7352-3121',1);
insert into empleado values(null,1,'67543556-0','1010-040287-104-1','Rosa','Perez','Soltero/a','Mujer','1987-02-04','Col. La Esperanza','Zacatecoluca','La Paz','Bachillerato','Secretaria','6743-5673',1);
insert into empleado values(null,1,'67831124-4','1014-311292-100-3','Juan','Pineda','Casado/a','Hombre','1992-12-31','Col. 14 de Febrero','Tecoluca','San Vicente','Bachillerato','Soldar','7643-3743',1);
insert into empleado values(null,1,'56473828-2','1010-091292-102-2','Esmeralda','Medoza','Casado/a','Mujer','1992-12-09','Col. La Esperanza','Zacatecoluca','La Paz','Bachillerato','Pintar','7354-3903',1);
*/

CREATE TABLE tipoUsuario(
  idTipo tinyint PRIMARY KEY AUTO_INCREMENT,
  nombre varchar(15) not null,
  activo boolean not null default 1
);

insert into tipoUsuario values
(null,"Root",1),
(null,"Administrador",1),
(null,"Vendedor",1),
(null,"Producción",1);

CREATE TABLE tipoComprobante(
  idTipo tinyint PRIMARY KEY AUTO_INCREMENT,
  nombre varchar(30) not null
);

insert into tipoComprobante values
(null,"Factura"),
(null,"Comprobante de Crédito Fiscal"),
(null,"Recibo");

/*OK*/
CREATE TABLE usuario(
  idUsuario smallint PRIMARY KEY AUTO_INCREMENT,
  idEmpleado mediumint,
  nombre varchar(30) not null,
  apellido varchar(30) not null,
  usuario varchar(30) not null,
  email varchar(100),
  clave varchar(60) not null,
  tipo tinyint not null default 0,
  fechaCreacion datetime not null default current_timestamp,
  activo boolean default 1 not null,
  foreign key(tipo) references tipoUsuario(idTipo),
  foreign key(idEmpleado) references empleado(idEmpleado)
);
insert into usuario values(null,null,'Administrador','Principal','admin','admin@gmail.com','90b9aa7e25f80cf4f64e990b78a9fc5ebd6cecad',1,now(),1);

/*OK*/
CREATE TABLE banco(
  idBanco tinyint PRIMARY KEY AUTO_INCREMENT,
  idUsuario smallint not null,
  nombre varchar(30) not null,
  direccion varchar(200),
  telefono varchar(10),
  numeroCuenta varchar(25) not null,
  estado boolean default 1 not null,
  foreign key(idUsuario) references usuario(idUsuario)
);

/*OK*/
CREATE TABLE gasto(
  idGasto mediumint PRIMARY KEY AUTO_INCREMENT,
  idUsuario smallint not null,
  idEmpleado mediumint,
  descripcion varchar(100) not null,
  numeroComprobante varchar(32),
  pago decimal(9,2) not null,
  fecha date not null,
  estado boolean default 1 not null,
  foreign key(idUsuario) references usuario(idUsuario),
  foreign key(idEmpleado) references empleado(idEmpleado)
);

/*OK*/
CREATE TABLE envioBanco(
  idEnvioBanco smallint PRIMARY KEY AUTO_INCREMENT,
  idUsuario smallint not null,
  idBanco tinyint not null,
  cantidad decimal(9,2) not null,
  numComprobante varchar(32) not null,
  fecha datetime not null,
  estado boolean default 1 not null,
  foreign key(idUsuario) references usuario(idUsuario),
  foreign key(idBanco) references banco(idBanco)
);

/*OK*/
CREATE TABLE proveedor(
  idProveedor smallint PRIMARY KEY AUTO_INCREMENT,
  idUsuario smallint not null,
  nombre varchar(40) not null,
  tipoProvee enum("Productos","Servicios") not null,
  direccion varchar(200) not null,
  telefono varchar(10) not null,
  correo varchar(50),
  estado boolean default 1 not null,
  foreign key(idUsuario) references usuario(idUsuario)
);
/*
insert into proveedor values(null,2,'Galvanissa','Productos','San Salvador','2394-4599','galvanissa@gmail.com',1);
*/

/*OK*/
CREATE TABLE materiaPrima(
  idMateriaPrima int PRIMARY KEY AUTO_INCREMENT,
  idUsuario smallint not null,
  nombre varchar(50) not null,
  descripcion varchar(200) not null,
  minimo smallint not null,
  existencias mediumint not null default 0,
  /*precioUnitario decimal(6,2) not null,*/
  estado boolean default 1 not null,
  foreign key(idUsuario) references usuario(idUsuario)
);

CREATE TABLE facturaMateriaPrima(
  idFacturaMateriaPrima mediumint PRIMARY KEY AUTO_INCREMENT,
  idUsuario smallint not null,
  idProveedor smallint not null,
  tipoComprobante tinyint, /* Factura, CCF, Ticket */
  tipoPago tinyint not null default 1,
  numComprobante varchar(32),
  fecha datetime not null default current_timestamp,
  total decimal(9,2) not null,
  estado boolean default 1 not null,
  foreign key(idUsuario) references usuario(idUsuario),
  foreign key(idProveedor) references proveedor(idProveedor),
  foreign key(tipoComprobante) references tipoComprobante(idTipo),
  foreign key(tipoPago) references tipoPago(idTipoPago)
  /*foreign key(idCierreCaja) references cierreCaja(idCierreCaja)*/
);

CREATE TABLE compraMateriaPrima(
  idCompraMateriaPrima int PRIMARY KEY AUTO_INCREMENT,
  idFacturaMateriaPrima mediumint not null,
  idMateriaPrima int not null,
  cantidad int not null,
  precioUnitario double(9,2) not null,
  total double(9,2) not null,
  estado boolean default 1 not null,
  foreign key(idFacturaMateriaPrima) references facturaMateriaPrima(idFacturaMateriaPrima),
  foreign key(idMateriaPrima) references materiaPrima(idMateriaPrima)
);

CREATE TABLE cierreCaja(
  idCierreCaja tinyint PRIMARY KEY AUTO_INCREMENT,
  idUsuario smallint not null,
  idSucursal tinyint not null,
  fecha datetime not null default current_timestamp,
  estado boolean default 1 not null,
  foreign key(idUsuario) references usuario(idUsuario),
  foreign key(idSucursal) references sucursal(idsucursal)
);


CREATE TABLE categoria(
  idCategoria tinyint PRIMARY KEY AUTO_INCREMENT,
  idUsuario smallint not null,
  nombre varchar(50) not null,
  fecha datetime default current_timestamp,
  estado boolean default 1 not null,
  foreign key(idUsuario) references usuario(idUsuario)
);
insert into categoria values
(null,1,"Cerrajerí­a Ornamental",NOW(),1),
(null,1,"Artesaní­a",NOW(),1),
(null,1,"Mueblerí­a",NOW(),1),
(null,1,"Industrial",NOW(),1);


CREATE TABLE servicio(
  idServicio smallint PRIMARY KEY AUTO_INCREMENT,
  idUsuario smallint not null,
  nombre varchar(50) not null,
  descripcion varchar(200) not null,
  precio decimal(9,2) not null,
  estado boolean default 1 not null,
  foreign key(idUsuario) references usuario(idUsuario)
);

CREATE TABLE producto(
  idProducto mediumint PRIMARY KEY AUTO_INCREMENT,
  idUsuario smallint not null,
  idCategoria tinyint not null,
  nombre varchar(50) not null,
  descripcion varchar(255) not null,
  existencias int not null,
  precioCosteo decimal(9,2) not null,
  precioVenta decimal(9,2) not null,
  mantenimiento boolean not null default 0,
  imagen varchar(255),
  fechaRegistro datetime default current_timestamp not null,
  estado boolean default 1 not null,
  foreign key(idUsuario) references usuario(idUsuario),
  foreign key(idCategoria) references categoria(idCategoria)
);

CREATE TABLE productoSucursal(
  idProductoSucursal int PRIMARY KEY AUTO_INCREMENT,
  idSucursal tinyint not null default 1,
  idProducto mediumint not null,
  minimo int not null,
  cantidad int not null,
  foreign key(idProducto) references producto(idProducto),
  foreign key(idSucursal) references sucursal(idSucursal)
);

CREATE TABLE traspaso(
  idTraspaso mediumint PRIMARY KEY AUTO_INCREMENT,
  idUsuario smallint not null,
  idSucursalOrigen tinyint not null,
  idSucursalDestino tinyint not null,
  fecha datetime not null,
  estado boolean default 1 not null,
  foreign key(idUsuario) references usuario(idUsuario),
  foreign key(idSucursalOrigen) references sucursal(idSucursal),
  foreign key(idSucursalDestino) references sucursal(idSucursal)
);

CREATE TABLE traspasoProducto(
  idTraspasoProducto int PRIMARY KEY AUTO_INCREMENT,
  idTraspaso mediumint not null,
  idProducto mediumint not null,
  cantidad mediumint not null,
  estado boolean default 1 not null,
  foreign key(idTraspaso) references traspaso(idTraspaso),
  foreign key(idProducto) references producto(idProducto)
);

CREATE TABLE produccion(
  idProduccion mediumint PRIMARY KEY AUTO_INCREMENT,
  idUsuario smallint not null,
  idProducto mediumint not null,
  fechaInicio date not null,
  fechaFin date not null,
  cantidadProducto smallint not null,
  terminado boolean default 0,
  cancelado boolean default 0,
  fechaRegistro datetime not null default current_timestamp,
  fechaFinalizado datetime,
  foreign key(idUsuario) references usuario(idUsuario),
  foreign key(idProducto) references producto(idProducto)
);
/*
  fechaInicio y fechaFin: Desde cuando empieza la produccion y hasta cuando es el liimite...
  fechaRegistro y fechaFinalizado: cuando se registroo y cuando ya estaa realizado el producto o se canceloo...
*/

CREATE TABLE materiaPrimaProduccion(
  idMateriaPrimaProduccion int PRIMARY KEY AUTO_INCREMENT,
  idProduccion mediumint not null,
  idMateriaPrima int not null,
  cantidad decimal(6,2) not null,
  /*total decimal(6,2) not null,*/
  foreign key(idProduccion) references produccion(idProduccion),
  foreign key(idMateriaPrima) references materiaPrima(idMateriaPrima)
);

/*OK*/
CREATE TABLE cliente(
  idCliente mediumint PRIMARY KEY AUTO_INCREMENT,
  idUsuario smallint not null,
  dui varchar(10) not null,
  nombre varchar(30) not null,
  apellido varchar(30) not null,
  sexo enum("Hombre","Mujer") not null,
  fechaNacimiento date,
  direccion varchar(200) not null,
  telefono varchar(10) not null,
  nit varchar(20),
  email varchar(50),
  nrc varchar(20), /* No. De Registro De Contribuyente */
  estado boolean default 1 not null,
  foreign key(idUsuario) references usuario(idUsuario)
);

CREATE TABLE pedido(
  idPedido int PRIMARY KEY AUTO_INCREMENT,
  idSucursal tinyint not null,
  idUsuario smallint not null,
  idCliente mediumint not null,
  fechaPedido datetime not null,
  fechaEntrega date not null,
  entregado boolean not null default 0,
  cancelado boolean not null default 0,
  fechaFinalizado datetime,
  /*
  adelanto decimal(9,2) not null,
  tipoPago tinyint not null,
  */
  restante decimal(9,2) not null,
  estado boolean default 1 not null,
  foreign key(idUsuario) references usuario(idUsuario),
  foreign key(idCliente) references cliente(idCliente),
  foreign key(idSucursal) references sucursal(idSucursal)
  /*foreign key(tipoPago) references tipoPago(idTipoPago)*/
);

CREATE TABLE pedidoProducto(
  idPedidoProducto int PRIMARY KEY AUTO_INCREMENT,
  idPedido int not null,
  idProducto mediumint not null,
  cantidad int not null,
  precio decimal(9,2) not null,
  total decimal(9,2) not null,
  mantenimiento boolean not null default 0,
  estado boolean default 1 not null,
  foreign key(idPedido) references pedido(idPedido),
  foreign key(idProducto) references producto(idProducto)
);

CREATE TABLE pedidoServicio(
  idPedidoServicio int PRIMARY KEY AUTO_INCREMENT,
  idPedido int not null,
  idServicio smallint not null,
  cantidad smallint not null default 1,
  precio decimal(9,2) not null,
  total decimal(9,2) not null,
  estado boolean default 1 not null,
  foreign key(idPedido) references pedido(idPedido),
  foreign key(idServicio) references servicio(idServicio)
);

CREATE TABLE abono(
  idAbono mediumint PRIMARY KEY AUTO_INCREMENT,
  idUsuario smallint not null,
  idCliente mediumint not null,
  idPedido int not null,
  cantidad decimal(9,2) not null,
  fecha datetime not null,
  tipoComprobante tinyint not null default 1,
  numeroComprobante varchar(32),
  estado boolean default 1 not null,
  foreign key(tipoComprobante) references tipoComprobante(idTipo),
  foreign key(idPedido) references pedido(idPedido),
  foreign key(idUsuario) references usuario(idUsuario),
  foreign key(idCliente) references cliente(idCliente)
);

CREATE TABLE facturaVenta(
  idFacturaVenta int PRIMARY KEY AUTO_INCREMENT,
  idUsuario smallint not null,
  idSucursal tinyint not null,
  idCliente mediumint,
  idCierreCaja tinyint,
  numeroFactura varchar(12) not null,
  fecha datetime default current_timestamp not null,
  tipoComprobante tinyint not null,
  tipoPago tinyint not null default 1,
  totalLetras varchar(150),
  estado boolean default 1 not null,
  foreign key(idUsuario) references usuario(idUsuario),
  foreign key(idSucursal) references sucursal(idSucursal),
  foreign key(idCliente) references cliente(idCliente),
  foreign key(idCierreCaja) references cierreCaja(idCierreCaja),
  foreign key(tipoComprobante) references tipoComprobante(idTipo),
  foreign key(tipoPago) references tipoPago(idTipoPago)
);

CREATE TABLE ventaProducto(
  idVentaProducto int PRIMARY KEY AUTO_INCREMENT,
  idFacturaVenta int not null,
  idProducto mediumint not null,
  precio decimal(9,2) not null,
  cantidad smallint not null,
  total decimal(9,2) not null,
  mantenimiento boolean not null default 0,
  estado boolean default 1 not null,
  foreign key(idFacturaVenta) references facturaVenta(idFacturaVenta),
  foreign key(idProducto) references producto(idProducto)
);

CREATE TABLE ventaServicio(
  idVentaServicio int PRIMARY KEY AUTO_INCREMENT,
  idFacturaVenta int not null,
  idServicio smallint not null,
  precio decimal(9,2) not null,
  cantidad smallint not null default 1,
  total decimal(9,2) not null,
  estado boolean default 1 not null,
  foreign key(idFacturaVenta) references facturaVenta(idFacturaVenta),
  foreign key(idServicio) references servicio(idServicio)
);

CREATE TABLE causasDevolucion(
  idCausa tinyint PRIMARY KEY,
  idUsuario smallint not null,
  fecha datetime not null default current_timestamp,
  descripcion varchar(150) not null,
  foreign key(idUsuario) references usuario(idUsuario)
);

CREATE TABLE devolucion(
  idDevolucion smallint PRIMARY KEY AUTO_INCREMENT,
  idUsuario smallint not null,
  idFacturaVenta int not null,
  idProducto mediumint,
  idMotivo tinyint not null,
  fecha date not null,
  reembolso decimal(9,2) not null,
  estado boolean default 1 not null,
  foreign key(idUsuario) references usuario(idUsuario),
  foreign key(idFacturaVenta) references facturaVenta(idFacturaVenta),
  foreign key(idProducto) references producto(idProducto),
  foreign key(idMotivo) references causasDevolucion(idCausa)
);

CREATE TABLE cajaChica(
  idCajaChica tinyint PRIMARY KEY AUTO_INCREMENT,
  minimo decimal(6,2) not null,
  cantidad decimal(9,2) not null,
  entradas decimal(9,2) not null,
  salidas decimal(9,2) not null
);
insert into cajaChica values(null, 0, 0, 0, 0);

CREATE TABLE ingresoCajaChica(
  idIngresoCajaChica smallint PRIMARY KEY AUTO_INCREMENT,
  idUsuario smallint not null,
  idCajaChica tinyint not null default 1,
  cantidad decimal(9,2) not null,
  fecha date not null,
  estado boolean default 1 not null,
  foreign key(idUsuario) references usuario(idUsuario),
  foreign key(idCajaChica) references cajaChica(idCajaChica)
);

CREATE TABLE salidaCajaChica(
  idSalidaCajaChica smallint PRIMARY KEY AUTO_INCREMENT,
  idUsuario smallint not null,
  idCajaChica tinyint not null default 1,
  idEmpleado mediumint,
  cantidad decimal(9,2) not null,
  numComprobante varchar(32),
  descripcion varchar(200) not null,
  fecha date not null,
  estado boolean default 1 not null,
  foreign key(idUsuario) references usuario(idUsuario),
  foreign key(idCajaChica) references cajaChica(idCajaChica),
  foreign key(idEmpleado) references empleado(idEmpleado)
);

CREATE TABLE configuraciones(
  idConfig smallint PRIMARY KEY AUTO_INCREMENT,
  nombre varchar(20) not null,
  valor varchar(50) not null
);

insert into configuraciones values(null,'iva','0.13');
