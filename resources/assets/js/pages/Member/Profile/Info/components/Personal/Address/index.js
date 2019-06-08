import React, { Component } from 'react';
import { TextInput }   from '../../../../../../../components';

const Address = (props) => {
    return (
        <div>
            <div className='row form-group'>
                <div className='col-8'>
                    <TextInput 
                        label='Present Address' 
                        placeholder={ props.data.present_address } 
                        disabled='true' 
                    />
                </div>
                <div className="col-4">
                    <TextInput
                        label='City'
                        placeholder={ props.data.present_city }
                        disabled='true'
                    />
                </div>
            </div>

            <div className='form-group row'>
                <div className='col-8'>
                    <TextInput
                        label='Permanent Address'
                        placeholder={ props.data.permanent_address }
                        disabled='true'
                    />
                </div>
                <div className="col-4">
                    <TextInput
                        label='City'
                        placeholder={ props.data.permanent_city }
                        disabled='true'
                    />
                </div>
            </div>
        </div>
    );
}

export default Address;
