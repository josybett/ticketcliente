import { createStore } from 'redux';
import drawerReducer from './reducers/drawer.reducer';

function configureStore(state = { open: false }) {
  return createStore(drawerReducer,state);
}

export default configureStore;