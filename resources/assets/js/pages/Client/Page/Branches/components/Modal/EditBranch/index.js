import React, { Component } from "react";
import { Select, TextInput } from "../../../../../../../components";

const options = {
    regionOptions: [
        { name: 'NCR' },
        { name: 'Region I' }
    ],
    cityOptions: [
        { name: 'Quezon City' },
        { name: 'Manila' },
        { name: 'Dagupan' }
    ],
    locationOptions: [
        { name: 'Batasan' },
        { name: 'Malate' },
        { name: 'Burgos' },
        { name: 'Intramuros' }
    ]
};

class EditBranch extends Component {
    constructor(props) {
        super(props)
        this.state = {
            data: {
                index: this.props.data._viewIndex,
                branch_name: this.props.data.branch_name,
                location: this.props.data.location,
                city: this.props.data.city,
                region: this.props.data.region
            }
        }
    }

    handleChange(value, props) {
        let data = this.state.data;
        data[props] = value;
        this.setState({ data });
    }

    onSubmit() {
        this.props.editBranch(this.state.data);
        let modal = `#editBranch-${this.props.data._viewIndex}`;
        $(modal).modal('hide');
    }

    render() {
        return (
            <div className="column-slim">
                <i
                    data-toggle="modal"
                    className="fa fa-edit pointer"
                    data-target={`#editBranch-${this.state.data.index}`}
                />
                <div id={`editBranch-${this.state.data.index}`} className="modal fade" tabIndex="-1" role="dialog" >
                    <div className="modal-dialog  modal-dialog-centered" role="document">
                        <div className="modal-content">
                            <div className="modal-header modal-header-color">
                                <h5 className="modal-title">Edit Branch</h5>
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
                                <div className="row my-3">
                                    <div className="col-6">
                                        <TextInput
                                            id="branch_name"
                                            name="branch_name"
                                            label="Branch Name"
                                            onChange={(e) => this.handleChange(e.target.value, "branch_name")}
                                            value={this.state.data.branch_name}
                                            errors={this.state.errors}
                                        />
                                    </div>
                                    <div className="col-6">
                                        <Select
                                            id="region"
                                            label="Region"
                                            options={options.regionOptions}
                                            selectValue={this.state.data.region}
                                            optionValue="name"
                                            display="name"
                                            onChange={(e) => this.handleChange(e.target.value, "region")}
                                            errors={this.state.errors}
                                        />
                                    </div>
                                </div>
                                <div className="row my-3">
                                    <div className="col-6">
                                        <Select
                                            id="city"
                                            label="City"
                                            options={options.cityOptions}
                                            selectValue={this.state.data.city}
                                            optionValue="name"
                                            display="name"
                                            onChange={(e) => this.handleChange(e.target.value, "city")}
                                            errors={this.state.errors}
                                        />
                                    </div>
                                    <div className="col-6">
                                        <Select
                                            label="Location"
                                            options={options.locationOptions}
                                            selectValue={this.state.data.location}
                                            optionValue="name"
                                            display="name"
                                            onChange={(e) => this.handleChange(e.target.value, "location")}
                                            errors={this.state.errors}
                                        />
                                    </div>
                                </div>
                            </div>
                            <div className="modal-footer">
                                <button type="button" onClick={() => this.onSubmit()} className="btn btn-primary btn-success">Update Branch</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
};

export default EditBranch;
