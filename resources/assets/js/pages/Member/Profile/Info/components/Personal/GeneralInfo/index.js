import React, { Component } from 'react';
import { TextInput } from '../../../../../../../components';
import './style.css';

const GeneralInfo = (props) => {
    return (
        <div className='row'>
            <div className='col-3 gender-container'>
                <TextInput 
                    label='Gender'
                    placeholder={ props.data.gender }
                    disabled='true'
                />
            </div>

            <div className='col-3'>
                <TextInput 
                    label='Height'
                    placeholder={ props.data.height }
                    disabled='true'
                />
            </div>

            <div className='col-3'>
                <TextInput 
                    label='Weight'
                    placeholder={ props.data.weight }
                    disabled='true'
                />
            </div>

            <div className='col-3'>
                <TextInput 
                    label='Civil Status'
                    placeholder={ props.data.civil_status }
                    disabled='true'
                />
            </div>
        </div>
    );
}

export default GeneralInfo;