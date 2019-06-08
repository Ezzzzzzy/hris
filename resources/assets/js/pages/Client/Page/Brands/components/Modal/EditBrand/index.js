import React, { Component } from "react";
import { Select, TextInput } from "../../../../../../../components";

const business_unit = [
    { name: "RG" },
    { name: "SG" },
    { name: "BG" }
];

class EditBrand extends Component {
    constructor(props) {
        super(props);

        this.state = {
            data: {
                brand: props.data.brand,
                branches: props.data.branches,
                business_unit: props.data.business_unit,
                members: props.data.members,
                status: props.data.status,
                modified_date: props.data.modified_date,
                modified_name: props.data.modified_name
            },
            index: props.index
        };
    }

    handleChange(value, props) {
        let data = this.state.data;
        data[props] = value;
        this.setState({ data });
    }

    onSubmit() {
        this.props.editBrand(this.state.data, this.state.index);
        let modal = `#edit-${this.props.data.id}`;
        $(modal).modal('hide');
    }

    render() {
        return (
            <div className="column-slim">
                <button
                    className="fa fa-edit pointer"
                    data-toggle="modal"
                    data-target={`#EditBrand-${this.state.index}`}
                >
                    <span className="fa fa-edit" />
                </button>

                <div
                    className="modal fade"
                    id={`EditBrand-${this.state.index}`}
                    tabIndex="-1"
                    role="dialog"
                    aria-labelledby="AddBrand"
                    aria-hidden="true"
                >
                    <div className="modal-dialog modal-dialog-centered" role="document">
                        <div className="modal-content custom-modal-width">
                            <div className="modal-header modal-header-color">
                                <h5 className="modal-title" id="AddBrand">
                                    Edit Brand
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
                                <form className="modal-container">
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
                                </form>
                            </div>
                            <div className="modal-footer">
                                <button
                                    type="button"
                                    className="btn btn-primary btn-success"
                                    data-dismiss="modal"
                                    onClick={() => this.onSubmit()}
                                >
                                    Update Brand
								</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default EditBrand;
