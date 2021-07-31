import React from 'react';
import ReactDOM from 'react-dom';
import App from './AppRoot';
import { Provider } from 'react-redux';
import configureStore from './redux/store';
import 'react-toastify/dist/ReactToastify.css';

/**
 * Constructor de Redux con Provider en la división del id root
 */
if (document.getElementById('root')) {
    ReactDOM.render(
        <Provider store={configureStore()}>
            <App />
        </Provider>,
    document.getElementById('root'));
}