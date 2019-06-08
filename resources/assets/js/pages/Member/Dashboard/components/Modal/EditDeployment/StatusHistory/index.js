import React, { Component } from 'react';
import EditDeployment from '../../EditDeployment';
import {  
    TextBox,
    Select,
    Label,
    DatePicker
} from '../../../../../../../components';

const statuses = [
    { id: 1, status: 'Pool' },
    { id: 2, status: 'Floating' },
    { id: 3, status: 'Endorsed' },
    { id: 4, status: 'Qualified' },
    { id: 5, status: 'Not Qualified' },
    { id: 6, status: 'Backed-out' },
    { id: 7, status: 'Training' },
    { id: 8, status: 'Probationary' },
    { id: 9, status: 'Seasonal' },
    { id: 10, status: 'Regular' },
    { id: 11, status: 'Event' },
    { id: 12, status: 'Weekender' },
    { id: 13, status: 'Part-timer' },
];

const StatusHistory = (props) => {
    return (
        <div className="row">
            <div className="col-4">
                <Label 
                    label='Start Date' 
                    requiredfield={1} 
                    className="label-modal-dashboard" 
                />
                <DatePicker
                    id='start_date'
                    name="start_date"
                    errors={[]}
                />
            </div>
            <div className="col-4">
                <Label 
                    label='End Date' 
                    requiredfield={1} 
                    className="label-modal-dashboard" 
                />
                <DatePicker
                    id='end_date'
                    name="end_date"
                    errors={[]}
                />
            </div>
            <div className="col-3">
                <Label 
                    label='New Status' 
                    requiredfield={1} 
                    className="label-modal-dashboard" 
                />
                <Select
                    name='add_new_status'
                    id='add_new_status'
                    display='status'
                    options={statuses}
                    requiredfield="true"
                    onChange={()=>console.log()}
                />
            </div>
            <div className="col-1">
                <button 
                    className="remove-btn pointer"
                >
                    {`x`}
                </button>
            </div>
        </div>
    );
}

export default StatusHistory;