import React, { Component } from 'react';
import { 
    Select, 
    TextInput, 
    Label 
} from '../../../../../../components';

const EditStatus = (props) => {
    return(
        <div className="col-3">
            <button
                className="modal-button color-light-gray"
                data-toggle="modal"
                data-target="#2"
            >
                <span className="fa fa-edit" />
                &nbsp; Edit
            </button>
            <div
                className="modal fade"
                id="2"
                tabIndex="-1"
                role="dialog"
                aria-hidden="true"
            >
                <div className="modal-dialog modal-dialog-centered" role="document">
                    <div className="modal-content custom-modal-width">
                        <div className="modal-header modal-header-color">
                            <h5 className="modal-title" id="1">
                                Edit Document Type
                            </h5>
                            <button
                                type="button"
                                className="btn-close"
                                data-dismiss="modal"
                                aria-label="Close"
                            >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div className="modal-body modal-margin">
                                <div className="row field-modal-margin">
                                    <div className="col-12">
                                        <TextInput
                                            label={"Document Name"}
                                        />
                                    </div>
                                </div>
                                <div className="row field-modal-margin">
                                    <div className="col-6">
                                        <TextInput
                                            label={"Type"} 
                                        />
                                    </div>
                                    <div className="col-6">
                                        <TextInput
                                            label={"Order"} 
                                        />
                                    </div>
                                </div>
                                <div className="row field-modal-margin">
                                    <div className="col-12">
                                        <Select 
                                            label={"Status"}
                                        />
                                    </div>
                                </div>
                        </div>
                        <div className="modal-footer modal-margin">
                            <button 
                                type="button" 
                                className="btn btn-success btn-block"
                                data-dismiss="modal"
                            >
                                Update
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}

export default EditStatus;