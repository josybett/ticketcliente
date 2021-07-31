import { createStore } from 'redux';
import drawerReducer from './reducers/drawer.reducer';

/**
 * Función para la configuración inicial de Redux
 * @param {*} state Objet del estado
 * @returns creación de redux
 */
function configureStore(state = { open: false }) {
  return createStore(drawerReducer,state);
}

export default configureStore;