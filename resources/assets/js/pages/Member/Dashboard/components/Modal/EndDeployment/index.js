import React,{ Component } from 'react';
import { DatePicker, DatePickerInput } from 'rc-datepicker';
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

class EndDeployment extends Component {
    constructor(props) {
        super(props);
        this.state = {
        }
    }

    render() {
        return (
            <div>
                <button 
                    data-toggle="modal" 
                    data-target={ '#end' + this.state.index } 
                    className="modal-btn btn-background timeline-card-button pointer"
                >
                    <i className="fa fa-power-off"></i>
                    { ` End ` }
                </button>

                <div className="modal fade" id={ 'end'+this.state.index }>
                    <div className="modal-dialog end-work-modal">
                        <div className="modal-content">
                            <div className="modal-header modal-header-color modal-header-end-work">
                                <h4 className="modal-title">{` End Work ` }</h4>
                                    <button 
                                        type="button" 
                                        className="close" 
                                        data-dismiss="modal"
                                    >
                                        &times;
                                    </button>
                            </div>
                            <div className="modal-body">
                                <div className="col-12">
                                    <div className="end-date modal-row-margin">
                                        <Label 
                                            label='Date of End' 
                                            requiredfield={1} 
                                            className="label-modal-dashboard" 
                                        />
                                            
                                        <DatePickerInput
                                            displayFormat="MMMM DD, YYYY"
                                            className='my-custom-datepicker-component'
                                        />
                                    </div>
                                </div>
                                <div className="col-12">
                                    <div className="reason-for-leaving modal-row-margin">
                                        <Label 
                                            label='Reason for Leaving' 
                                            requiredfield={1} 
                                            className="label-modal-dashboard" 
                                        />
                                        <Select
                                            id='reason'
                                            className="form-control"
                                            requiredfield={1}
                                            optionValue='name'
                                            options={ reason }
                                            display='name'
                                            value='name'
                                            onChange={()=>console.log()}
                                        />
                                    </div>
                                </div>
                                <div className="col-12">
                                    <div className="remarks modal-row-margin">
                                        <Label 
                                            label='Remarks' 
                                            className="label-modal-dashboard" 
                                        />
                                        <textarea 
                                            className="form-control custm-height" 
                                            id="Remarks"
                                        >
                                        </textarea>
                                    </div>        
                                </div>
                                <div className="col-12">
                                    <div className="new-status modal-row-margin">
                                        <Label 
                                            label='New Status' 
                                            requiredfield={1} 
                                            className="label-modal-dashboard" 
                                        />
                                        <Select
                                            id='status'
                                            requiredfield={1}
                                            optionValue='name'
                                            options={ status }
                                            display='name'
                                            value='name'
                                            onChange={()=>console.log()}
                                        />
                                    </div>
                                </div>
                            </div>

                            <div className="modal-footer">
                                <div className="col-12">
                                    <button 
                                        type="button" 
                                        className="btn btn-success form-control" 
                                        data-dismiss="modal"
                                        onClick={ e=>this.endWork() }
                                    >   
                                        { ` Save ` }
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default EndDeployment;