import React, { Component } from 'react';
import { TextInput, TextInputGroup } from '../../../../../../../components';

class TelephoneNumber extends Component{
    state = { 
        number: '',
        telephone_number: [],
    }

    static getDerivedStateFromProps(props){
        if (props.form && props.form.id){
            let { telephone_number } = props.form;
            return { telephone_number };
        } else if (props.reset) {
            return { telephone_number: [] }
        } else return null;
    }

    handleChange(number){
        this.setState({ number })
    }

    remove(i){
        let telephone_number = this.state.telephone_number;
        telephone_number.splice(i, 1);
        this.setState({telephone_number});
    }

    addField(){
        let telephone_number = this.state.telephone_number;
        telephone_number.push({number: this.state.number});

        this.setState({ 
            number: '',
            telephone_number,
        }, () => this.props.handleChange(this.state.telephone_number, 'telephone_number'));
    }

    renderView(){
        return this.state.telephone_number
            && this.state.telephone_number.map((val, i) => {
                return (
                    <div key={i}>
                        <br />
                        <TextInputGroup 
                            value={ val.number || val }
                            onClick={ ()=> this.remove(i) } 
                            disabled
                        />
                    </div>
                )
            })
    }

    render(){
        let { errors } = this.props;
        let { number } = this.state;

        return (
           <div>
               <div className="row">
                    <div className="col-12">
                        <TextInput 
                            id='tel_number'
                            errors={ errors }
                            value={ number }
                            label='Telephone Number'
                            name='tel_num'
                            onChange={ e=>this.handleChange(e.target.value) }
                        />

                        { this.renderView() }
                    </div>
                </div>

                <div className="row">
                    <div className="col-6">
                        <button 
                            className='btn btn-sm btn-add btn-primary'
                            onClick={ ()=>{ this.addField() }}
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

export default TelephoneNumber;