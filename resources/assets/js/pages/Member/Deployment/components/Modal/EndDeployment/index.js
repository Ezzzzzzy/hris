import React, { Component } from 'react';
import { DatePicker } from '../../../../../../components';
import {
    TextBox,
    Select,
    Label
} from '../../../../../../components';

const reason = [
    { id: 1, name: 'Terminated' },
    { id: 2, name: 'Resigned - Work Load' },
    { id: 3, name: 'Resigned - Work-Life Balance' },
    { id: 4, name: 'Resigned - Work Environment/Culture' },
    { id: 5, name: 'Resigned - Co-Workers' },
    { id: 6, name: 'Resigned - Immediate Superior' },
    { id: 7, name: 'Resigned - Health Reasons' },
    { id: 8, name: 'Resigned - Career Growth' },
    { id: 9, name: 'Resigned - Work Abroad' },
    { id: 10, name: 'Resigned - Personal Reasons' },
    { id: 11, name: 'AWOL' },
    { id: 12, name: 'End of Service' },
    { id: 13, name: 'End of Project' },
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

class EndWork extends Component {

    getCurrentDate() {
        let jsDate = new Date();
        return (jsDate);
    }

    constructor(props) {
        super(props);
        this.state = {
            end_work: {
                date_start: "October 28, 2016",
                reason: '',
                remarks: '',
                status: '',
                date_end: ''
            },
        };
    }

    endWorkChange(val, propName) {
        let end_work = this.state.end_work
        end_work[propName] = val
        this.setState({ end_work })
    }

    render() {
        return (
            <div>
                <button
                    data-toggle="modal"
                    data-target={`#end${this.state.index}`}
                    className="modal-btn-deployment"
                >
                    <i className="fa fa-power-off"></i>
                    End
                </button>
                <div
                    className="modal fade"
                    id={`end${this.state.index}`}
                >
                    <div className="modal-dialog custm-modal-end-width-deployment">
                        <div className="modal-content">
                            <div className="modal-header modal-header-color-deployment">
                                <h4 className="modal-title modal-title-deployment">
                                    {`End Work`}
                                </h4>
                                <button type="button" className="close-deployment" data-dismiss="modal">
                                    &times;
                                </button>
                            </div>
                            <div className="modal-body modal-body-deployment">
                                <Label
                                    label='Date Of End'
                                    requiredfield={1}
                                    className="custm-card-labels"
                                />
                                <DatePicker
                                    id={"date_end"}
                                    errors={[]}
                                    onChange={e => { this.endWorkChange(e, 'date_end') }}
                                />
                                <div className="mt-2 custm-card-labels">
                                    <Select
                                        label={'Reason for Leaving'}
                                        id='reason'
                                        className="form-control"
                                        requiredfield={1}
                                        optionValue='name'
                                        options={reason}
                                        display='name'
                                        onChange={e => this.endWorkChange(e.target.value, 'reason')}
                                    />
                                </div>
                                <div className='mt-2'>
                                    <Label
                                        label='Remarks'
                                        className="custm-card-labels"
                                    />
                                    <textarea
                                        className="form-control custm-height-deployment"
                                        id="Remarks"
                                        onChange={e => this.endWorkChange(e.target.value, 'remarks')}
                                    >
                                    </textarea>
                                </div>
                                <div className='mt-2 custm-card-labels'>
                                    <Select
                                        label={'New Status'}
                                        id='status'
                                        className="form-control"
                                        requiredfield={1}
                                        optionValue='name'
                                        options={status}
                                        display='name'
                                        onChange={e => this.endWorkChange(e.target.value, 'status')}
                                    />
                                </div>
                            </div>
                            <div className="modal-footer modal-footer-deployment">
                                <button
                                    type="button"
                                    className="btn btn-success form-control"
                                    data-dismiss="modal"
                                >
                                    {`Save`}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default EndWork;
