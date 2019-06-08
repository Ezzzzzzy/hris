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

class AddBranch extends Component {
    constructor(props) {
        super(props)
        this.state = {
            data: {
                branch_name: "",
                location: "",
                city: "",
                region: ""
            },
            errors: []
        };
    }

    handleChange(value, props) {
        let data = this.state.data;
        data[props] = value;
        this.setState({ data });
    }

    onSubmit() {
        let data = this.state.data;
        this.props.addBranch(data);
        data.branch_name = "";
        data.location = "";
        data.region = "";
        data.city = "";
        this.setState({ data });
        $('#add-branch').modal('hide');
    }

    render() {
        return (
            <div>
                <button
                    id="newStuffModal"
                    className="btn btn-success btn-block"
                    data-toggle="modal"
                    data-target="#add-branch">
                    <i className="fa fa-plus" />{` New Branch`}
                </button>
                <div id="add-branch" className="modal fade" tabIndex="-1" role="dialog">
                    <div className="modal-dialog  modal-dialog-centered" role="document">
                        <div className="modal-content">
                            <div className="modal-header modal-header-color">
                                <h5 className="modal-title">Add New Branch</h5>
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
                                <div className="row  my-3">
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
                                            id="location"
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
                                <button type="button" onClick={() => this.onSubmit()} className="btn btn-primary btn-success"> Add Branch</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default AddBranch;
