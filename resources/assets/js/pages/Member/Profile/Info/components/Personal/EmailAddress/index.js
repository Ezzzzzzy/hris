import React, { Component } from 'react';
import { TextInput } from '../../../../../../../components';

const EmailAddress = (props) => {
    return (
        <div>
            <div className='form-group row'>
                <div className='col-6'>
                    <TextInput
                        label='Facebook Email Address'
                        placeholder={ props.data.email_address }
                        disabled='true'
                    />
                </div>

                <div className='col-6'>
                    <TextInput
                        label='Personal Email Address'
                        placeholder={ props.data.fb_address }
                        disabled='true'
                    />
                </div>
            </div>
        </div>
    );
}

export default EmailAddress;
