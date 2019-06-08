import React, { Component } from 'react';
import { TextInput, TextInputGroup } from '../../../../../../../components';

class MobileNumber extends Component{
    state = { 
        number: '',
        mobile_number: [],
    }

    static getDerivedStateFromProps(props){
        if (props.form && props.form.id){
            let { mobile_number } = props.form;
            return { mobile_number };
        } else if (props.reset) {
            return { mobile_number: [] }
        } else return null;
    }

    handleChange(number){
        this.setState({ number })
    }

    remove(i){
        let mobile_number = this.state.mobile_number;
        mobile_number.splice(i, 1);
        this.setState({mobile_number});
    }

    addField(){
        let mobile_number = this.state.mobile_number;
        mobile_number.push({number: this.state.number});

        this.setState({ 
            number: '',
            mobile_number,
        }, () => this.props.handleChange(this.state.mobile_number, 'mobile_number'));
    }

    renderView(){
        return this.state.mobile_number 
            && this.state.mobile_number.map((val, i, arr) => {
                return <div key={i}>
                        <br />
                        <TextInputGroup 
                            value={ val.number || val }
                            onClick={ ()=> this.remove(i) } 
                            disabled
                        />
                    </div>
        });
    }

    render(){
        let { errors } = this.props;
        let { number } = this.state;

        return (
           <div>
               <div className="row">
                    <div className="col-12">
                        <TextInput 
                            id='mobile_number'
                            errors={ errors }
                            value={ number }
                            label='Mobile Number'
                            name='mobile_number'
                            onChange={ e=>this.handleChange(e.target.value) }
                        />

                        { this.renderView() }
                    </div>
                </div>

                <div className="row">
                    <div className="col-6">
                        <button 
                            className='btn btn-sm btn-add btn-primary'
                            onClick={ ()=>this.addField() }
                            disabled={ !number }
                        >
                            <i className='fas fa-plus fa-fw'></i>
                            Add Number
                        </button>
                    </div>
                </div>
           </div>
        );
    }
}

export default MobileNumber;