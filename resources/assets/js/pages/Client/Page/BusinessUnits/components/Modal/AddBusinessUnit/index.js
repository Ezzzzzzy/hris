import React, { Component } from "react";
import { TextInput } from "../../../../../../../components";

class AddBusinessUnit extends Component {
	constructor(props) {
		super(props);
		this.state = {
			data: {
				business_unit_name: "",
				code: ""
			},
			errors: [],
			errorMsg: {
				business_unit_name: "",
				code: ""
			}
		};
	}

	handleInputChange(e) {
		let data = this.state.data;
		let prop = e.target.name;
		let val = e.target.value;
		data[prop] = val;
		this.setState({ data });
	}

	formValidation() {
		let data = this.state.data;
		let errors = this.state.errors;
		let errorMsg = this.state.errorMsg;
		let isValid = true;
		let requiredFields = ["business_unit_name", "code"];
		let format = /^[a-zA-Z0-9- ,.]*$/;
		for (let x = 0; x < requiredFields.length; x++) {
			let value = data[requiredFields[x]];
			if (value.replace(/\s/g, "") === "" || !format.test(value)) {
				if (value.replace(/\s/g, "") === "")
					errorMsg[requiredFields[x]] = "This field is required.";
				if (!format.test(value))
					errorMsg[requiredFields[x]] =
						"This field should not contain any special characters.";
				if (!errors.includes(requiredFields[x])) errors.push(requiredFields[x]);
				isValid = false;
			} else if (errors.includes(requiredFields[x])) {
				let index = errors.indexOf(requiredFields[x]);
				index > -1 && errors.splice(index, 1);
				errorMsg[requiredFields[x]] = "";
			}
		}
		this.setState({ errors, errorMsg });
		return isValid;
	}

	onSubmit(e) {
		e.preventDefault();
		if (this.formValidation()) {
			this.props.addBusinessUnit(this.state.data);
			let data = this.state.data;
			data.business_unit_name = "";
			data.code = "";
			this.setState({ data });
			$("#add-business-unit").modal("hide");
		}
	}

	render() {
		return (
			<div>
				<button
					className="btn btn-success btn-block"
					data-toggle="modal"
					data-target="#add-business-unit"
				>
					<i className="fa fa-plus" /> New Business Unit
				</button>
				<div
					className="modal fade"
					id="add-business-unit"
					tabIndex="-1"
					role="dialog"
					aria-labelledby="AddBrand"
					aria-hidden="true"
				>
					<div className="modal-dialog modal-dialog-centered" role="document">
						<div className="modal-content">
							<form onSubmit={e => this.onSubmit(e)}>
								<div className="modal-header modal-header-color">
									<h5 className="modal-title" id="AddBrand">
										Add New Business Unit
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
								<div className="modal-body my-3">
									<div className="row">
										<div className="col">
											<TextInput
												label="Business Unit Name"
												id="business_unit_name"
												name="business_unit_name"
												value={this.state.data.business_unit_name}
												onChange={e => this.handleInputChange(e)}
												errors={this.state.errors}
											/>
											<span className="text-danger">
												{this.state.errorMsg.business_unit_name}
											</span>
										</div>
									</div>
									<div className="row mt-3">
										<div className="col">
											<TextInput
												label="Short Code"
												id="code"
												name="code"
												value={this.state.data.code}
												onChange={e => this.handleInputChange(e)}
												errors={this.state.errors}
											/>
											<span className="text-danger">
												{this.state.errorMsg.code}
											</span>
										</div>
									</div>
								</div>
								<div className="modal-footer">
									<button type="submit" className="btn btn-primary btn-success">
										Add Business Unit
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		);
	}
}

export default AddBusinessUnit;
