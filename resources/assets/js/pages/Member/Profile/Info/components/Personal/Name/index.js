import React, { Component } from 'react';
import { TextInput } from '../../../../../../../components';

const Name = (props) => {
	return (
		<div>
			<div className="form-group row">
	         	<div className="col-5 custm-TextInput-align-card">
	            	<TextInput label='Last Name' placeholder={ props.data.last_name } disabled="true"/>
				</div>

				<div className=" col-5 custm-TextInput-align-card custm-fname-box ">
					<TextInput label='First Name' placeholder={ props.data.first_name } disabled='true'/>
				</div>

				<div className=" col-2 custm-TextInput-align-card custm-width-ext ">
					<TextInput placeholder={ props.data.extension_name } disabled='true' label='Name Ext.'/>
				</div>
	        </div>

	        <div className="form-group row">
	        	<div className="col-6">
	            	<TextInput label='Middle Name' placeholder={ props.data.middle_name } disabled='true'/>
	        	</div>

				<div className="col-6">
	            	<TextInput label='Nickname' placeholder={ props.data.nickname } disabled='true'/>
				</div>
	        </div>
        </div>
	);
}

export default Name;