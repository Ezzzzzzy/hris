import React from 'react';
import { connect } from 'react-redux';
import { Label, Select } from '../../../../components';
import styles from './style.js';
import { MEMBER_LIST_FILTERED } from '../../../../constants/action.type'

const Tenure = props => {
	return (
		<ul>
			{
				props.data &&
				props.data.map((val, i)=>{
					return (
						<li key={i}>
							<label style={styles['checkbox-container']}>
								<input 
									type='checkbox'
									style={ styles['checkbox'] }
									value={  val.tenure_type }
									onChange={ e=>props.onCheckboxClick(e, 'tenure', props.tenure) }
									checked={ props.tenure.includes(val.tenure_type) }
								/>
								<span style={styles['tenure-type']}>
									{ val.tenure_type }
								</span>
							</label>
						</li>
					);	
				})
			}
		</ul>
	)
}

const Status = props => {
	return (
		<ul>
			{
				props.data &&
				props.data.map((val, i)=>{
					return (
						<li key={i}>
							<label style={styles['checkbox-container']}>
								<input 
									type='checkbox' 
									style={ styles['checkbox'] }
									onChange={ e=>props.onCheckboxClick(e, 'status', props.status) }
									value={ val.status_name }
									checked={ props.status.includes(val.status_name) }
								/>
								<span style={styles['label']}>{ val.status_name }</span>
								<span style={styles['count']}>
									{
										// TO DO
										// [] add count - for the next sprint
										// val.id 
									}
								</span>
							</label>
						</li>
					);	
				})
			}
		</ul>
	)
}

class Filter extends React.Component {
	state = {}

	toggleClick(e, type, arr) {
		let attributes = arr.slice(); // copies the array
		let index = attributes.indexOf(e.target.value);
		attributes = (e.target.checked) 
						? [...attributes, e.target.value] //adds value to array
						: [...attributes.slice(0, index), ...attributes.slice(++index)]; // removes value from array

		this.props.handleFilter({ [type]: attributes });
	}

	handleDropdown(e, type) {
		this.props.handleFilter({[type]: e.target.value});
	}

	render() {
		let { brand, location, status, statusFilter, tenure, tenureFilter, position } = this.props;
		return (
			<div className='col-2' style={{...styles['container'], padding: '20px'}}> 
				<div className='row'>
					<div className='col-12'>
						<span style={{...styles['header']}}>Filter By</span>
					</div>
				</div>

				<div className='row'>
					<div className='col-12'>
						<Label label='STATUS' style={{...styles['status']}} />
						<Status 
							data={ status.employeeStatus } 
							status={ statusFilter }
							onCheckboxClick={ this.toggleClick.bind(this) }
						/>
					</div>
				</div>

				<div className='row'>
					<div className='col-12'>
						<Label label='TENURE' style={{...styles['status']}} />
						<Tenure 
							data={ tenure.tenure }
							tenure={ tenureFilter }
							onCheckboxClick={ this.toggleClick.bind(this) }
						/>
					</div>
				</div>

				<div className='row'>
					<div className='col-12'>
						<Label label='POSITION' style={{...styles['status']}} />
							<Select
								options={ position.position }
								display='position_name'
								optionValue='id'
								onChange={ e=>this.handleDropdown(e, 'position') }
							/>
					</div>
				</div>

				<div className='row'>
					<div className='col-12'>
						<Label label='BRAND' style={{...styles['status']}} />
						<Select
							options={ brand.brand }
							display='brand_name'
							optionValue='id'
							onChange={ e=>this.handleDropdown(e, 'brand') }
						/>
					</div>
				</div>

				<div className='row'>
					<div className='col-12'>
						<Label label='LOCATION' style={{...styles['status']}} />
						<Select
							options={ location.location }
							display='name'
							optionValue='id'
							onChange={ e=>this.handleDropdown(e, 'location') }
						/>
					</div>
				</div>
			</div>
		);
	}
}

const mapDispatchToProps = dispatch => ({
	onSubmit: payload => dispatch({ type: MEMBER_LIST_FILTERED, payload }),
});

export default connect(()=>({}), mapDispatchToProps)(Filter);