import React, { Component } from 'react';
import Name from './Name';
import Address from './Address';
import Birthdate from './Birthdate';
import GeneralInfo from './GeneralInfo';
import EmailAddress from './EmailAddress';
import ContactNumbers from './ContactNumbers';
import { Blockquote } from '../../../../../../components';

const Personal = (props) => {
    return (
        <div className='row'>
            <Blockquote title='Personal Information' />

            <div className='col-6'>
                <div className='card card-body'>
                    <Name data={ props.data } />
                    <Address data={ props.data } />
                    <Birthdate data={ props.data } />
                    <GeneralInfo data={ props.data }  />
                    <ContactNumbers data={ props.data } />
                    <EmailAddress data={ props.data }  />
                </div>
            </div>
        </div>
    )
}

export default Personal;