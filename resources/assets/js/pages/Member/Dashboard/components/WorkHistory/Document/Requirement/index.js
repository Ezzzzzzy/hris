import React, { Component } from 'react';
import { Select, TextInput } from '../../../../../../../components';

const documents = [
    { id: 0, type: 'ALL TYPES' },
    { id: 1, type: 'Copy of Birth Certificate' },
    { id: 2, type: 'Copy of SSS digitized ID/E1 Form' },
    { id: 3, type: 'Copy of Tax Identification Number (TIN) ID' },
    { id: 4, type: 'Copy of Philhealth Number' },
    { id: 5, type: 'Copy of Pagibig Number' },
    { id: 6, type: 'Copy of Work Permit/Employment Certificate' },
    { id: 7, type: 'Copy of NBI Clearance' },
    { id: 8, type: 'Copy of Health Certificate and Medical Clearance' },
    { id: 9, type: '2pcs 2x2' },
    { id: 10, type: '2pcs 1x1' },
];

class Requirements extends Component {
    constructor(props) {
        super(props);
    
        this.state = {
            data :[],
            filter: 'ALL TYPES',
            name: [],
            search: '',
            term:''
        };
    };

    render() {
        return (
            <div 
                className="tab-pane fade show active row" 
                id="nav-requirements" 
                role="tabpanel"
            >
                <div className="row">
                    <div className="col-6">
                        <div className="input-group requirements">
                            <input 
                                type="text" 
                                className="form-control search-requirements" 
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
                    <div className="col-3 select-requirements">
                        <Select
                            id='id'
                            options={ documents }
                            optionValue={'type'}
                            display='type'
                            value={'type'}
                        />
                    </div>
                </div>
                <div className={"row uploaded-file-requirements " + `${ this.props.requirement.length > 11 ? 'overflow' : '' }` } id="scroll" >
                    <div className="col-12">
                        <ul className="file-requirements">
                           {   
                                this.props.requirement.length !== 0 
                                ?   this.props.requirement.map((val,i)=>{
                                        return (
                                            val.type !== 0
                                            ?   <li key={i} className="row-requirements" >
                                                    <i className="far fa-file-pdf color-red"></i>
                                                        <span className="file-text">
                                                            { `  ${val.document_name}` } 
                                                        </span>
                                                        <span className="pull-right text-requirement"> 
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

export default Requirements;
