import React, { Component } from 'react';
import Table from './Table';
import History from './History';

class Employment extends Component {
    constructor(props){
        super(props)

    	this.state = {
            isError: false,
            list: [],
            disable: true,
            data: {
                position           : '',
                ended_at           : '',
                started_at         : '',
                company_name       : '',
                reason_for_leaving : '',
            }
        }
    }

    static getDerivedStateFromProps(props){
        let returnState = {};
        Object.assign(returnState, { isError: props.errors.includes('emp_history_data') && true });

        if (props.form && props.form.id) {
            let { emp_history_data } = props.form;
            Object.assign(returnState, { list: emp_history_data });
        } else if (props.reset) {
            return { list: [] };
        }

        return returnState;
    }

    employmentChange(val, propName){
        let disable = false;
        let data = this.state.data;
        data[propName] = val;

        for (let i in data){
            if (data[i] === '') disable = true;
        }

        this.setState({ data, disable });
    }

    addEmployment(){
        const list = this.state.list;
        const data = {
            position           : '',
            ended_at           : '',
            started_at         : '',
            company_name       : '',
            reason_for_leaving : '',
        }

        list.push(this.state.data)
        this.setState({ list, data, disable: true });
        this.props.handleChange(this.state.list, 'emp_history_data');
    }

		deleteEmployment(index){
			const list = this.state.list;
			list.splice(index,1)
			this.setState({ list })
		}

    render(){
		return (
			<div>
				<History
					handleChange={ this.props.handleChange }
					employmentChange={ this.employmentChange.bind(this) }
					addEmployment={ this.addEmployment.bind(this) }
					{ ...this.state }
				/>
                <Table 
                    deleteEmployment={this.deleteEmployment.bind(this)}
                    { ...this.state }
                />
			</div>
		);
    }
}

export default Employment;