import React, { Component } from 'react';
import ReactDOM             from 'react-dom';
import Label                from '../Label';
import './style.css';

/**
 * Display an Input[type=text] Component
 * 
 * @param Object Props
 * @param string label
 * @param string placeholder
 * @param array Errors
 * @param string id
 * @param boolean requiredfield
 */

const TextBox = (props) =>{
	const placeholder = placeholder ? placeholder : props.label
	const errors = props.errors ? props.errors : [];

    return (
		<div>
			
			{ props.label && <Label label={ props.label } requiredfield={ props.requiredfield } /> }

            <input
            	id={props.id}
            	type='text'
	            className={'form-control' + ` ${ errors.includes(props.id) && 'error' }` }
            	placeholder={ placeholder }
            	{...props}
        	/>
		</div>
	);
}

export default TextBox;