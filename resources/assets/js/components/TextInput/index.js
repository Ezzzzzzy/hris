import React, { Component } from 'react';
import Label                from '../Label';

/**
 * Display an Input[type=text] Component
 * 
 * @param Object Props
 * @param string label || optional
 * @param string placeholder || optional
 * @param array error || optional
 * @param string id || optional
 * @param boolean requiredfield || optional
 */

const TextInput = (props) =>{
	const placeholder = placeholder ? placeholder : props.label
	const errors = props.errors ? props.errors : [];

    return (
		<div>
			<div className="text-left">
				{ props.label && <Label label={ props.label } requiredfield={ props.requiredfield } /> }
			</div>
            <input
            	id={ props.id }
            	type='text'
	            className={'form-control' } // + ` ${ errors.includes(props.id) && 'error' }` } //pending to be removed
            	placeholder={ placeholder }
            	{...props}
        	/>
		</div>
	);
}

export default TextInput;