import React, { Component } from 'react';
import Table from './Table';
import Attainment from './Attainment';

class Education extends Component {
    constructor(props){
        super(props);

        this.schoolChange = this.schoolChange.bind(this);
        this.addSchool = this.addSchool.bind(this);

        this.state = {
            isError: false,
            list: [],
            disable: true,
            data: {
                degree: '',
                ended_at: '',
                started_at: '',
                school_name: '',
                school_type: '',
            },
        }
    }
    
    static getDerivedStateFromProps(props){
        let returnState = {};
        Object.assign(returnState, { isError: props.errors.includes('school_data') && true });

        if (props.form && props.form.id) {
            let { school_data } = props.form;
            Object.assign(returnState, { list: school_data });
        } else if (props.reset) { 
            return { list : [] }
        }

        return returnState;
    }

    schoolChange(val, propName){
        let disable = false;
        let data = this.state.data;
        data[propName] = val;

        for (let i in data){
            if (data[i] === '' && i !== 'degree') {
                disable = true;
            };
        }

        this.setState({ data, disable });
    }

    addSchool(){
        const list = this.state.list;
        const data = {
            degree:      '',
            ended_at:    '',
            started_at:  '',
            school_name: '',
            school_type: '',
        }

        list.push(this.state.data)
        this.setState({ list, data, disable: true });
        this.props.handleChange(this.state.list, 'school_data');
    }

	deleteSchool(index){
		const list = this.state.list;
		list.splice(index,1)
		this.setState({ list })
	}

	render(){
		return (
			<div>
				<Attainment
					handleChange={ this.props.handleChange }
					schoolChange={ this.schoolChange }
					addSchool={ this.addSchool.bind(this) }
					{ ...this.state }
				/>
				<Table
                    deleteSchool={ this.deleteSchool.bind(this) } 
                    { ...this.state } 
                />
			</div>

		);
	}
}

export default Education;