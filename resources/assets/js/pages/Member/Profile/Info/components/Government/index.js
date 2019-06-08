import React from 'react';
import { Blockquote, TextInput } from '../../../../../../components';

const Government = (props) => {    
    return (
        <div className="row">
            <Blockquote title='Government Mandated Numbers' id='gov_mandated_id' />

            <div className="col-6">
                <div className="card card-body custm-card-margin">
                    <div className="form-group row">
                        <div className='col-6'>
                            <TextInput 
                                label='SSS Number'
                                placeholder={ props.data.sss_num }
                                disabled='true'
                            />
                        </div>

                        <div className='col-6'>
                            <TextInput 
                                label='Pagibig Number'
                                placeholder={ props.data.pag_ibig_num }
                                disabled='true'
                            />
                        </div>
                    </div>

                    <div className="form-group row">
                        <div className='col-6'>
                            <TextInput 
                                label='Philhealth Number'
                                placeholder={ props.data.philhealth_num }
                                disabled='true'
                            />
                        </div>

                        <div className='col-6'>
                            <TextInput 
                                label='TIN Number'
                                placeholder={ props.data.tin }
                                disabled='true'
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}

export default Government;