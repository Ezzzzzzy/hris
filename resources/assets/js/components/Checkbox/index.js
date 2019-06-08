import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Label from '../Label';

const Checkbox = ({label, id, ...props}) => {
	return (
		<div>
	        <input 
	        	type="checkbox" 
	        	className={`form-check-input ${props.className}`}
	        	id={ id } 
	        	{...props}
        	/>
	        
	        { label && <Label label={ label } /> }
        </div>
	);	

}

export default Checkbox;