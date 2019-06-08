import React, { Component } from 'react';
import ReactDOM from 'react-dom';

export default class HeaderBreadcrumbs extends Component {
    render() {
        return (
            <div>
                <ol className="breadcrumb">
                    <li className="breadcrumb-item"><a href="#">Members</a></li>
                    <li className="breadcrumb-item"><a href="#">Rubina Hammond</a></li>
                    <li className="breadcrumb-item active"><b>Deployment Details</b></li>
                </ol>
            </div>      
        );
    }
}