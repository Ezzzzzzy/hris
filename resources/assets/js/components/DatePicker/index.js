import React, { Component } from 'react';
import { DatePickerInput } from 'rc-datepicker';

/**
 * Displays a datepicker component
 *
 * @param object props
 * @param string id
 * @param string value
 * @param array errors
 * @param function onChange
 *
 */

class DatePicker extends Component {
	constructor(props) {
		super(props);

		this.state = {
			id: '',
			value: '',
			errors: [],
			invalidDate: false
		};
	}

	static getDerivedStateFromProps(props) {
		let { errors, value, id } = props;
		return { errors, value, id } || null;
	}

	returnIfInvalidDate(date) {
		if (date === 'Invalid date') {
			this.setState({ invalidDate: true });
		} else {
			this.setState({ invalidDate: false });
			this.props.onChange(date);
		}
	}

	render() {
		let { errors, value, id } = this.state;

		return (
			<div>
				<DatePickerInput
					name = {this.props.name} 
					id={id}
					className={'datepicker' } //+ ` ${errors.includes(id) && 'error'}`} //pending to be removed
					value={value}
					displayFormat='MMMM DD, YYYY'
					returnFormat='MMMM-DD-YYYY'
					valueLink={{
						value,
						requestChange: date => this.returnIfInvalidDate(date)
					}}
				/>

				{this.state.invalidDate && (
					<span className='invalid-date'>Invalid Date</span>
				)}
			</div>
		);
	}
}

export default DatePicker;
