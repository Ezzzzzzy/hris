import React, { Component } from 'react';
import TelephoneNumber from './Telephone';
import MobileNumber from './Mobile';
import './styles.css'

class ContactNumbers extends Component{
    render(){
        return (
            <div className='row form-group'>
                <div className="col-6">
                    <TelephoneNumber {...this.props } />
                </div>
                <div className="col-6">
                    <MobileNumber {...this.props } />
                </div>
            </div>
        );
    }
}

export default ContactNumbers;