import React from 'react';
import { BrowserRouter, Route, Switch } from "react-router-dom";

/* Contenido */
import Layout from './layout';

/* URL de page */
const AppRouter = () => (
    <BrowserRouter>
        <Switch>
            {/* -- Turno --*/}
            <Route exact path={'/'} component={Layout}/>
        </Switch>
    </BrowserRouter>
);

export default AppRouter;