import React, { Component } from 'react';
import { TextInput } from '../../../../../../components';

class EmailAddress extends Component {
    state = { email_address: '', fb_address: '' };

    static getDerivedStateFromProps(props){
        if (props.form && props.form.id){
            let { email_address, fb_address } = props.form;
            return { email_address, fb_address }
        } else if (props.reset) {
            return { email_address: '', fb_address: '' };
        } else return null
    }

    handleChange(val, propName){
        let state = this.state;
        state[propName] = val;
        this.setState({ state }, ()=>{
            this.props.handleChange(state[propName], propName);
        });
    }

    render(){
        let { errors } = this.props;
        let { email_address, fb_address } = this.state;

        return (
            <div>
                <div className='form-group row'>
                    <div className='col-6'>
                        <TextInput
                            id='fb_address'
                            label='Facebook Email Address'
                            value={ fb_address }
                            onChange={ e=>this.handleChange(e.target.value, 'fb_address') }
                        />
                    </div>

                    <div className='col-6'>
                        <TextInput
                            errors={ errors }
                            id='email_address'
                            value={ email_address }
                            requiredfield='true'
                            label='Personal Email Address'
                            onChange={ e=>this.handleChange(e.target.value, 'email_address') }
                        />
                    </div>
                </div>
            </div>
        );
    }
}

export default EmailAddress;