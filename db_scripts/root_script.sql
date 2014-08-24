drop user 'innowo_mwtestusr'@'localhost';
drop database innowo_mwtestdb;

create database innowo_mwtestdb;
create user 'innowo_mwtestusr'@'localhost' identified by 'innowo_mwtestusrpwd';
grant ALL ON innowo_mwtestdb.* TO 'innowo_mwtestusr'@'localhost';

