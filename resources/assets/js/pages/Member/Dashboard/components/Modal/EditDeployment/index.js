import React, { Component } from 'react';
import { DatePicker } from 'rc-datepicker';
import {
    TextBox,
    Select,
    Label,
} from '../../../../../../components';
import StatusHistory from './StatusHistory';

const client = [
    { id: 1, name: 'SK' },
    { id: 2, name: 'WK' },
    { id: 3, name: 'BTBRS' },
    { id: 4, name: 'PG' },
    { id: 5, name: 'JFC' }
];
const branch = [
    { id: 1, name: 'Laguna' },
    { id: 2, name: 'Pasig' },
    { id: 3, name: 'Ortigas' },
    { id: 4, name: 'SanJuan' },
    { id: 5, name: 'Megamall LG, Pasig City' },
    { id: 6, name: 'Megamall GF, Pasig City' }
];
const brand = [
    { id: 1, name: 'Lenovo' },
    { id: 2, name: 'Acer' },
    { id: 3, name: 'Omega' },
    { id: 4, name: 'Alpha' },
    { id: 5, name: 'Chowking' },
    { id: 6, name: 'Jollibee' }
];
const position = [
    { id: 1, name: 'Staff' },
    { id: 2, name: 'Secretary' },
    { id: 3, name: 'Gradener' },
    { id: 4, name: 'Officer' },
    { id: 5, name: 'Sales Clerk' },
    { id: 6, name: 'Janitor' }
];
const status = [
    { id: 1, name: 'Pool' },
    { id: 2, name: 'Floating' },
    { id: 3, name: 'Endorsed' },
    { id: 4, name: 'Qualified' },
    { id: 5, name: 'Not Qualified' },
    { id: 6, name: 'Backed-out' },
    { id: 7, name: 'Training' },
    { id: 8, name: 'Probationary' },
    { id: 9, name: 'Seasonal' },
    { id: 10, name: 'Regular' },
    { id: 11, name: 'Event' },
    { id: 12, name: 'Weekender' },
    { id: 13, name: 'Part-timer' },
];

class EditDeployment extends Component {
    constructor(props) {
        super(props);
        this.state = {
        };
    }

    render() {
        return (
            <div>
                <button
                    data-toggle="modal"
                    data-target={'#edit' + this.state.index}
                    className="modal-btn btn-background timeline-card-button pointer edit-btn"
                >
                    <i className="fa fa-edit"></i>
                    <span className="pointer"> {` Edit `} </span>
                </button>

                <div className="modal fade" id={'edit' + this.state.index}>
                    <div className="modal-dialog edit-deployment-modal">
                        <div className="modal-content height">
                            <div className="modal-header modal-header-color">
                                <h4 className="modal-title">{` Edit Deployment `}</h4>
                                <button
                                    type="button"
                                    className="close"
                                    data-dismiss="modal"
                                >
                                    &times;
                                </button>
                            </div>
                            <div className="modal-body">
                                <div className="row">
                                    <div className="col-6">
                                        <Label
                                            label='Client'
                                            requiredfield={1}
                                            className="label-modal-dashboard"
                                        />
                                        <Select
                                            id='id'
                                            options={client}
                                            optionValue='name'
                                            display='name'
                                            selectValue={'name'}
                                            onChange={() => console.log()}
                                        />
                                    </div>
                                    <div className="col-6">
                                        <Label
                                            label='Branch'
                                            requiredfield={1}
                                            className="label-modal-dashboard"
                                        />
                                        <Select
                                            id='id'
                                            options={branch}
                                            optionValue='name'
                                            display='name'
                                            selectValue={'name'}
                                            onChange={() => console.log()}
                                        />
                                    </div>
                                </div>
                                <div className="row">
                                    <div className="col-6 mt-2">
                                        <Label
                                            label='Brand'
                                            requiredfield={1}
                                            className="label-modal-dashboard"
                                        />
                                        <Select
                                            id='id'
                                            options={brand}
                                            optionValue='name'
                                            display='name'
                                            selectValue={'name'}
                                            onChange={() => console.log()}
                                        />
                                    </div>
                                    <div className="col-6 mt-2">
                                        <Label
                                            label='Position'
                                            requiredfield={1}
                                            className="label-modal-dashboard"
                                        />
                                        <Select
                                            id='id'
                                            options={position}
                                            optionValue='name'
                                            display='name'
                                            selectValue={'name'}
                                            onChange={() => console.log()}
                                        />
                                    </div>
                                </div>
                                <hr />
                                <div className="row">
                                    <div className="status-history-text">
                                        <Label label='Status History' />
                                    </div>
                                    <div className="status-history" >
                                        <StatusHistory />
                                    </div>
                                </div>
                                <div align="right">
                                    <button
                                        type="button"
                                        className="btn btn-primary add-status-history"
                                    >
                                        <i className="fa fa-plus fa-fw"></i>
                                        {` Add New`}
                                    </button>
                                </div>
                            </div>
                            <div className="modal-footer">
                                <button
                                    onClick={() => this.editDeployment()}
                                    type="button"
                                    className="btn btn-success"
                                    data-dismiss="modal"
                                >
                                    {` Update`}
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