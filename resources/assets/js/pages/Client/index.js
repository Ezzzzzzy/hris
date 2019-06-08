import React from "react";
import { Route, Switch } from "react-router-dom";
import { connect } from "react-redux";
import List from "./List";
import Page from "./Page";
import Members from './Members';
import NotFound from '../NotFound';

const Client = props => (
	<Switch>
		<Route path={ props.match.url } component={ List } exact/>
		<Route path={props.match.url + "/page"} component={Page} />
		<Route path={ props.match.url + '/members' } component={ Members }/>
		<Route component={ NotFound } />
	</Switch>
);

export default connect(() => ({}))(Client);