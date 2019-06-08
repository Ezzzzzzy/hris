import React, { Component } from 'react';
import Card from './Card';
import { AddDeployment } from '../../Modal';

const EmptyDetails = (props)=> {
    return (
        <div className="row">
            <div className="col-12">
                { ` Deployment Details are Empty! ` }
            </div>
        </div>
    );
}

const Timeline = (props) => {
    let data = props.data;
    let last = data.length-1;
    return (
        <div className="col-6">
            <div className="deployment-details"> { ` Deployment Details ` } </div>
            <div className="row deployment-margin-btn new-deployment-line">
                <div className="col-1"> 
                    <AddDeployment />          
                </div>
                <span 
                    className="new-deployment-text" 
                    data-target="#new-deployment" 
                    data-toggle="modal" 
                > 
                    {`  New deployment ` } 
                </span>
            </div>
            {
                props.data.length !== 0
                ?   props.data.map((val,i) => {
                        return (
                            <Card 
                                key={ i }
                                data={ val }
                                index={ i }
                                last={ last } 
                            />
                        );
                    })
                :   <EmptyDetails />
            }
        </div>
    );
}

export default Timeline;