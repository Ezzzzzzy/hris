import React from 'react';

/**
 * Display Add New CLient Modal
 * 
 * @param object props
 * @param function onClick
 */

const Add = (props) => {
    return(
        <div 
            className="modal fade" 
            id="add-new-client-modal"
            tabIndex="-1"
            role="dialog"
            aria-labelledby="add-new-client-modal"    
        >
            <div className="modal-dialog" role="document">
                <div className="modal-content">
                    <div className="modal-header header-primary">
                        <p className="modal-title">Add New Client</p>
                        <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div className="modal-body">
                        <form className="modal-container">
                            <div className="form-group">
                                <label htmlFor="company-name" className="col-form-label">Company Name</label>
                                <input 
                                    type="text" 
                                    className="form-control" 
                                    id="company-name" 
                                />
                            </div>
                            <div className="form-group">
                                <label htmlFor="shortcode" className="col-form-label">Shortcode</label>
                                <input 
                                    type="text" 
                                    className="form-control" 
                                    id="shortcode" 
                                />
                            </div>
                        </form>
                    </div>
                    <div className="modal-footer">
                        <button 
                            type="button" 
                            className="btn btn-success btn-block"
                            onClick={() => console.log("Button Clicked")}
                        >
                            Add New Client
                        </button>
                    </div>
                </div>
            </div>
        </div>
    )
}

export default Add;