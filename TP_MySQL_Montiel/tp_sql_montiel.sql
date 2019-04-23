--1
SELECT * FROM productos order by pNombre ASC
1 Caramelos 1.5 Chico
2 Cigarrillos 45.89 Mediano
3 Gaseosa 15.8 Grande

--2
SELECT * from provedores where localidad = 'Quilmes'
100 Perez Perón 876 Quilmes


--3
SELECT * from envios where cantidad >= 200 and cantidad <= 300
101 3 225
102 3 300

--4
SELECT SUM(Cantidad) from envios
3280

--5
SELECT pNumero FROM `envios` LIMIT 3
1
2
3

--6
SELECT prov.Nombre, prod.pNombre FROM provedores prov, productos prod,envios en WHERE en.Numero = prov.Numero and en.pNumero = prod.pNumero
Perez  Caramelos
Aguirre Caramelos
Perez Cigarrillos
Gimenez Cigarrillos
Perez Gaseosa
Gimenez Gaseosa
Aguirre Gaseosa

--7
SELECT prov.nombre,prod.pNombre,prod.Precio, e.cantidad, ROUND(e.Cantidad * prod.Precio) AS monto FROM provedores prov, productos prod, envios e WHERE prov.numero = e.numero AND prod.pNumero = e.pNumero
Perez Caramelos 1.5 500 750
Aguirre Caramelos 1.5 600 900
Perez Cigarrillos 45.89 1500 68835
Gimenez Cigarrillos 45.89 55 2524
Perez Gaseosa 15.8 100 1580
Gimenez Gaseosa 15.8 225 3555
Aguirre Gaseosa 15.8 300 4740

--8
SELECT e.Cantidad AS total FROM envios e WHERE e.Numero = 102 AND e.pNumero = 1
total
600

--9
SELECT prod.pNumero AS Producto FROM provedores prov, envios e, productos prod WHERE prod.pNumero = e.pNumero AND prov.localidad = 'avellaneda' AND prov.numero = e.numero
Producto
2
3 

--10
SELECT prov.Domicilio AS Domicilio,prov.Localidad AS Localidad FROM provedores prov WHERE prov.Nombre LIKE '%i%'
Domicilio Localidad
Mitre 750 Avellaneda
Boedo 634 Bernal

--11
INSERT INTO `productos`(`pNombre`, `Precio`, `Tamaño`) VALUES ('Chocolate','chico',25.35)

--12
INSERT INTO `provedores`(`Nombre`) VALUES ('gomez')

--13
INSERT INTO `provedores`(`Numero`, `Nombre`, `Localidad`) VALUES (107,'rosales','la plata')

--14
UPDATE `productos` SET `Precio`= 97.50 WHERE `Tamaño` = 'Grande'

--15
UPDATE `productos` p, `envios` e SET `Tamaño`= "Mediano" WHERE p.pNumero = ANY(SELECT pNumero FROM `envios` WHERE Cantidad >= 300) AND p.Tamaño = "Chico"

--16
DELETE FROM `productos` WHERE `pNumero` = 1

--17
DELETE FROM `provedores` WHERE Numero NOT IN (SELECT Numero FROM `envios`)
