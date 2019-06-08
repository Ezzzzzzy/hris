import React, { Component } from 'react';
import { Route, Switch } from 'react-router-dom';
import Member from './Member';
import Client from './Client';
import Navbar from '../components/Navbar';
import Reports from './Reports';
import Settings from './Settings';
import NotFound from './NotFound';
import { Table } from '../components';

class App extends Component {
	render() {
		return (
			<div>
				<Navbar />
				<Switch>
					<Route path='/members' component={ Member } />
					<Route path='/clients' component={ Client }/>
					<Route path='/reports' component={ Reports } />
					<Route path='/settings' component={ Settings } />
					<Route component={ NotFound }/>
				</Switch>
			</div>
		);
	}
}

export default App;