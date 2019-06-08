import React from 'react';
import { Blockquote, TextInput, Select } from '../../../../../../components';

const familyType =[ 
    { id: 1, name: 'Son' },
    { id: 2, name: 'Mother' },
    { id: 3, name: 'Father'},
    { id: 4, name: 'Daughter'},
    { id: 5, name: 'Grandmother'},
    { id: 6, name: 'Grandfather'}
]

const Background = (props) => {
    return (
        <div className="row">
            <Blockquote 
                title='Family Background'
                subtitle='Mother Required'
                id='fam_bg_id'
            />

            <div className="col-6">
                <div className="form-group row custm-TextInput-align-body">
                    <div className="col-3">
                        <Select
                            label='Type'
                            options={ familyType }
                            optionsValue='name'
                            display='name'
                            requiredfield="true"
                            onChange={ e=>props.familyChange(e.target.value, 'family_type') }
                        />
                    </div>

                    <div className="col-3">
                        <TextInput 
                            label={'Name'}
                            value={props.data.name}
                            requiredfield="true"
                            onChange={ e=>props.familyChange(e.target.value, 'name') }
                        />
                    </div>

                    <div className="col-3">
                        <TextInput 
                            label={'Age'}
                            value={props.data.age}
                            onChange={ e=>props.familyChange(e.target.value, 'age') }
                        />
                    </div>

                    <div className="col-3">
                        <TextInput 
                            label={'Company/Occupation'}
                            value={props.data.occupation}
                            onChange={ e=>props.familyChange(e.target.value, 'occupation') }
                        />
                    </div>
                </div>

                <br/>

                <div align="right">
                    <button 
                        type="button"
                        disabled={ props.disable } 
                        className="btn btn-sm btn-primary"
                        onClick={ props.addFamily }
                    >
                        <i className="fas fa-plus fa-fw"></i>
                        &nbsp;Add Family Member
                    </button>
                </div>
            </div>
            </div>
    );
}

export default Background;