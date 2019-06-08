import React, { Component } from 'react';
import { Label, TextInput } from '../../../../../../../../components';

const TelephoneNumber = (props) => {
    let children = props.data.telephone_number;

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
                    <Label label='Telephone Number'/>
                    { children }
                </div>
            </div>
       </div>
    );
}

export default TelephoneNumber;