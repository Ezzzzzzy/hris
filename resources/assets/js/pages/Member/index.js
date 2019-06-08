import React from 'react';
import { Route, Switch } from 'react-router-dom';
import { connect } from 'react-redux';
import Form from './Form';
import Profile from './Profile';
import List from './List';
import Dashboard from './Dashboard';
import Deployment from './Deployment';
import NotFound from '../NotFound';

const Member = ({match}) => (
	<Switch>
		<Route path={ match.url } component={ List } exact/>
		<Route path={ match.path + '/add' } component={ Form }/>
		<Route path={ match.url + '/profile/:memberId' } component={ Profile }/>
		<Route path={ match.url + '/edit/:memberId' } component={ Form }/>
		<Route path={ match.url + '/dashboard' } component={ Dashboard }/>
		<Route path={ match.url + '/deployment' } component={ Deployment } />
		<Route component={ NotFound } />
	</Switch>
);

export default connect(() => ({}))(Member);
