import React, { Component } from 'react';
import { Blockquote, TextInput } from '../../../../../components';

class Government extends Component {    
    state = { 
        tin: '',
        sss_num:'',
        pag_ibig_num: '',
        philhealth_num: '',
    }

    static getDerivedStateFromProps(props){
        if (props.form && props.form.id){
            let { sss_num, pag_ibig_num, philhealth_num, tin } = props.form;
            return { sss_num, pag_ibig_num, philhealth_num, tin };
        } else if (props.reset) {
            return { 
                tin: '',
                sss_num:'',
                pag_ibig_num: '',
                philhealth_num: '',
            }
        } else return null;
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
        let { sss_num, pag_ibig_num, philhealth_num, tin } = this.state;

        return (
            <div className="row">
                <Blockquote title='Government Mandated Numbers' subtitle='atleast 1 is required' id={'gov_mandated_id'} />

                <div className="col-6">
                    <div className="card card-body custm-card-margin">
                        <div className="form-group row">
                            <div className='col-6'>
                                <TextInput 
                                    label='SSS Number'
                                    value={ sss_num }
                                    requiredfield="true"
                                    onChange={ e=>this.handleChange(e.target.value, 'sss_num') }
                                />
                            </div>

                            <div className='col-6'>
                                <TextInput 
                                    label='Pagibig Number'
                                    value={ pag_ibig_num }
                                    requiredfield="true"
                                    onChange={ e=>this.handleChange(e.target.value, 'pag_ibig_num') }
                                />
                            </div>
                        </div>

                        <div className="form-group row">
                            <div className='col-6'>
                                <TextInput 
                                    label='Philhealth Number'
                                    value={ philhealth_num }
                                    requiredfield="true"
                                    onChange={ e=>this.handleChange(e.target.value, 'philhealth_num') }
                                />
                            </div>

                            <div className='col-6'>
                                <TextInput 
                                    value={ tin }
                                    label='TIN Number'
                                    onChange={ e=>this.handleChange(e.target.value, 'tin') }
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default Government;