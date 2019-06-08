import React, { Component } from "react";
import { TextInput } from "../../../../../../components";

class AddBrands extends Component {
	constructor(props) {
		super(props);

		this.state = {
			data: {
				brandName: ""
			}
		};
	}

	onChange(e) {
		var data = Object.assign(this.state.data, {});
		data[e.target.name] = e.target.value;
		this.setState({ data });
	}

	clear() {
		var data = Object.assign(this.state.data, {});
		data["brandName"] = "";
		this.setState({ data });
	}

	render() {
		$("#add-brands").on("hidden.bs.modal", e => {
			this.clear();
		});
		return (
			<div id="add-brands" className="modal fade" tabIndex="-1" role="dialog">
				<div className="modal-dialog modal-dialog-centered" role="document">
					<div className="modal-content">
						<div className="modal-header bg-primary text-white">
							<h5 className="modal-title">Add Brands</h5>
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
									label="Brand Name:"
									placeholder="Enter a Brand Name"
									name="brandName"
									value={this.state.data.brandName}
									onChange={this.onChange.bind(this)}
								/>
							</div>
							<div className="margin-top-10">
								<label>Business Unit: </label>
								<select className="form-control" disabled>
									<option>{this.props.currentUnit}</option>
								</select>
							</div>
						</div>
						<div className="modal-footer">
							<button
								type="button"
								className="btn btn-success"
								data-dismiss="modal"
								onClick={() => this.props.addBrand(this.state.data.brandName)}
							>
								Add Brand
							</button>
						</div>
					</div>
				</div>
			</div>
		);
	}
}

export default AddBrands;
