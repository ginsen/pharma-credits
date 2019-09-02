# pharma-credits
Prueba de concepto

## Requerimientos

- [x] php ^7.2
- [x] MySQL ^5.7 (Pruebas realizadas com MySQL 8.0.17)

## Instalación

Descarga el proyecto

```bash
$ git clone https://github.com/ginsen/pharma-credits.git
$ cd pharma-credits
```

Personaliza las variables de entorno.

```bash
$ cp .env .env.local
```

Remplaza el valor de la variable **DATABASE_URL** por tu configuración de mysql.

```dotenv
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/pharma_credits
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

## Iniciar demo

Levanta el proyecto en `http://127.0.0.1:8000`

```bash
$ make start
```

Para pararlo, lanzar `make stop`.

## Lanzar test

Test unitarios.
```bash
$ make test
```
