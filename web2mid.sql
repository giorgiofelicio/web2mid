create database web2mid;

use web2mid;

create table profile (
'username' varchar(20) NOT NULL,
'nama' varchar(50) DEFAULT NULL,
'email' varchar(30) DEFAULT NULL,
'password' varchar(20) NOT NULL,
'image' varchar(1024) NOT NULL,
PRIMARY KEY('username')
)

