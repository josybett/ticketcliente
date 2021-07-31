# Backend

---

- [Modelos](#section-1)
- [Controladores](#section-2)
- [Endpoint](#section-3)
- [Utilidad](#section-4)

<a name="section-1"></a>
## Modelos

Los modelos empleados fueron los siguientes:

### Client

Variable protegida `table` nombre de la tabla

Variable protegida `fillable` un objet con los nombres de los atributos de la tabla

Definición de relación con la tabla `turn` de uno a mucho


### CatQueues

Variable protegida `table` nombre de la tabla

Variable protegida `fillable` un objet con los nombres de los atributos de la tabla

Definición de relación con la tabla `turn` de uno a mucho


### Turn

Variable protegida `table` nombre de la tabla

Variable protegida `fillable` un objet con los nombres de los atributos de la tabla

Definición de relaciones con las tablas:

| # | Tabla   | Relación |
| : |   :-   |  :  |
| 1 | `client` | de muchos a uno  |
| 2 | `cat_queues` | de muchos a uno  |


<a name="section-2"></a>
## Controladores

### TurnController

Controlador para el manejo de consulta e inserción en las tablas `turn` y `client`.
Controla la asignación que corresponde según cada cola y el tiempo de atención.
Recupera los turnos y verifica en lotes de 5 para quitar de la cola los que ya han sido atentidos.
Se consideró la consulta cada 5seg y en lotes de 5 tuplas para verificar, tomando en cuenta el rendimiento del servicio y servidor.



<a name="section-3"></a>
## Endpoint

> {warning} La URI de los endpoints no incluyen el `${dominio}/api` antes de la uri indicada:
`example.com/api/turn`

### Respuesta Code 200

> {success} Las respuestas Code 200 tienen la estructura `{status: true, response: data}`


### Respuesta Code 500

> {danger} Las respuestas Code 500 tienen la estructura `{status: false, response: error}`


### Consultar Turno

| Method | URI   | Headers |
| : |   :-   |  :  |
| GET | `/turn ` | Default  |

#### URL Params

<larecipe-card shadow>
    None
</larecipe-card>

### Insertar Turno

| Method | URI   | Headers |
| : |   :-   |  :  |
| POST | `/turn ` | Default  |

#### URL Params

<larecipe-card shadow>
    None
</larecipe-card>

#### Data Params

<larecipe-card shadow>
    {
    "client": {
        "name": "nombre usaurio",
        "identification": "identificacion usuario"
    }
}
</larecipe-card>


<a name="section-4"></a>
## Utilidad


### Log

Única utilidad en el proyecto, considerada como indispensable para obtener el registro de errores o excepciones del controlador, identificando la función ejecutada con el error que haya generado. Con la finalidad de optimizar la revisión y corrección necesarias.

