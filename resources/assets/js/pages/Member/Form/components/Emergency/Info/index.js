import React from 'react';
import { Blockquote, TextInput } from '../../../../../../components';

const Info = (props) => {
    return (
        <div className="row">
            <Blockquote
                title='In Case of Emergency'
                subtitle='add at least one emergency contact'
                id='emergency_id'
            />

            <div className="col-6">
                <div className="form-group row custm-TextInput-align-body">
                    <div className="col-4">
                        <TextInput
                            label={'Name'}
                            value={props.data.name}
                            requiredfield="true"
                            onChange={ e=>props.contactChange(e.target.value, 'name') }
                        />
                    </div>

                    <div className="col-4">
                        <TextInput
                            label={'Relationship'}
                            value={props.data.relationship}
                            requiredfield="true"
                            onChange={ e=>props.contactChange(e.target.value, 'relationship') }
                        />
                    </div>

                    <div className="col-4">
                        <TextInput
                            label={'Contact Number'}
                            requiredfield="true"
                            value={ props.data.contact }
                            requiredfield="true"
                            onChange={ e=>props.contactChange(e.target.value, 'contact') }
                        />
                    </div>
                </div>

                <div className="row">
                    <div className="col-12">
                        <TextInput
                            label={'Address'}
                            value={props.data.address}
                            requiredfield="true"
                            onChange={ e=>props.contactChange(e.target.value, 'address') }
                        />
                    </div>
                </div>
              <br />
                <div align="right">
                    <button
                        type="button"
                        className="btn btn-sm btn-primary"
                        disabled={ props.disable }
                        onClick={ props.addContact }
                    >
                        <i className="fas fa-plus fa-fw"></i>
                        &nbsp;Add Emergency Contact
                    </button>
                </div>
            </div>
        </div>
    );
}

export default Info;