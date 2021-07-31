# Estructura

---

- [MER](#section-1)
- [Proyecto](#section-2)

<a name="section-1"></a>
## Modelo Entidad Relación

![image](https://raw.githubusercontent.com/josybett/ticketcliente/main/public/image/Diagram.png)

### Tabla: client

En esta tabla de cliente, se almacena los datos de identificación y nombre de la persona que está solicitando un turno.
En el caso de que exista, se realiza un update al registro.

### Tabla: cat_queues

Catálogo de Colas, en donde se puede crear n cantidad de colas con los atributos de nombre y tiempo.
El atributo de `time_queues` es de tipo `time` considerado en el formato de HH:mm:ss

### Tabla: turn

La tabla de turnos, se almacena los tickets asigandos a las diferentes colas, teniendo cada una de ella una numeración separada.
Los atributos de esta tabla están compuesto por llaves foráneas de client y cat_queues, adicional del número de ticket 
y fecha-hora estimada para ser atendido de acuerdo al tiempo de cada cola

### Tabla: migrations

Es generada al momento de ejecutar el migrate, donde especifica el nombre de los archivos ejecutados para la creación de las tablas anteriormente mencionadas



<a name="section-2"></a>
## Proyecto

### Api's

Las api's están separadas en la carpeta `app`, clasificados en Modelos y Controladores. 
Adicional carpeta util para generar archivo de `log` en el caso de existir alguna excepción en las funciones de los controladores

### Front

El front se encuetra en el directorio de `resources/js` separando los componentes de la vista, las constantes, layout principal, 
provider, redux, en la raíz el root de react
