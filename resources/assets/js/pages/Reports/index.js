import React from 'react';
import { Route, Switch } from 'react-router-dom';
import { connect } from 'react-redux';
import GeneratedReport from './GeneratedReports';
import SavedTemplates from './SavedTemplates';
import Menu from './Component/Menu';
import Header from './Component/Header';
import HeaderBreadCrumbs from './Component/HeaderBreadCrumbs';
import NotFound from '../NotFound';
import './styles.css';

const Reports = ({match}) => (
	<div>
		<Header />
		<HeaderBreadCrumbs />
		<div className='menu-table'>
			<Menu className='col-xs-2' />
			<Switch className='reports'>
				<Route path={ match.url } component={ GeneratedReport } exact />
				<Route path={ match.url + '/generated-reports'} component={ GeneratedReport } />
				<Route path={ match.url + '/saved-templates'} component={ SavedTemplates } />
				<Route component={ NotFound } />
			</Switch>
		</div>
	</div>
);

export default connect(() => ({}))(Reports);
