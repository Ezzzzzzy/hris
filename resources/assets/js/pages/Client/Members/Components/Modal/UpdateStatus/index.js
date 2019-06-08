import React from "react";
import { DatePicker, Select } from "../../../../../../components";
import "./styles.css";

const UpdateStatus = () => {
	return (
		<div
			className="modal fade"
			id="updateStatusModal"
			role="dialog"
			aria-labelledby="exampleModalLabel"
			aria-hidden="true"
		>
			<div className="modal-dialog modal-dialog-centered" role="document">
				<form className="modal-content" action="submit">
					<div className="modal-header bg-primary">
						<h5 className="modal-title" id="exampleModalLabel">
							Update Status of Member
						</h5>
						<button
							type="button"
							className="close"
							data-dismiss="modal"
							aria-label="Close"
						>
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div className="modal-body row">
						<div className="col-xl-5 left">
							<h6>Members to Update:</h6>
							<ul>
								<li>some names</li>
								<li>some names</li>
								<li>some names</li>
								<li>some names</li>
							</ul>
						</div>
						<div className="col-xl-6 right">
							<div>
								<div>
									New Status<span>*</span>
								</div>
								<Select />
							</div>
							<div className="startDate">
								<div>
									Start Date<span>*</span>
								</div>
								<DatePicker id={1} errors={[]} />
							</div>
							<div>
								<div>
									End Date<span>*</span>
								</div>
								<DatePicker id={3} errors={[]} />
							</div>
						</div>
					</div>
					<div className="modal-footer">
						<button type="button" className="btn btn-success">
							Update
						</button>
					</div>
				</form>
			</div>
		</div>
	);
};

export default UpdateStatus;

{
	// <button
	// 	type="button"
	// 	className="btn btn-primary"
	// 	data-toggle="modal"
	// 	data-target="#updateStatusModal"
	// >
	// 	Launch Status Update Modal
	// </button>;
}
