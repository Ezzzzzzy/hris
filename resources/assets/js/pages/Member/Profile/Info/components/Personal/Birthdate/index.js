import React, { Component }  from 'react';
import { TextInput }    from '../../../../../../../components';

const Birthdate = (props) => {
    return (
        <div>
            <div className='form-group row'>
                <div className='col-6'>
                    <TextInput label='Date Of Birth' placeholder={ props.data.birthdate } disabled='true' />
                </div>

                <div className='col-6'>
                    <TextInput label='Place of Birth' placeholder={ props.data.birthplace } disabled='true' />
                </div>
            </div>
        </div>
    );
}

export default Birthdate;
