import React, { Component } from 'react';
import Timeline from './Timeline';
import Document from './Document';

class WorkHistory extends Component {
    constructor(props) {
        super(props);
    
        this.state = {
            data: [
                {
                    client: 'JFC',
                    brand: 'Jollibee',
                    branch: 'Megamall GF, Pasig City',
                    position: 'Sales Worker',
                    status: 'Pending DA',
                    date_start: '',
                    date_end: '',
                    tenure: '2 Years and 3 Months'
                },
                {
                    client: 'KPL',
                    brand: 'Chowking',
                    branch: 'Greenhills, San Juan City',
                    position: 'Janitor',
                    status: '',
                    date_start: '',
                    date_end: '1',
                    tenure: '1 year'
                },
                {
                    client: 'PG',
                    brand: 'Chowking',
                    branch: 'Greenhills, San Juan City',
                    position: 'Janitor',
                    status: '',
                    date_start: '',
                    date_end: '1',
                    tenure: '1 year'
                },
            ],
            documents: [
                {
                    type: 1,
                    document_name: 'Sample_Document1.pdf',
                    document_type: 'Clearance',
                    date: '10/20/2017'
                },
                {
                    type: 0,
                    document_name: 'Sample_Document2.pdf',
                    document_type: 'Clearance',
                    date: '10/20/2017'
                },
                {
                    type: 1,
                    document_name: 'Sample_Document3.pdf',
                    document_type: 'Clearance',
                    date: '10/20/2017'
                },
                {
                    type: 1,
                    document_name: 'Sample_Document3.pdf',
                    document_type: 'Clearance',
                    date: '10/20/2017'
                },
                {
                    type: 1,
                    document_name: 'Sample_Document3.pdf',
                    document_type: 'Clearance',
                    date: '10/20/2017'
                },
                {
                    type: 1,
                    document_name: 'Sample_Document3.pdf',
                    document_type: 'Clearance',
                    date: '10/20/2017'
                },
                {
                    type: 1,
                    document_name: 'Sample_Document3.pdf',
                    document_type: 'Clearance',
                    date: '10/20/2017'
                },
                {
                    type: 1,
                    document_name: 'Sample_Document3.pdf',
                    document_type: 'Clearance',
                    date: '10/20/2017'
                },
                {
                    type: 1,
                    document_name: 'Sample_Document3.pdf',
                    document_type: 'Clearance',
                    date: '10/20/2017'
                },
                {
                    type: 1,
                    document_name: 'Sample_Document3.pdf',
                    document_type: 'Clearance',
                    date: '10/20/2017'
                },
               
                {
                    type: 0,
                    document_name: 'Sample_Document2.pdf',
                    document_type: 'Clearance',
                    date: '10/20/2017'
                },
                {
                    type: 0,
                    document_name: 'Sample_Document2.pdf',
                    document_type: 'Clearance',
                    date: '10/20/2017'
                },
                {
                    type: 0,
                    document_name: 'Sample_Document2.pdf',
                    document_type: 'Clearance',
                    date: '10/20/2017'
                },
                {
                    type: 0,
                    document_name: 'Sample_Document2.pdf',
                    document_type: 'Clearance',
                    date: '10/20/2017'
                },
                {
                    type: 0,
                    document_name: 'Sample_Document2.pdf',
                    document_type: 'Clearance',
                    date: '10/20/2017'
                },
                {
                    type: 0,
                    document_name: 'Sample_Document2.pdf',
                    document_type: 'Clearance',
                    date: '10/20/2017'
                },
                {
                    type: 0,
                    document_name: 'Sample_Document2.pdf',
                    document_type: 'Clearance',
                    date: '10/20/2017'
                },
                {
                    type: 0,
                    document_name: 'Sample_Document2.pdf',
                    document_type: 'Clearance',
                    date: '10/20/2017'
                },
                {
                    type: 0,
                    document_name: 'Sample_Document2.pdf',
                    document_type: 'Clearance',
                    date: '10/20/2017'
                },
            ]    
        };
    }

    render() {
        return (
            <div className="row justify-content-center">
                <div className="col-10">
                    <div className="row">
                        <Timeline data={ this.state.data } />
                        <Document documents={ this.state.documents } />
                    </div>
                </div>
            </div>
        );
    }
}

export default WorkHistory;
