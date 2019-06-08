import React, { Component } from "react";
import { Select, TextInput } from "../../../../../../../components";

const business_unit = [
    { name: "RG" },
    { name: "SG" },
    { name: "BG" }
];

class AddBrand extends Component {
    constructor(props) {
        super(props);

        this.state = {
            data: {
                brand: "",
                branches: 0,
                business_unit: "",
                members: 0,
                status: true,
                modified_date: "",
                modified_name: "Daryl Sinon"
            }
        };
    }

    onSubmit() {
        this.props.addBrand(this.state.data);
        let data = this.state.data;
        data.brand = "";
        data.business_unit = "";
        this.setState({ data });
        $("#add-business-unit").modal("hide");
    }

    handleChange(value, props) {
        let data = this.state.data;
        data[props] = value;
        this.setState({ data });
    }

    render() {
        return (
            <div>
                <button
                    className="btn btn-success btn-block"
                    data-toggle="modal"
                    data-target="#AddBrand"
                >
                    <span className="fa fa-plus" />
                    {` New Brand`}
                </button>

                <div
                    className="modal fade"
                    id="AddBrand"
                    tabIndex="-1"
                    role="dialog"
                    aria-labelledby="AddBrand"
                    aria-hidden="true"
                >
                    <div className="modal-dialog modal-dialog-centered" role="document">
                        <div className="modal-content custom-modal-width">
                            <div className="modal-header modal-header-color">
                                <h5 className="modal-title" id="AddBrand">
                                    Add New Brand
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
                            <div className="modal-body">
                                <div className="modal-container">
                                    <div className="form-group">
                                        <TextInput
                                            label={"Brand Name"}
                                            name="brand"
                                            value={this.state.data.brand}
                                            onChange={(e) => this.handleChange(e.target.value, "brand")}
                                        />
                                    </div>
                                    <div className="form-group mt-3">
                                        <Select
                                            id={"id"}
                                            label={"Business Unit"}
                                            optionValue={"name"}
                                            options={business_unit}
                                            display={"name"}
                                            selectValue={this.state.data.business_unit}
                                            onChange={(e) => this.handleChange(e.target.value, "business_unit")}
                                        />
                                    </div>
                                </div>
                            </div>
                            <div className="modal-footer">
                                <button
                                    type="button"
                                    className="btn btn-primary btn-success"
                                    data-dismiss="modal"
                                    onClick={() => this.onSubmit()}
                                >
                                    Add New Brand
								</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default AddBrand;
