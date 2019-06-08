import React from "react";

/**
 * Displays a View Modal
 *
 * @param object props
 * @param string companyname
 * @param string shortcode
 *
 */

const View = props => {
	return (
		<div
			className="modal fade"
			id="view"
			tabIndex="-1"
			role="dialog"
			aria-labelledby="view"
		>
			<div className="modal-dialog" role="document">
				<div className="modal-content">
					<div className="modal-header header-success">
						<p className="modal-title">View Client</p>
						<button
							type="button"
							className="close"
							data-dismiss="modal"
							aria-label="cancel"
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
									disabled="true"
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
									disabled="true"
								/>
							</div>
						</form>
					</div>
					<div className="modal-footer">
						<button
							type="button"
							className="btn btn-success btn-block"
							data-dismiss="modal"
						>
							Cancel
						</button>
					</div>
				</div>
			</div>
		</div>
	);
};

export default View;
