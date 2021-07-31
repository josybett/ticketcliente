# Instalacion

---

- [BD](#section-1)
- [Configurar Enviroment](#section-2)
- [Comandos](#section-3)

<a name="section-1"></a>
## BD

Crear una base de datos en Postgres con el nombre de `ticket_cliente`


`CREATE DATABASE ticket_cliente ENCODING 'UTF8';`


<a name="section-2"></a>
## Configurar Enviroment

Configurar el archivo `.env` con la siguiente información:

| # | Variable   | Dato |
| : |   :-   |  :  |
| 1 | DB_HOST | su host / ip  |
| 2 | DB_PORT | su puerto de conexión a la base de datos  |
| 3 | DB_DATABASE | ticket_cliente  |
| 4 | DB_USERNAME | su usuario de base de datos  |
| 5 | DB_PASSWORD | su clave de base de datos  |


<a name="section-3"></a>
## Comandos

### Ejecutar los comandos en la consola cmd

 `npm install`

 `composer install`

### Para migrar las tablas y datos de catálogo, ejecutar:

`php artisan migrate:fresh --seed`

> {info} Para ejecutar la aplicación `php artisan serve`
 

