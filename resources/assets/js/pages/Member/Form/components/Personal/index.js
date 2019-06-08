import React from 'react';
import Name from './Name';
import Title from './Title';
import Address from './Address';
import Birthdate from './Birthdate';
import EmailAddress from './EmailAddress';
import ContactNumbers from './ContactNumbers';
import GeneralInfo from './GeneralInfo';

const Personal = (props) => {
                    
    return (
        <div className='row'>
            <Title />

            <div className='col-6'>
                <div className='card card-body'>
                    <Name {...props} />
                    <Address {...props} />
                    <Birthdate {...props} />
                    <GeneralInfo {...props} />
                    <ContactNumbers {...props} />
                    <EmailAddress {...props} />
                </div>
            </div>
        </div>
    )
}

export default Personal;