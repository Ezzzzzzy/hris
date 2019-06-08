import React from "react";

const currentDatum = {
	name: "Christopher Lim",
	memberId: "123123123",
	oldId: "321321321",
	gender: "Male",
	birthday: "July 24, 2018",
	addressOne: "1144 Some Street",
	addressTwo: "Province, City",
	mobile: "099612345",
	email: "chrisispogi@yahoo.com",
	status: "Handsome",
	hireDate: "09/23/2019",
	position: "CEO",
	brand: "BotBros",
	branch: "San Juan",
	disciplinaryAction: [
		{
			date: "12/21/2112",
			status: "Punished",
			action: "Slept"
		},
		{
			date: "09/31/2012",
			status: "Kicked",
			action: "Tamad"
		}
	]
};

const QuickViewMember = props => {
	return (
		<div
			id="quick-view-member"
			className="modal fade"
			tabIndex="-1"
			role="dialog"
		>
			<div className="modal-dialog modal-dialog-centered" role="document">
				<div className="modal-content">
					<div className="modal-header bg-primary white-text">
						<h5 className="modal-title">{currentDatum.name}</h5>
						<button
							type="button"
							className="close"
							data-dismiss="modal"
							aria-label="Close"
						>
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div className="modal-body">
						<div className="flex-container flex-column">
							<div className="flex-container flex-column margin-horizontal-20">
								<div className="flex-container flex-row">
									<div className="flex-1">Member ID</div>
									<div className="flex-2 bolder">{currentDatum.memberId}</div>
								</div>
								<div className="flex-container flex-row">
									<div className="flex-1">Old ID</div>
									<div className="flex-2 bolder">{currentDatum.oldId}</div>
								</div>
								<div className="flex-container flex-row">
									<div className="flex-1">Gender</div>
									<div className="flex-2 bolder">{currentDatum.gender}</div>
								</div>
								<div className="flex-container flex-row">
									<div className="flex-1">Birthday</div>
									<div className="flex-2 bolder">{currentDatum.birthday}</div>
								</div>
								<div className="flex-container flex-row">
									<div className="flex-1">Address</div>
									<div className="flex-container flex-column flex-2 bolder">
										<div>{currentDatum.addressOne}</div>
										<div>{currentDatum.addressTwo}</div>
									</div>
								</div>
								<div className="flex-container flex-row">
									<div className="flex-1">Mobile</div>
									<div className="flex-2 bolder">{currentDatum.mobile}</div>
								</div>
								<div className="flex-container flex-row">
									<div className="flex-1">Email</div>
									<div className="flex-2 bolder">{currentDatum.email}</div>
								</div>
								<div className="flex-container flex-row">
									<div className="flex-1">Status</div>
									<div className="flex-2 bolder">{currentDatum.status}</div>
								</div>
							</div>
							<div className="flex-container flex-column light-container bg-light padding-20 margin-top-20 margin-horizontal">
								<div>Company Details</div>
								<div className="flex-container flex-row">
									<div className="flex-1">Hire Date</div>
									<div className="flex-2 bolder">{currentDatum.hireDate}</div>
								</div>
								<div className="flex-container flex-row">
									<div className="flex-1">Position</div>
									<div className="flex-2 bolder">{currentDatum.position}</div>
								</div>
								<div className="flex-container flex-row">
									<div className="flex-1">Brand</div>
									<div className="flex-2 bolder">{currentDatum.brand}</div>
								</div>
								<div className="flex-container flex-row">
									<div className="flex-1">Branch</div>
									<div className="flex-2 bolder">{currentDatum.branch}</div>
								</div>
							</div>
							<div className="flex-container flex-column light-container bg-light padding-20 margin-top-20 margin-horizontal">
								<div>Disciplinary Action</div>
								{currentDatum.disciplinaryAction
									? currentDatum.disciplinaryAction.map((action, i) => {
											return (
												<div key={i} className="flex-container flex-row">
													<div className="flex-2">{action.date}</div>
													<div className="flex-1  bolder">{action.status}</div>
													<div className="flex-2">{action.done}</div>
												</div>
											);
									  })
									: null}
							</div>
						</div>
					</div>
					<div className="modal-footer margin-horizontal">
						<button
							type="button"
							className="btn btn-success btn-block"
							data-dismiss="modal"
						>
							View Full Profile
						</button>
					</div>
				</div>
			</div>
		</div>
	);
};

export default QuickViewMember;
