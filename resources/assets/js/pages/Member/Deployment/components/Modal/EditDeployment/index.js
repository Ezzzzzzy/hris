import React, { Component } from 'react';
import {
    Select,
    Label,
    DatePicker
} from '../../../../../../components';
import '../../../style.css';

const position = [
    { id: '1', position: 'Supervisor' },
    { id: '2', position: 'Branch Manager' },
    { id: '3', position: 'Sales Clerk' },
    { id: '4', position: 'For Sale' },

]
const client = [
    { id: '1', client: 'Jollibee Food Corp' },
    { id: '2', client: 'Primer Group of Companies' },
    { id: '3', client: 'Ayala Malls' },
    { id: '4', client: 'San Miguel Food Corp' },

]
const brand = [
    { id: '1', brand: 'Chowking' },
    { id: '2', brand: 'Magnolia' },
    { id: '3', brand: 'FitFlop' },
    { id: '4', brand: 'Ayala Malls The 30th' },
]
const branch = [
    { id: '1', branch: 'Megamall GF, Pasig City' },
    { id: '2', branch: 'Continental Court Condo GF, San Juan City' },
    { id: '3', branch: 'SM Makati, Makati City' },
    { id: '4', branch: '30 Meralco Ave, Pasig City' },
]
const new_status = [
    { id: '1', new_status: 'REGULAR' },
    { id: '2', new_status: 'SEASONAL' },
    { id: '3', new_status: 'PROBATIONARY' },
    { id: '4', new_status: 'WEEKENDER' },
]

const NewStatus = (props) => {
    return (
        <div className="row new-status-row-deployment">
            <div className="col-4 pb-2 custm-card-labels">
                <Label label='Start Date' requiredfield="true" />
                <DatePicker
                    id='start_date'
                    requiredfield="true"
                    name="start_date"
                    errors={[]}
                    onChange={() => { }}

                />
            </div>
            <div className="col-4 pb-2 custm-card-labels">
                <Label label='End Date' requiredfield="true" />
                <DatePicker
                    id='end_date'
                    requiredfield="true"
                    name="end_date"
                    errors={[]}
                    onChange={() => { }}
                />
            </div>
            <div className="col-3 pb-2 custm-card-labels">
                <Select
                    name='add_new_status'
                    id='add_new_status'
                    label={'New Status'}
                    display='new_status'
                    options={new_status}
                    requiredfield="true"
                />
            </div>
            <div className="col-1 pb-2 custm-card-labels">
                <button className="remove-btn-deployment">
                    X
                </button>
            </div>
        </div>
    );
}

class EditDeployment extends Component {
    state = {
        edit: {
            position: "",
            brand: "",
            branch: "",
            client: "",
            new_status: "",
            status_list: "",
            date_start: "",
            date_end: "",
        },
    }

    render() {
        return (
            <div>
                <button
                    data-toggle="modal"
                    data-target={`#edit${this.props.indexInArray}`}
                    className="modal-btn-deployment"
                >
                    <i className="fas fa-edit fa-fw"></i>
                    {`Edit`}
                </button>
                <div className="modal fade"
                    id={`edit${this.props.indexInArray}`}
                >
                    <div className="modal-dialog modal-dialog-deployment-end custm-modal-edit-width-deployment">
                        <div className="modal-content">
                            <div className="modal-header modal-header-color-deployment">
                                <h4 className="modal-title">
                                    {`Edit Deployment`}
                                </h4>
                                <button type="button" className="close-deployment" data-dismiss="modal">
                                    &times;
                                    </button>
                            </div>
                            <div className="modal-body">
                                <div className="row">
                                    <div className="col-6 custm-card-labels">
                                        <Select
                                            label={'Client'}
                                            requiredfield={1}
                                            display='client'
                                            options={client}
                                        />
                                    </div>
                                    <div className="col-6 custm-card-labels">
                                        <Select
                                            label={'Branch'}
                                            requiredfield={1}
                                            display='branch'
                                            options={branch}
                                        />
                                    </div>
                                </div>
                                <div className="row">
                                    <div className="col-6 mt-2 custm-card-labels">
                                        <Select
                                            label={'Brand'}
                                            requiredfield={1}
                                            display='brand'
                                            options={brand}
                                        />
                                    </div>
                                    <div className="col-6 mt-2 custm-card-labels">
                                        <Select
                                            label={'New Position'}
                                            requiredfield={1}
                                            display='position'
                                            options={position}
                                        />
                                    </div>
                                </div>
                                <hr />
                                <div className="status-history-deployment">
                                    <Label label='Status History' />
                                </div>
                                <div>
                                    {NewStatus()}
                                </div>
                                <div align="right">
                                    <button
                                        type="button"
                                        className="btn btn-primary"
                                    >
                                        <i className="fas fa-plus fa-fw custm-btn-icons custm-btn-names"></i>
                                        {` Add New`}
                                    </button>
                                </div>
                            </div>
                            <div className="modal-footer">
                                <button
                                    type="button"
                                    className="btn btn-success"
                                    data-dismiss="modal"
                                >
                                    {`Update`}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default EditDeployment;