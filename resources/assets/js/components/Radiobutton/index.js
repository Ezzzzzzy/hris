import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Label from '../Label';

const Radiobutton = props => {
	let { name, value, checked, label } = props;
	checked = checked ? checked : false;

	return (
		<div className="form-check form-check-inline">
            <input
                type='radio'
                name={ name }
                value={ value }
                checked={ checked }
                className='form-check-input'
                { ...props }
            />
            {
            	label && <Label label={ label } />
            }
        </div>
	);
}

export default Radiobutton;