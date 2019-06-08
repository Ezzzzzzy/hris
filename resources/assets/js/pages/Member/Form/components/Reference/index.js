import React, { Component } from 'react';
import Info from './Info';
import Table from './Table';

class Reference extends Component {
    constructor(props){
        super(props);
        
        this.state = {
            disable: true,
            isError: false,
            list: [],
            data: {
                name    : '',
                address : '',
                company : '',
                contact : '',
                position: '',
            }
        }
    }

    static getDerivedStateFromProps(props){
        let returnState = {};
        Object.assign(returnState, { isError: props.errors.includes('references_data') && true });

        if (props.form && props.form.id){
            let { references_data } = props.form;
            Object.assign(returnState, { list: references_data });
        } else if (props.reset) {
            return { list: [] };
        }

        return returnState;
    }

    referenceChange(val, propName){
        let disable = false;
        let data = this.state.data;
        data[propName] = val;

        for (let i in data) {
            if (data[i] === '') disable = true;
        }

        this.setState({ data, disable });

    }

    addReference(){
        const list = this.state.list;
        const data = {
        	name 	: '',
            address : '',
            company : '',
            contact : '',
            position: '',
        }

        list.push(this.state.data)
        this.setState({ list, data, disable: true });
        this.props.handleChange(this.state.list, 'references_data');
    }

	deleteReference(index){
		const list = this.state.list;
		list.splice(index,1)
		this.setState({ list })
	}

    render(){
        return (
            <div>
                <Info
                    handleChange={ this.props.handleChange }
                    referenceChange={ this.referenceChange.bind(this) }
                    addReference={ this.addReference.bind(this) }
                    { ...this.state }/>
                <Table 
                    deleteReference={ this.deleteReference.bind(this) }
                    { ...this.state } 
                />
            </div>
        );
    }
}

export default Reference;