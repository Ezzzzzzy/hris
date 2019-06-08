import React, { Component } from 'react';

const TextInputGroup = props =>{
	return (
		<div className="input-group mb-3">
			<input 
				type="text" 
				className="form-control"
				placeholder={ props.placeholder }
				value={ props.value || '' }
				{ ...props }
			/>
			<div className="input-group-append">
		    	<button 
		    		className="btn btn-danger" 
		    		onClick={ props.onClick }
	    		>X
	    		</button>
			</div>
		</div>
	);
}

export default TextInputGroup;