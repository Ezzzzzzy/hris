import React, { Component } from 'react';
import '../../style.css';

const Header = (props) => {
    let first_name = props.data.first_name;
    let middle_initial = props.data.middle_name[0];
    let last_name = props.data.last_name;
    let extension_name = props.data.extension_name ? ', ' + props.data.extension_name : '';
    return (
        <div className="card card-deployment header-deployment" >
            <div id="header-all" className="container-fluid">
                <div id="header-upper-part" className="row justify-content-between">
                    <div className="col-md-6">
                        <span id="header-text-deployment">
                            Member -    {first_name + ' ' + middle_initial + '. ' + last_name + extension_name}
                        </span>
                    </div>
                    <div className="col-md-auto">
                        <button type="button" className="btn btn-sm btn-success custm-btn-division">
                            <i className="fa fa-cloud-download-alt custm-btn-icons"></i>
                            {` Download Profile`}
                        </button>
                        <button type="button" className="btn btn-sm btn-success custm-btn-division">
                            <i className="fa fa-cloud-download-alt custm-btn-icons"></i>
                            {` Profile`}
                        </button>
                        <button type="button" className="btn btn-sm btn-success custm-btn-division">
                            <i className="fa fa-edit custm-btn-icons"></i>
                            {` Edit Profile`}
                        </button>
                    </div>
                </div>
                <hr />
                <ul className="nav" id="nav-deployment">
                    <li className="nav-item"><a className="nav-link" href="#">Dashboard</a></li>
                    <li className="nav-item"><a className="nav-link active" href="#">Deployment Details</a></li>
                    <li className="nav-item"><a className="nav-link " href="#">Complete Profile</a></li>
                    <span className="custm-appli-status-inc ml-auto"><i className="fa fa-exclamation-circle fa-fw"></i>Incomplete Application</span>
                </ul>
            </div>
        </div>
    );

}

export default Header;