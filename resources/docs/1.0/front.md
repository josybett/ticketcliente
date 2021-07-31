# Frontend

---

- [General](#section-1)
- [Layout](#section-2)
- [Componentes](#section-3)
- [Constantes](#section-4)

<a name="section-1"></a>
## General

Se implementó:

<larecipe-card>
    <larecipe-badge type="success" circle class="mr-3" icon="fa  fa-check"></larecipe-badge> JavaScript con React
    <larecipe-badge type="success" circle class="mr-3" icon="fa  fa-check"></larecipe-badge> Redux
    <larecipe-badge type="success" circle class="mr-3" icon="fa  fa-check"></larecipe-badge> Material-UI-Desig
    <larecipe-badge type="success" circle class="mr-3" icon="fa  fa-check"></larecipe-badge> React-Toastify
    <larecipe-badge type="success" circle class="mr-3" icon="fa  fa-check"></larecipe-badge> Axios
    <larecipe-badge type="success" circle class="mr-3" icon="fa  fa-check"></larecipe-badge> Node Sass
    <larecipe-badge type="success" circle class="mr-3" icon="fa  fa-check"></larecipe-badge> React Router Dom
</larecipe-card>


<a name="section-2"></a>
## Layout

Singlepage que contiene diferentes componentes y acciones que cumple con los requerimientos iniciales del proyecto.



<a name="section-3"></a>
## Componentes

Refactorización del html en secciones para optimizar el funcionamiento y mantenimiento del mismo. Cada componente está compuesto por dos archivos, la vista html (.jsx) y un index.js para indexar el componente.

| Componente | Finalidad   | 
| : |   :-   |
| `FormularioTurno` | Maquetado del Formulario y acción de envío a la api para insertar el turno |
| `TablaTurno` | Maquetado de la tabla que despliega los últimos turnos atendidos y los próximos a atender |
| `TurnoBoton` | Botòn flotante que despliega un drawer que contiene el `FormularioTurno` |


<a name="section-3"></a>
## Constantes

### Api

Variables que contiene las direciones URL de las apis a implementar.

### Redux

Variables que contiene nombre de la función de cambio de estado ejecutado en el proyecto.