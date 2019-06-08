import React, { Component } from "react";
import { TextInput } from "../../../../../../components";

class AddBusinessUnits extends Component {
	constructor(props) {
		super(props);

		this.state = {
			data: {
				unitName: "",
				shortcode: ""
			}
		};
	}

	onChange(e) {
		var data = this.state.data;
		data[e.target.name] = e.target.value;
		this.setState({ data });
	}
	clear() {
		var data = Object.assign(this.state.data, {});
		data["unitName"] = "";
		data["shortcode"] = "";
		this.setState({ data });
	}

	render() {
		$("#add-business-units").on("hidden.bs.modal", e => {
			this.clear();
		});
		return (
			<div
				id="add-business-units"
				className="modal fade"
				tabIndex="-1"
				role="dialog"
			>
				<div className="modal-dialog modal-dialog-centered" role="document">
					<div className="modal-content">
						<div className="modal-header bg-primary text-white">
							<h5 className="modal-title">Add Business Units</h5>
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
							<div>
								<TextInput
									label="Business Unit Name:"
									placeholder="Enter a Business Unit Name"
									name="unitName"
									value={this.state.data.unitName}
									onChange={this.onChange.bind(this)}
								/>
							</div>
							<div className="margin-top-10">
								<TextInput
									label="Shortcode:"
									placeholder="Enter a Shortcode"
									name="shortcode"
									value={this.state.data.shortcode}
									onChange={this.onChange.bind(this)}
								/>
							</div>
						</div>
						<div className="modal-footer">
							<button
								type="button"
								className="btn btn-success"
								data-dismiss="modal"
								onClick={() =>
									this.props.addBusinessUnit(
										this.state.data.unitName,
										this.state.data.shortcode
									)
								}
							>
								Add Business Unit
							</button>
						</div>
					</div>
				</div>
			</div>
		);
	}
}

export default AddBusinessUnits;
