# pharma-credits
Prueba de concepto

## Requerimientos

- [x] Lenvatar servicios externos de docker: MySQL y opcionalemte SonarQube y Adminer con [ginsen/docker-services](https://github.com/ginsen/docker-services)
- [x] docker-compose
- [x] git

## Instalación de Servicios externos

Descargar aplicacion de servicios esternos, y seguir sus instrucciones:

```bash
$ git clone https://github.com/ginsen/docker-services.git
```

Levantar el servicio de MySQL y opcionalmente Adminer y SonarQube (requiere levantar también PostGreSQL).

## Instalación
Descarga el proyecto de **ginsen/pharma-credits**.

```bash
$ git clone https://github.com/ginsen/pharma-credits.git
$ cd pharma-credits
```

## Variables de entorno
Copia y personaliza las variables de entorno.

```bash
$ cp .env.dist .env
```

Cambia los parametros que hay dentro del archivo `.env`, concretamente los de la seccion **Docker environment** por tus
valores personalizados.

## Añadir usuario SSH
Copia tu claves SSH para poder acceder con tu propio usuario dentro de contendor de docker.

```bash
$ cp ~/.ssh/id_rsa.pub ./docker/bash/ssh/
$ cp ~/.ssh/id_rsa ./docker/bash/ssh/
```

## Construir contenedor de Docker

```bash
$ docker-compose build
$ docker-compose up -d
```

## Entrar en el contenedor

```bash
$ docker-compose exec web bash
```

## Instalar dependencias

```bash
$ composer install 
```

## Cargar datos de prueba

```bash
$ make load-fixtures
```
> Ejecuta `make` para ver todas las opciones.

## Lanzar test

Test unitarios en modo resumen.
```bash
$ ./bin/phpunit
```

Test unitarios con detalle
```bash
$ make test
```

## Acceso web

Applicación | Url
----------- | ---
API Rest    | http://localhost:8080/api/doc
Adminer     | http://localhost:8081/?server=mysql&username=root&db=pharma_points
SonarQube   | http://localhost:8183/projects


Adminer es un visor de base de datos más ligero que phpmyadmin, Para validarse usar:

- Servidor: mysql
- Usuario: root
- Contraseña: root
- Base de datos: pharma_points

