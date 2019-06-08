import React, { Component } from 'react';

const Breadcrumbs = (props) => {
    let { page, firstname, lastname, label } = props  
    return (
        <div>
            <ol className="breadcrumb">
                <li className="breadcrumb-item"><a href="#">{ page }</a></li>
                <li className="breadcrumb-item"><a href="#">{ `${firstname} ${lastname}` }</a></li>
                <li className="breadcrumb-item active-text-bold">{ label }</li>
            </ol>
        </div>      
    );
}

export default Breadcrumbs;
