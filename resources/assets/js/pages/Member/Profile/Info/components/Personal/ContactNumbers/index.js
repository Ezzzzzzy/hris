import React, { Component } from 'react';
import TelephoneNumber from './Telephone';
import MobileNumber from './Mobile';
import './style.css'

class ContactNumbers extends Component{
    render(){
        return (
            <div className='row form-group'>
                <div className="col-6">
                    <TelephoneNumber data={ this.props.data }/>
                </div>
                <div className="col-6">
                    <MobileNumber data={ this.props.data }/>
                </div>
            </div>
        );
    }
}

export default ContactNumbers;