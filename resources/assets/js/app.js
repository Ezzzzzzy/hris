require("./bootstrap");
import React, { Component } from "react";
import ReactDOM from "react-dom";
import { Provider } from "react-redux";
import { Route, Switch, Link } from "react-router-dom";
import { ConnectedRouter as Router } from "react-router-redux";
import { store, history } from "./store";

import App from "./pages";

ReactDOM.render(
	<Provider store={store}>
		<Router history={history}>
			<App />
		</Router>
	</Provider>,
	document.getElementById("root")
);
