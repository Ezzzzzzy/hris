import React, { Component } from "react";
import { DatePicker, Select } from "../../../../../../../components";

class UpdateStatus extends Component {
	constructor(props) {
		super(props);

		this.state = {};
	}

	render() {
		return (
			<div
				className="modal fade"
				id="update-status-solo"
				role="dialog"
				aria-labelledby="exampleModalLabel"
				aria-hidden="true"
			>
				<div className="modal-dialog modal-dialog-centered" role="document">
					<form
						className="modal-content"
						action="submit"
						name="update-status-solo"
					>
						<div className="modal-header bg-primary white-text">
							<h5 className="modal-title">Update Status of Member</h5>
							<button
								type="button"
								className="close"
								data-dismiss="modal"
								aria-label="Close"
							>
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div className="modal-body flex-container flex-row">
							<div className="flex-1 bg-light light-container">
								<h6>Members to Update:</h6>
								<ul>
									<ul>
										<li className="margin-left-30">
											{this.props.memberModal
												? this.props.memberModal.name
												: ""}
										</li>
									</ul>
								</ul>
							</div>
							<div className="flex-1 margin-left-10">
								<div className="flex-1 margin-bottom-10">
									<div>
										New Status<span className="asterisk">*</span>
									</div>
									<Select
										options={this.props.selectStatus}
										value={"value"}
										display={"display"}
										optionValue={"value"}
										onChange={e => console.log(e.target.value)}
									/>
								</div>
								<div>
									<div>
										Start Date<span className="asterisk">*</span>
									</div>
									<DatePicker
										id={1}
										errors={[]}
										onChange={() => console.log("Changed Date Picker")}
									/>
								</div>
								<div className="flex-1 margin-top-10">
									<div>
										End Date<span className="asterisk">*</span>
									</div>
									<DatePicker
										id={1}
										errors={[]}
										onChange={() => console.log("Changed Date Picker")}
									/>
								</div>
							</div>
						</div>
						<div className="modal-footer">
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

export default UpdateStatus;
