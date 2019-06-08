import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import YearPicker from "react-year-picker";
import { Blockquote, Label, Select, TextInput, } from '../../../../../../components';
import './styles.css'

const school_types = [
    { id: 1, name: 'Elementary' },
    { id: 2, name: 'High School' },
    { id: 3, name: 'Tertiary' },
    { id: 4, name: 'Vocational' }
];

const Attainment = (props) => {
    return (
        <div className="row">
            <Blockquote title={'Educational Attainment'} id={'educ_attainment_id'} />

            <div className="col-6">
                <div className="form-group row school-container"> 
                    <div className="col-6">
                        <Select 
                            label='Type'
                            display='name'
                            options={ school_types }
                            optionValue='name'
                            requiredfield="true"
                            onChange={ e=>props.schoolChange(e.target.value, 'school_type') }
                        />
                    </div>
                    
                    <div className="col-6">
                        <TextInput 
                            label='School'
                            value={ props.data.school_name }
                            requiredfield="true"
                            onChange={ e=>props.schoolChange(e.target.value, 'school_name') }
                            />
                    </div>

                    <div className="col-6">
                        <TextInput 
                            label='Course / Degree'
                            value={ props.data.degree }
                            onChange={ e=>props.schoolChange(e.target.value, 'degree') }
                        />
                    </div>

                    <div className="col-3">
                        <Label label='From' />
                        <YearPicker 
                            value={ props.data.started_at }
                            onChange={ date=>props.schoolChange(date, 'started_at') }
                        />
                    </div>

                    <div className="col-3">
                        <Label label='To' />
                        <div align="right">
                            <YearPicker 
                                value={ props.data.ended_at }
                                onChange={date=>props.schoolChange(date, 'ended_at') }
                                 />
                        </div>
                    </div>          
                </div>

                <div align="right">
                    <button 
                        type="button" 
                        onClick={ props.addSchool }
                        disabled={ props.disable }
                        className="btn btn-sm btn-primary custm-btn-adjust-position">
                        <i className="fas fa-plus fa-fw custm-btn-icons custm-btn-names"></i>
                        &nbsp;Add Educational Attainment
                    </button>
                </div>
            </div>
        </div>
    )
}

export default Attainment;