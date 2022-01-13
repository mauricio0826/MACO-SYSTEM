CREATE SCHEMA `ventas` DEFAULT CHARACTER SET utf8mb4 ;

use ventas;

create table usuarios(
	id_usuario varchar(20),
	nombre varchar(50) not null,
	apellido varchar(50),
	password text(50) not null,
	fechaCaptura date not null,
	rol varchar(2) not null,
	primary key(id_usuario)
);

create table clientes(
	id_codigo varchar(20),
	nombre varchar(200) not null,
	apellido varchar(200) not null,
	direccion varchar(200) not null,
	telefono varchar(200) not null,	
	departamento varchar(200) not null,
	ciudad varchar(200) not null,
	razonsocial varchar(200) not null,
	primary key(id_codigo)
);

create table ventas(
	id_venta int auto_increment,
	id_cliente varchar(20) not null,
	id_producto varchar(30) not null,
	id_usuario varchar(20) not null,
	cantidad int not null,
	precio float not null,
	total float not null,
	fechaCompra date not null,
	primary key(id_venta)
);

create table articulos(
	id_producto varchar(30) not null,
	id_usuario varchar(20) not null,
	nombre varchar(50) not null,
	cantidad int not null,
	precio float not null,
	origen varchar(1) not null,
	fechaCaptura date not null,
	primary key(id_producto)
);

-- Recuerda agregar el id de usuario por favor 

create table gastos(
	id_codigoG int auto_increment,
	id_cliente varchar(20) not null,
	id_usuario varchar(20) not null,
	tipoG varchar(200),
	origenSelect varchar(200) not null,
	valor float,
	primary key(id_codigoG)
);

create table credito(
	id_CodigoC int auto_increment,
	id_cliente varchar(20) not null,
	id_usuario varchar(20) not null,
	tipoC varchar(200) not null,
	origenSelect varchar(200) not null,
	valor float not null,
	primary key(id_CodigoC)		
);

create table recaudo(
	id_codigoR int auto_increment,
	id_cliente varchar(20) not null,
	id_usuario varchar(20) not null,
	tipoR varchar(200) not null,
	origenSelect varchar(200) not null,
	valor float not null,
	primary key(id_codigoR)				
);

create table proveedores(
	id_codigo varchar(20),
	nombre varchar(200) not null,
	apellido varchar(200) not null,
	direccion varchar(200) not null,
	telefono varchar(200) not null,	
	razonsocial varchar(200) not null,
	primary key(id_codigo)
);

create table prestamo(
	id_codigoP varchar(20) not null,
	nombre varchar(20) not null,
	concepto varchar(50) not null,
	telefono  number not null,
	direccion varchar(20) not null,
	razonsocial varchar(20) not null,
	valorP number not null,
	primary key(id_codigoP)
);

