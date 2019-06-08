import React, { Component } from 'react';
import {
	EditDeployment,
	DisciplinaryAction,
	EndDeployment
} from '../Modal';
import '../../style.css';

const DisciplinaryActionEntry = () => {
	return (
		<div className="row da-card">
			<div className="col-4 da-date"> 3/20/18 </div>
			<div className="col-2 da-status icon-red">
				<i className="fa fa-spinner fa-spin"> </i>
			</div>
			<div className="col-6 da-name"> Molis Cras</div>
		</div>
	);
}

const StatusHistory = () => {
	return (
		<div className="row job-history-container">
			<div className="col-8 job-history-name">Dec 20, 2017 - Mar 20, 2018 </div>
			<div className="col-4 job-history-status">
				<span className="badge-blue"> PROBATIONARY </span>
			</div>
		</div>
	);
}

class DeploymentDetails extends React.Component {
	constructor(props) {
		super(props);
	}
	render() {

		return (
			<div className="row">
				<div className="col-12">
					<div className="row justify-content-end">
						<div className="col-3">
							<div className="row pull-right">
								<span className="client-name-deployment">
									{`JFC`}
									<br />
								</span>
							</div>
							<div className="row pull-right">
								<small className="client-name client-full-name-deployment">
									{`Jollibee Food Coorporation`}
									<br />
								</small>
							</div>
						</div>
						<div className="col-1">
							<span className="green-circle-deployment"></span>
							<span className="green-circle-deployment timeline-deployment-adjustment"></span>
						</div>
						<div className="col-8 cards-panel">
							<div className="col-12 card card-deployment timeline-deployment">
								<div className="row card-upper-deployment">
									<div className="col-6 panel-left">
										<div className="row">
											<label className="col-12 job-position">
												Intern
			    							</label>
											<label className="col-12 job-location">
												Ortigas - Greenhills
			    							</label>
											<label className="col-12 job-company">
												BotBros AI
			    							</label>
											<div className="nbsp-substitute-position"></div>
											<label className="col-12 job-salary">
												Php 15,000 / mo.
				    						</label>
											<label className="col-12 job-da">
												<span className="label-red">1 Pending DA</span> - 2 Resolved DA
				    						</label>
										</div>
									</div>
									<div className="col-6 panel-right">
										<div className="row">
											<label className="col-12 job-date">
												Dec 20, 2018 - Present
			    							</label>
											<label className="col-12 job-date-month">
												5 months
			    							</label>
											<label className="col-12 job-position">
												<div className="nbsp-substitute-button"></div>
											</label>
											<label className="col-12 job-date-month">
												<div className="nbsp-substitute-button"></div>
											</label>
											<div className="col-12">
												<div className="row">
													<div className="row col-12 btn-container-deployment pull-right">
														<div className="custm-btn-adjust-position row">
															<EndDeployment />
															<EditDeployment />
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div className="row card-lower-deployment">
									<div className="col-6" id="panel-left-lower-deployment">
										{StatusHistory()}
									</div>
									<div className="col-6 panel-right-lower-deployment">
										<div className="row da-header-container">
											<div className="col-8 da-header">Disiplinary Action</div>
											<div className="col-4 da-header-link">
												<DisciplinaryAction />
											</div>
										</div>
										{DisciplinaryActionEntry()}
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		)
	}
}
export default DeploymentDetails;
