import React, { Component } from 'react';
import Requirement from './Requirement';
import Contract from './Contract';

const Document = (props) => {
    return (
        <div className="col-5 document-tabs">
            <div className="row ">
                <nav>
                    <div className="nav nav-tabs" id="nav-tab" role="tablist">
                        <a 
                            className="nav-item nav-link active" 
                            id="nav-requirements-tab" 
                            data-toggle="tab" 
                            href="#nav-requirements" 
                            role="tab"  
                            aria-selected="true"
                        >
                            { ` Requirements ` }
                        </a>
                        <a 
                            className="nav-item nav-link" 
                            id="nav-contracts-tab" 
                            data-toggle="tab" 
                            href="#nav-contracts" 
                            role="tab"  
                            aria-selected="false"
                        >
                            { ` Contracts ` }
                        </a>
                        <div className="upload-button">
                            <button type="button" className="btn btn-md btn-primary">
                                <i className="fa fa-upload"></i>
                                { ` Upload File ` }
                            </button>
                        </div>
                    </div>
                </nav>
                <div className="tab-content" id="nav-tabContent">
                    <Requirement requirement={ props.documents } />
                    <Contract requirement={ props.documents } />
                </div>
            </div>
        </div>
    );
}

export default Document;
