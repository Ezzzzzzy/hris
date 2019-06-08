import React from 'react';
import { Route, Switch } from 'react-router-dom';
import { connect } from 'react-redux';
import City from './City';
import Document from './Document';
import Location from './Location';
import Position from './Position';
import Reason from './Reason';
import Region from './Region';
import Status from './Status';
import Tenure from './Tenure';
import NotFound from '../NotFound';
import { Header, Menu } from './components';

const Settings = (props) => {
	return (
		<div>
			<Header />
			<div className="col-12">
				<div className="row settings-card">
					<Menu path={ props.location.pathname } />
					<Switch>
						<Route path={ props.match.url } component={ City } exact/>
						<Route path={ props.match.url + '/city' } component={ City }/>
						<Route path={ props.match.url + '/document' } component={ Document }/>
						<Route path={ props.match.url + '/location' } component={ Location }/>
						<Route path={ props.match.url + '/position' } component={ Position }/>
						<Route path={ props.match.url + '/reason' } component={ Reason }/>
						<Route path={ props.match.url + '/region' } component={ Region }/>
						<Route path={ props.match.url + '/status' } component={ Status }/>
						<Route path={ props.match.url + '/tenure' } component={ Tenure }/>
						<Route component={ NotFound }/>
					</Switch>
				</div>
			</div>
		</div>
	);
}

export default connect(()=>({}))(Settings);