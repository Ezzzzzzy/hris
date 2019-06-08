import React from 'react';
import { Blockquote, TextInput } from '../../../../../../components';

const Info = (props) => {
    return (
        <div className="row">
            <Blockquote 
                title={'Character Reference'}
                subtitle={'add at least one character reference'}
                id={'char_reference_id'}
            />

            <div className="col-6">
                <div className="form-group row custm-TextInput-align-body">
                    <div className="col-4">
                        <TextInput 
                            label={'Name'}
                            value={props.data.name}
                            requiredfield="true"
                            onChange={ e=>props.referenceChange(e.target.value, 'name') }
                        />
                    </div>

                    <div className="col-4">
                        <TextInput 
                            label={'Company'}
                            value={props.data.company}
                            requiredfield="true"
                            onChange={ e=>props.referenceChange(e.target.value, 'company') }
                        />
                    </div>

                    <div className="col-4">
                        <TextInput
                            label={'Position'}
                            value={props.data.position}
                            requiredfield="true"
                            onChange={ e=>props.referenceChange(e.target.value, 'position') }
                        />
                    </div>
                </div>

                <div className="form-group row">
                    <div className="col-8">
                        <TextInput
                            label={'Address'}
                            value={props.data.address}
                            onChange={ e=>props.referenceChange(e.target.value, 'address') }
                        />
                    </div>

                    <div className="col-4">
                        <TextInput
                            label={'Contact Number'}
                            value={props.data.contact}
                            requiredfield="true"
                            onChange={ e=>props.referenceChange(e.target.value, 'contact') }
                        />
                    </div>         
                </div>

                <br/>

                <div align="right">
                    <button 
                        type="button" 
                        className="btn btn-sm btn-primary"
                        onClick={ props.addReference }
                        disabled={ props.disable }
                    >
                        <i className="fas fa-plus fa-fw"></i>
                        &nbsp;Add Character Reference
                    </button>
                </div>
            </div>
        </div>
    );
}

export default Info;