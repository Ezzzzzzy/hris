import React, { Component } from 'react';
import { Select, TextInput } from '../../../../../../../components';

const documents = [
    { id: 0, type: 'ALL TYPES' },
    { id: 1, type: 'Declaration of Good Health' },
    { id: 2, type: 'Insular Life Form' },
    { id: 3, type: 'PMRF' },
    { id: 4, type: 'MDF' },
    { id: 5, type: 'Membership Application' },
    { id: 6, type: 'File Endorsement (MOA)' },
    { id: 7, type: 'Authority to Deduct' },
    { id: 8, type: 'Requirements Waiver' },
    { id: 9, type: 'Assignment Confirmation' },
    { id: 10, type: 'Membership Agreement' },
    { id: 11, type: 'Employment Contract' },
    { id: 12, type: 'Auto Debit Agreement' },
    { id: 13, type: 'Data Privacy Act' },
    { id: 14, type: 'Others (Laptop, Policy, etc.)' }
];

class Contract extends Component {
    constructor(props) {
        super(props);

        this.state = {
            data: {},
            filter: 'ALL TYPES',
            term:''
        };
    }

    render() {
        return  (
            <div 
                className="tab-pane fade" 
                id="nav-contracts" 
                role="tabpanel"
            >
                <div className="row">
                    <div className="col-6">
                        <div className="input-group contracts">
                            <input 
                                type="text" 
                                className="form-control search-contracts" 
                                placeholder=" Search file name"      
                            />
                            <div className="input-group-append">
                                <button
                                    type="submit"
                                    className="btn-search btn-background"
                                >
                                    <i className="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div className="col-3 select-contracts">
                        <Select
                            id='id'
                            options={ documents }
                            optionValue={'type'}
                            display='type'
                            value={'type'}
                        />
                    </div>
                </div>
                <div className={"row uploaded-file-contracts " + `${ this.props.requirement.length > 11 ? 'overflow' : '' }` } id="scroll">
                    <div className="col-12">
                        <ul className="file-contracts">
                            {   
                                this.props.requirement.length !== 0 
                                ?   this.props.requirement.map((val,i)=>{
                                        return (
                                            val.type !== 1
                                            ?   <li key={i} className="row-contracts" >
                                                    <i className="far fa-file-pdf color-red"></i>
                                                        <span className="file-text">
                                                            { `  ${val.document_name}` } 
                                                        </span>
                                                        <span className="pull-right text-contract"> 
                                                            { val.document_type } { ` | ` } { val.date }
                                                        </span>
                                                    <hr />
                                                </li>
                                            :   ''
                                        );
                                    })
                                :   'No Existing Requirements'
                            }
                        </ul>
                    </div>
                </div>
            </div>
        );
    }
}

export default Contract;
