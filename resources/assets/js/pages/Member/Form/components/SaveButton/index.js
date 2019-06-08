import React, { Component } from 'react';
import { connect } from 'react-redux';
import member from '../../../../../reducers/Member/actions';
import { ADD_MEMBER } from '../../../../../constants/action.type';
import formJSON from '../../form.json';

const MapDispatchToProps = dispatch => ({
	onSubmit: (form) => dispatch({type:ADD_MEMBER, payload: form}),
})

class SaveButtons extends Component{
	state = { errors: [] }

	formValidation(){
		let form = this.props.form;
		let errors = this.state.errors;
		let isValid = true;

		let requiredFields = [
			'existing_member_id',
			'last_name',
			'first_name',
			'middle_name',
			'present_address',
			'present_city',
			'birthdate',
			'birthplace',
			'gender',
			'civil_status',
			'telephone_number',
			'mobile_number',
			'email_address',
			'sss_num',
			'pag_ibig_num',
			'philhealth_num',
			'school_data',
			'family_data',
			'emergency_data',
			'references_data',
			'emp_history_data',
		];

		for (let x=0; x<requiredFields.length;x++) {
			// check if form[propName] doesn't have a value
			if (!form[requiredFields[x]]) {

				// check if propName is not included in the array of errors
				if (!errors.includes(requiredFields[x])) {
					errors.push(requiredFields[x]);
				}

				isValid = false;
			} else {
				// for empty array
				if (Array.isArray(form[requiredFields[x]]) && (form[requiredFields[x]].length === 0 || form[requiredFields[x]][0] === '')) {
					errors.push(requiredFields[x]);
					isValid = false;
				} else {
					let index = errors.indexOf(requiredFields[x]);
					(index > -1) && errors.splice(index, 1);
				}
			}
		}

		this.setState({ errors });

		return isValid;
	}

	createMember(form, type='add'){
		if (this.formValidation()) {
			if (this.props.type === 'EDIT_FORM_LOAD') {
				this.props.onSubmit(member.update(form));
			} else {
				this.props.onSubmit(member.create(form));

				if (type === 'another') {
					// delays the reset after submitting
					setTimeout(()=>this.props.reset(), 1500);
				}
			}
		} else this.props.getErrors(this.state.errors);
	}

	render() {
		return (
	        <div className="row">
	            <div className="col-5 offset-4">
					<div className="save-buttons-below" align="right">
						{
							this.props.type === "ADD_FORM_LOADED" 
							&& (
						    	<button
    						    	type="button"
    						    	className="btn btn-sm btn-success custm-btn-division custm-btn-adjust-position"
    						    	onClick={ e=>this.createMember(this.props.form, 'another') }
    					    	>
    						    	Save and Add Another
    					    	</button>
					    	)
						}

					    <button
					    	type="button"
					    	className="btn btn-sm btn-success custm-btn-division custm-btn-adjust-position"
					    	onClick={ ()=>this.createMember(this.props.form) }>
					    	Save Profile
				    	</button>
					</div>
				</div>
			</div>
		);
	}
}

export default connect(()=>({}), MapDispatchToProps)(SaveButtons);