import React, { Component } from 'react';
import ReactDOM from 'react-dom';

/**
 * Display a Label Element
 *
 * @param Object props
 * @param string label
 * @param boolean requiredfield
 */
const Label = (props) => {
	return (
		<div className="text-left">
			<label {...props}>
				{ props.label } 
				{ props.requiredfield && <span className='required'>*</span> }
			</label>
		</div>
	);
}

export default Label;