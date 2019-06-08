import React, { Component }   from 'react';
import { TextInput }            from '../../../../../../components';

class Name extends Component {
    state = {
        nickname: '',
        last_name: '',
        first_name: '',
        middle_name: '',
        extension_name: '',
    }

    static getDerivedStateFromProps(props, state){
        if (props.form && props.form.id){
            let { first_name, middle_name, last_name, extension_name, nickname } = props.form;
            return { first_name, middle_name, extension_name, last_name, nickname };
        } else if (props.reset) {
            return { nickname: '', last_name: '', first_name: '', middle_name: '', extension_name: '', }
        } else return null;
    }

    handleChange(val, propName){
        let state = this.state;
        state[propName] = val;
        this.setState({ state }, () =>{
            this.props.handleChange(this.state[propName], propName)
        });
    }

    render(){
        let { first_name, middle_name, last_name, extension_name, nickname } = this.state;
        let { errors } = this.props;

        return (
            <div>
                <div className='form-group row'>
                    <div className='col-5'>
                        <TextInput
                            id='last_name'
                            errors={ errors }
                            label='Last Name'
                            value={ last_name }
                            requiredfield="true"
                            onChange={ e =>this.handleChange(e.target.value, 'last_name') }
                        />
                    </div>

                    <div className='col-5'>
                        <TextInput
                            id='first_name'
                            errors={ errors }
                            label='First Name'
                            value={ first_name }
                            requiredfield="true"
                            onChange={ e =>this.handleChange(e.target.value, 'first_name') }
                        />
                    </div>

                    <div className='col-2'>
                        <TextInput
                            label='Name Ext'
                            placeholder='Ext'
                            value={ extension_name || '' }
                            onChange={ e =>this.handleChange(e.target.value, 'extension_name') }
                        />
                    </div>
                </div>

                <div className='form-group row'>
                    <div className='col-6'>
                        <TextInput
                            id='middle_name'
                            errors={ errors }
                            label='Middle Name'
                            requiredfield="true"
                            value={ middle_name }
                            onChange={ e =>this.handleChange(e.target.value, 'middle_name') }
                        />
                    </div>

                    <div className='col-6'>
                        <TextInput
                            label='Nickname'
                            value={ nickname }
                            onChange={ e =>this.handleChange(e.target.value, 'nickname') }
                        />
                    </div>
                </div>
            </div>
        )
    }
}

export default Name;