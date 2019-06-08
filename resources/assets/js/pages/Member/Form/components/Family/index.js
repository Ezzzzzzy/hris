import React, { Component } from 'react';
import Background from './Background';
import Table from './Table';

class Family extends Component {
    constructor(props){
        super(props)

    	this.state = {
            disable: true,
            isError: false,
            list: [],
            data: {
                age         : '',
                name        : '',
                occupation  : '',
                family_type : '',
            }
        }
    }

    static getDerivedStateFromProps(props){
        let returnState = {};
        Object.assign(returnState, { isError: props.errors.includes('family_data') && true });

        if (props.form && props.form.id) {
            let { family_data } = props.form;
            Object.assign(returnState, { list: family_data });
        } else if (props.reset) {
            return { list: [] }
        }

        return returnState;
    }

    familyChange(val, propName){
        let disable = false;
        let data = this.state.data;
        data[propName] = val;

        for (let i in data) {
            if (data[i] === '') disable = true;
        }

        this.setState({ data, disable });
    }

    addFamily(){
        const list = this.state.list;
        const data = {
            age         : '',
            name        : '',
            occupation  : '',
            family_type : '',
        }

        list.push(this.state.data)
        this.setState({ list, data, disable: true });
        this.props.handleChange(this.state.list, 'family_data');
    }

		deleteFamily(index){
			const list = this.state.list;
			list.splice(index,1)
			this.setState({ list })
		}

    render(){
		return (
			<div>
				<Background
					handleChange={ this.props.handleChange }
					familyChange={ this.familyChange.bind(this) }
					addFamily={ this.addFamily.bind(this) }
					{ ...this.state }
				/>
				<Table 
                    deleteFamily={ this.deleteFamily.bind(this) }
                    { ...this.state }
                />
			</div>
		);
    }
}

export default Family;
