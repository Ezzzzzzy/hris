import React, { Component } from 'react';
import {
	Header,
	DeploymentDetails,
	GeneralDetails
} from './components';
import { HeaderBreadcrumbs } from '../../../common/_all';
import { NewDeployment } from './components/Modal';

class Deployment extends Component {
	constructor(props) {
		super(props);
		this.state = {
			data: {
				first_name: "Vincent Ulap",
				middle_name: "Carino",
				last_name: "Camilon",
				extension_name: "Jr."
			}
		}
	}

	render() {
		return (
			<div>
				<div>
					<Header data={this.state.data} />
					<div id="breadcrumb-deployment">
						<HeaderBreadcrumbs data={this.state.data} />
					</div>
				</div>
				<div className="col-12">
					<div className="row">
						<div className="col-8 card-container-deployment">
							<NewDeployment deployed={false} />
							<DeploymentDetails />
						</div>
						<div className="col-4">
							<GeneralDetails />
						</div>
					</div>
				</div>
			</div>
		);
	}
}

export default Deployment;
