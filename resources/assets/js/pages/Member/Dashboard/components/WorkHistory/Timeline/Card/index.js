import React, { Component } from 'react';
import { EditDeployment, EndDeployment } from '../../../Modal';

const ActiveCircle = (props) => {
    let index = props.index;
    let last = props.last;
    return (
        <div className="timeline-pointer-margin">
            {   
                props.data.date_end.length === 0
                ?  <span className={ index === last ? 'timeline-point-green' : 'timeline-point-green time-line' }></span>
                :  <span className={ index === last ? 'timeline-point-gray'  : 'timeline-point-gray time-line' }></span>
            }  
        </div>           
    );
}

const Card = (props) => {
    return (
        <div className="row">  
            <div className="col-2">
                <div className="row">
                    <span className="client-code-text pull-right">
                        { props.data.client }
                    <br />
                    </span>
                </div>
                <div className="row">
                    <small className="client-name-text"> { ` Jollibee Food Corp ` } </small>
                </div>
            </div>

            <ActiveCircle 
                last={ props.last } 
                index={ props.index }
                data={ props.data }
            />

            <div className="col-10">
                <div className="row">
                    <div className="col-12 card-container-dashboard">
                        <div className="row line-height">
                            <div className="col-md-6">
                                <span className="position-text"> 
                                    { props.data.position } 
                                </span>
                            </div>
                            <div className="col-6">
                                <span className="pull-right date-text">
                                    { ` Dec. 20, 2017 - Present ` }
                                </span>
                            </div>
                        </div>
                        <div className="row line-height">
                            <div className="col-6">
                                <span className="card-text">
                                    { props.data.branch }
                                </span>
                            </div>
                            <div className="col-6">
                                <span className={ "pull-right time-difference-text " + `${ props.data.date_end.length === 0 && 'tenure-text' }` }>
                                    { props.data.tenure }
                                </span>
                            </div>
                        </div>
                        <div className="row brand-line-height">
                            <div className="col-6">
                                <span className="card-text">
                                    { props.data.brand }
                                </span>
                            </div>
                        </div>
                        <div className="row da-line-height">
                            <div className="col-6">
                                <span className="status-text">
                                    { props.data.status } 
                                </span>
                            </div>
                            <div className="col-6">
                                <div className="pull-right">
                                    <EditDeployment />
                                </div>
                                <div className="pull-right">
                                    <EndDeployment />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Card;