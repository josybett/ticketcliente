import { SETOPEN } from "../../constants/redux";

/* Estado inicial */
const initialState = {
    open: false
};

/**
 * Función para el control de acciones de redux
 * @param {*} state Objeto del estado
 * @param {*} action string del nombre de la acción
 * @returns cambio de redux
 */
const drawerReducer = (state = initialState, action) => {
    switch (action.type) {
        case SETOPEN:
            return {
                open: action.payload
            }
        default:
            return state;
    }
};

export default drawerReducer;