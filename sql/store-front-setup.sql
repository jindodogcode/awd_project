CREATE DATABASE IF NOT EXISTS storefront;

GRANT select, insert, update, delete, index, alter, create, drop, event, trigger, create view,
    show view, create routine, execute, alter routine
ON storefront.*
TO 'storefrontadmin'@'localhost'
IDENTIFIED BY 'storefrontadmin'
WITH GRANT OPTION;

GRANT file
ON *.*
TO 'storefrontadmin'@'localhost';

GRANT select, insert, delete, update
ON storefront.*
TO 'storefrontweb'@'localhost'
IDENTIFIED BY 'storefrontweb';
