import React, { Component }                   from 'react';
import { Checkbox, Label, Select, TextInput }   from '../../../../../../components';
import { connect }                            from 'react-redux';

const mapStateToProps = state => {return{ cities: state.city }};

class Address extends Component {
    state = {
        cities: [],
        present_city: '',
        permanent_city: '',
        present_address: '',
        permanent_address: '',
    }

    static getDerivedStateFromProps(props, state){
        let returnState = {};
        if (props.cities.payload && props.cities.payload.data) {
            Object.assign(returnState, { cities: props.cities.payload.data })
        }

        if (props.form && props.form.id){
            let { present_address, permanent_address } = props.form;
            Object.assign(returnState, { 
                permanent_city: props.form.address_cities_permanent_id, 
                present_city: props.form.address_cities_present_id,
                present_address, permanent_address 
            })
        } else if (props.reset) {
            // resetting the form
            return {
                present_city: '',
                permanent_city: '',
                present_address: '',
                permanent_address: '',
            }
        };

        return returnState || null;
    }

    handleChange(val, propName){
        let state = this.state;
        state[propName] = val;
        this.setState({ state }, ()=>{
            this.props.handleChange(this.state[propName], propName)
        });
    }

    copyInput(){
        const checkbox = document.getElementById('check_box');
        const present = document.getElementById('present_address');
        const permanent = document.getElementById('permanent_address');
        const presentId = document.getElementById('present_city');
        const permanentId = document.getElementById('permanent_city');

        if(checkbox.checked){
            permanent.value = present.value;
            permanentId.value = presentId.value;

            this.props.handleChange(permanent.value, 'permanent_address');
            this.props.handleChange(permanentId.value, 'permanent_city');
        }else {
            permanent.value = '';
            permanentId.value = 'Select City';
        }
    }

    render(){
        let { errors, reset } = this.props;
        let { permanent_city, present_city, permanent_address, present_address, cities } = this.state;

        return (
            <div>
                <div className='row form-group'>
                    <div className='col-8'>
                        <TextInput
                            id='present_address'
                            errors={ errors }
                            label='Present Address'
                            requiredfield="true"
                            value={ present_address }
                            onChange={ e=>this.handleChange(e.target.value, 'present_address') }
                        />
                    </div>

                    <div className='col-4'>
                        <Select
                            id='present_city'
                            label='City'
                            optionValue='id'
                            errors={ errors }
                            options={ cities }
                            requiredfield={ 1 }
                            display='city_name'
                            selectValue={ present_city }
                            onChange={ e=>this.handleChange(e.target.value, 'present_city') }
                        />
                    </div>
                </div>

                <div className='form-group row'>
                    <div className='col-8'>
                        <div className='row'>
                            <div className='col-7'>
                                <Label label='Permanent/Provincial Address'/>
                            </div>

                            <div className='col-5'>
                                <Checkbox
                                    id='check_box'
                                    label='Same as Present Address'
                                    onChange={ e=>this.copyInput() }
                                />
                            </div>
                        </div>

                        <div className='row'>
                            <div className='col-12'>
                                <TextInput
                                    id='permanent_address'
                                    placeholder='Permanent/Provincial Address'
                                    value={ permanent_address }
                                    onChange={ e =>this.handleChange(e.target.value, 'permanent_address') }
                                    />
                            </div>
                        </div>
                    </div>

                    <div className="col-4">
                        <Select
                            id='permanent_city'
                            label='City'
                            optionValue='id'
                            errors={ errors }
                            options={ cities }
                            requiredfield={ 1 }
                            display='city_name'
                            selectValue={ permanent_city }
                            onChange={ e=>this.handleChange(e.target.value, 'permanent_city') }
                        />
                    </div>
                </div>
            </div>
        );
    }
}

export default connect(mapStateToProps)(Address);