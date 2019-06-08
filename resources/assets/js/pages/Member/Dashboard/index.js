import React, { Component } from 'react';
import { Breadcrumb } from '../../../components';
import { 
	Header, 
	Personal, 
	WorkHistory 
} from './components';

const Dashboard = () => {
	return (
		<div>
			<Header />
			<Breadcrumb
				page={'Member'}
				firstname={'Daryl'}
				lastname={'Sinon'}
				label={'Dashboard'}
			/>
			<Personal />
			<WorkHistory />
		</div>
	);
}

export default Dashboard;