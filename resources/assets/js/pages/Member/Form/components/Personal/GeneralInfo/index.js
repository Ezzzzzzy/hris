import React, { Component } from 'react';
import { TextInput, Label, Radiobutton } from '../../../../../../components';
import './styles.css';

const Gender = (props) => {
    let { gender, handleChange } = props;

    return (
        <div className='gender-container'>
            <div className="form-check-inline">
                <Radiobutton 
                    name='gender'
                    value='Male'
                    label='Male'
                    checked={ gender === 'Male' }
                    onChange={ e=>handleChange(e.target.value, 'gender')}
                />

                <Radiobutton
                    name='gender'
                    value='Female'
                    label='Female'
                    checked={ gender === 'Female' }
                    onChange={ e=>handleChange(e.target.value, 'gender')}
                />
            </div>
        </div>
    )
}

class GeneralInfo extends Component {
    state = {
        gender: '',
        height: '',
        weight: '',
        civil_status: '',
    }

    static getDerivedStateFromProps(props, state){
        if (props.form && props.form.id){
            let { gender, height, weight, civil_status } = props.form;
            return { gender, height, weight, civil_status }
        } else if (props.reset) {
            return {
                gender: '',
                height: '',
                weight: '',
                civil_status: '',
            }
        } else return null;
    }

    handleChange(val, propName){
        let state = this.state;
        state[propName] = val;
        this.setState({state}, ()=>{
            this.props.handleChange(this.state[propName], propName)
        });
    }

    render(){
        let { gender, height, weight, civil_status } = this.state;

        return (
            <div className='row'>
                <div className='col-3'>
                    <Label requiredfield={1} label='Gender'/>
                    <Gender { ...this.state } handleChange={ this.handleChange.bind(this) }/>
                </div>

                <div className='col-3'>
                    <TextInput
                        label='Height'
                        value={ height }
                        onChange={ e=>this.handleChange(e.target.value, 'height') }
                    />
                </div>

                <div className='col-3'>
                    <TextInput
                        label='Weight'
                        value={ weight }
                        onChange={ e=>this.handleChange(e.target.value, 'weight') }
                    />
                </div>

                <div className='col-3'>
                    <TextInput
                        id='civil_status'
                        errors={ this.props.errors }
                        label='Civil Status'
                        value={ civil_status }
                        onChange={ e=>this.handleChange(e.target.value, 'civil_status') }
                    />
                </div>
            </div>
        );
    }
}

export default GeneralInfo;