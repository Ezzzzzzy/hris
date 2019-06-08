import React, { Component } from 'react';
import ReactDOM from 'react-dom';

const Header = () => {
    return (
        <div>
            <div id="header-all" className="container-fluid">
                <div id="header-upper-part" className="row justify-content-between">
                    <div className="col-md-auto">
                        <span id="header-text">Member - Rubina B. Hammond Jr.</span>
                    </div>
                    <div className="col-md-auto">
                        <button type="button" className="btn btn-sm btn-success custm-btn-division"><i className="fas fa-cloud-download-alt fa-fw custm-btn-icons"></i>&nbsp;Download Profile</button>
                        <button type="button" className="btn btn-sm btn-success custm-btn-division"><i className="fas fa-edit fa-fw custm-btn-icons"></i>&nbsp;Edit Profile</button>
                    </div>  
                </div>
              <hr/>

                <ul className="nav">
                    <li className="nav-item"><a className="nav-link" href="#">Dashboard</a></li>
                    <li className="nav-item"><a className="nav-link" href="#">Deployment Details</a></li>
                    <li className="nav-item"><a className="nav-link active" href="#">Complete Profile</a></li>
                    <span className="custm-appli-status-inc ml-auto"><i className="fas fa-exclamation-circle fa-fw"></i>Incomplete Application</span>
                </ul>
            </div>
        </div>      
    );
}

export default Header;