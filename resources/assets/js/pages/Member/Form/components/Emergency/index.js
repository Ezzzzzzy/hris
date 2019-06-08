import React, { Component } from 'react';
import Info from './info';
import Table from './Table';

class Emergency extends Component {
    constructor(props){
        super(props);
        
    	this.state = {
            isError: false,
            list: [],
            disable: true,
            data: {
                name         : '',
                address 	 : '',
                contact 	 : '',
                relationship : '',
            }
        }
    }

    static getDerivedStateFromProps(props){
        let returnState = {};
        Object.assign(returnState, { isError: props.errors.includes('emergency_data') && true });

        if (props.form && props.form.id){
            let { emergency_data } = props.form;
            Object.assign(returnState, { list: emergency_data });
        } else if (props.reset) {
            return { list: [] };
        }

        return returnState;
    }

    contactChange(val, propName){
        let disable = false;
        let data = this.state.data;
        data[propName] = val;

        for (let i in data){
            if (data[i] === '') disable = true;
        }

        this.setState({ data, disable });
    }

    addContact(){
        const list = this.state.list;
        const data = {
            name         : '',
            address 	 : '',
            contact 	 : '',
            relationship : '',
        }

        list.push(this.state.data)
        this.setState({ list, data, disable: true });
        this.props.handleChange(this.state.list, 'emergency_data');
    }

	deleteContact(index){
		const list = this.state.list;
		list.splice(index,1)
		this.setState({ list })
	}

    render(){
    	return (
    		<div>
    			<Info
    				handleChange={ this.props.handleChange }
					contactChange={ this.contactChange.bind(this) }
					addContact={ this.addContact.bind(this) }
					{ ...this.state }
    			/>
    			<Table 
                    deleteContact={ this.deleteContact.bind(this) }
                    { ...this.state }
                />
    		</div>
    	);
    }
}

export default Emergency;
