import React, { Component } from "react";
import { Select, DatePicker } from "../../../../../../../components";

class ReassignMember extends Component {
	constructor(props) {
		super(props);

		this.state = {};
	}

	render() {
		return (
			<div
				className="modal fade"
				id="reassign-member-solo"
				role="dialog"
				aria-labelledby="reassign-member-title"
				aria-hidden="true"
			>
				<div className="modal-dialog  modal-dialog-centered" role="document">
					<form className="modal-content stretch">
						<div className="modal-header bg-primary white-text">
							<h5 className="modal-title">Reassign Member</h5>
							<button
								type="button"
								className="close"
								data-dismiss="modal"
								aria-label="Close"
							>
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div className="modal-body flex-container flex-column">
							<div className="flex-container flex-row">
								<div className="flex-1 bg-light light-container">
									<h6>Members to Reassign:</h6>
									<ul>
										<li className="margin-left-30">
											{this.props.memberModal
												? this.props.memberModal.name
												: ""}
										</li>
									</ul>
								</div>
								<div className="flex-container flex-column flex-1 margin-left-10">
									<div className="flex-1 margin-bottom-10">
										<div>
											Date of End<span className="asterisk">*</span>
										</div>
										<DatePicker
											className="modal-flex-input"
											id={1}
											errors={[]}
											onChange={() => console.log("Changed Date Picker")}
										/>
									</div>
									<div className="flex-1 margin-bottom-10">
										<div className="margin-bottom">
											Reason for Leaving<span className="asterisk">*</span>
										</div>
										<Select
											options={this.props.selectReasonForLeaving}
											display={"display"}
											value={"value"}
											optionValue={"value"}
											className="modal-flex-input"
											onChange={e => console.log(e.target.value)}
										/>
									</div>
									<div className="flex-1 margin-top-10">
										<div>
											Remarks<span className="asterisk">*</span>
										</div>
										<textarea
											name="remarks"
											id="remarks"
											cols="22"
											rows="2"
											className="form-control resize-none"
										/>
									</div>
								</div>
							</div>
							<div>
								<hr />
							</div>
							<div className="flex-container flex-column">
								<div className="flex-container flex-row">
									<div className="flex-1">
										<div>
											Client<span className="asterisk">*</span>
										</div>
										<Select
											options={this.props.selectClients}
											display={"display"}
											optionValue={"value"}
											value={"value"}
											onChange={e => console.log(e.target.value)}
										/>
									</div>
									<div className="flex-1 margin-left-10">
										<div>
											Branch<span className="asterisk">*</span>
										</div>
										<Select
											options={this.props.selectBranches}
											display={"display"}
											optionValue={"value"}
											value={"value"}
											onChange={e => console.log(e.target.value)}
										/>
									</div>
								</div>
								<div className="flex-container flex-row  margin-top-10">
									<div className="flex-1">
										<div>
											Brand<span className="asterisk">*</span>
										</div>
										<Select
											options={this.props.selectBrands}
											display={"display"}
											optionValue={"value"}
											value={"value"}
											onChange={e => console.log(e.target.value)}
										/>
									</div>
									<div className="flex-1 margin-left-10">
										<div>
											New Position<span className="asterisk">*</span>
										</div>
										<Select
											options={this.props.selectPositions}
											display={"display"}
											optionValue={"value"}
											value={"value"}
											onChange={e => console.log(e.target.value)}
										/>
									</div>
								</div>
							</div>
							<div className="flex-container flex-row margin-top-10">
								<div className="flex-1">
									<div>
										Start Date<span className="asterisk">*</span>
									</div>
									<DatePicker id={1} errors={[]} />
								</div>
								<div className="flex-1 margin-left-5">
									<div>
										End Date<span className="asterisk">*</span>
									</div>
									<DatePicker
										id={1}
										errors={[]}
										onChange={() => console.log("Changed Date Picker")}
									/>
								</div>
								<div className="flex-1 margin-left-5">
									<div>
										New Status<span className="asterisk">*</span>
									</div>
									<Select
										options={this.props.selectStatus}
										display={"display"}
										value={"value"}
										optionValue={"value"}
										onChange={e => console.log(e.target.value)}
									/>
								</div>
							</div>
						</div>
						<div className="modal-footer modal-flex-footer">
							<button
								type="button"
								className="btn btn-success"
								data-dismiss="modal"
							>
								Update
							</button>
						</div>
					</form>
				</div>
			</div>
		);
	}
}

export default ReassignMember;
