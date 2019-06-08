import React, { Component } from 'react';
import { Label, TextInput } from '../../../../../../../../components';

const MobileNumber = (props) => {
    let children = props.data.mobile_number;

    children = children.map((val,i) => {
        return (
            <div key={i} >
                <TextInput 
                    placeholder={ val.number }
                    disabled='true'
                />
                <br />
            </div>
        );
    });

    return (
        <div>
           <div className="row">
                <div className="col-12">
                    <Label label='Mobile Number'/>
                    { children }
                </div>
            </div>
       </div>
    );
}

export default MobileNumber;