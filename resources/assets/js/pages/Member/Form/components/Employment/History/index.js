import React from 'react';
import { DatePickerInput } from 'rc-datepicker';
import { Blockquote, TextInput, Label } from '../../../../../../components';
import './styles.css'

const History = (props) => {
    return (
        <div className="row">
            <Blockquote title='Employment History' id='emploment_hist_id' />

            <div className="col-6">
                <div className="form-group row">
                    <div className="col-6">
                        <TextInput
                            label='Company'
                            value={props.data.company_name}
                            requiredfield="true"
                            onChange={ e=>props.employmentChange(e.target.value, 'company_name') }
                        />
                    </div>

                    <div className="col-6">
                        <TextInput
                            label='Position'
                            value={props.data.position}
                            requiredfield="true"
                            onChange={ e=>props.employmentChange(e.target.value, 'position') }
                        />
                    </div>

                    <div className="col-6">
                        <Label label='From' requiredfield="true" />
                        <DatePickerInput
                            displayFormat='DD/MM/YYYY'
                            returnFormat='YYYY-MM-DD'
                            valueLink={{
                              value: props.data.started_at,
                              requestChange: date => props.employmentChange(date, 'started_at')
                            }}
                        />
                    </div>
                      <div className="col-6">
                        <Label label='To' requiredfield="true" />
                        <DatePickerInput
                            displayFormat='DD/MM/YYYY'
                            returnFormat='YYYY-MM-DD'
                            valueLink={{
                              value: props.data.ended_at,
                              requestChange: date => props.employmentChange(date, 'ended_at')
                            }}
                        />
                    </div>

                    <div className="col-12">
                        <TextInput
                            label='Reason for Leaving'
                            value={props.data.reason_for_leaving}
                            onChange={ e=>props.employmentChange(e.target.value, 'reason_for_leaving') }
                        />
                    </div>
                </div>

                <br/>

                <div align="right">
                    <button
                        type="button"
                        className="btn btn-sm btn-primary"
                        disabled={ props.disable }
                        onClick={ props.addEmployment }
                    >
                        <i className="fas fa-plus fa-fw"></i>
                        &nbsp;Add Employment History
                    </button>
                </div>
            </div>
        </div>
    );
}


export default History;
