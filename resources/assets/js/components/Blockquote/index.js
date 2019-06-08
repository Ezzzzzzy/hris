import React, { Component } from 'react';
import ReactDOM from 'react-dom';

const Blockquote = ({title, subtitle, id}) =>{
	subtitle = subtitle ? subtitle : '';

	return (
		<div className="col-2 offset-1">
			<div className='blockquote-container' id={ id }>
			    <blockquote>{ title }</blockquote>
			    <div className="row">
			    	<div className="col-10 offset-1">
	            		<small className='subtitle'>{ subtitle }</small>
			    	</div>
			    </div>
			</div>
		</div>
	);
}

export default Blockquote;