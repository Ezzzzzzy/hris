import React, { Component }  from 'react';
import { Label, TextInput, DatePicker }    from '../../../../../../components';

class Birthdate extends Component {
    state = { birthdate: '', birthplace: '' };

    static getDerivedStateFromProps(props, state){
        if (props.form && props.form.id){
            let { birthdate, birthplace } = props.form;
            return { birthdate, birthplace };
        } else if (props.reset) {
            return { birthdate: '', birthplace: '' };
        } else return null
    }

    handleChange(val, propName){
        let state = this.state;
        state[propName] = val;
        this.setState({ state }, ()=>{
            this.props.handleChange(this.state[propName], propName);
        })
    }

    render(){
        let { errors } = this.props;
        let { birthdate, birthplace } = this.state;

        return (
            <div>
                <div className='form-group row'>
                    <div className='col-6'>
                        <Label label='Date of Birth' requiredfield="true" />
                        <DatePicker
                            id='birthdate'
                            errors={ errors }
                            value={ birthdate }
                            onChange={ date=>this.handleChange(date, 'birthdate') }
                        />
                    </div>
                    <div className='col-6'>
                        <TextInput
                            id='birthplace'
                            errors={ errors }
                            requiredfield={ 1 }
                            value={ birthplace }
                            label='Place of Birth'
                            onChange={ e=>this.handleChange(e.target.value, 'birthplace') }
                        />
                    </div>
                </div>
            </div>
        );
    }
}
export default Birthdate;

