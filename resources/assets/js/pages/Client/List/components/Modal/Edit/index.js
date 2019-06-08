import React from "react";

/**
 * Displays a Edit Modal
 *
 * @param object props
 * @param string companyname
 * @param string shortcode
 * @param function onClick
 * @param function onChange
 *
 */

const Edit = props => {
	return (
		<div
			className="modal fade"
			id="edit"
			tabIndex="-1"
			role="dialog"
			aria-labelledby="edit"
		>
			<div className="modal-dialog" role="document">
				<div className="modal-content">
					<div className="modal-header header-success">
						<p className="modal-title">Edit Client</p>
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
						<form className="modal-container">
							<div className="form-group">
								<label htmlFor="company-name" className="col-form-label">
									Company Name
								</label>
								<input
									type="text"
									className="form-control"
									id="company-name"
									value={props.companyname}
									onChange={props.onChange}
								/>
							</div>
							<div className="form-group">
								<label htmlFor="shortcode" className="col-form-label">
									Shortcode
								</label>
								<input
									type="text"
									className="form-control"
									id="shortcode"
									value={props.shortcode}
									onChange={props.onChange}
								/>
							</div>
						</form>
					</div>
					<div className="modal-footer cancel-save">
						<button
							type="button"
							className="btn btn-sm btn-success"
							data-dismiss="modal"
						>
							Cancel
						</button>
						<button
							type="button"
							className="btn btn-sm btn-success"
							data-dismiss="modal"
							onClick={() => console.log("clicked")}
						>
							Save
						</button>
					</div>
				</div>
			</div>
		</div>
	);
};

export default Edit;