import React from 'react';
import { BrowserRouter, Route, Switch } from "react-router-dom";

/* Contenido */
import Layout from './layout';

const AppRouter = () => (
    <BrowserRouter>
        <Switch>
            {/* -- Turno --*/}
            <Route exact path={'/turno'} component={Layout}/>
        </Switch>
    </BrowserRouter>
);

export default AppRouter;