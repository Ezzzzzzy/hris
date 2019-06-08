import React , { Component } from 'react';
import ReactTooltip from 'react-tooltip';
import { TextBox,
         Select,
         Label,
         DatePicker } from '../../../../../../components';

const clients = [
    { id: 1, name: 'Daryl' },
    { id: 2, name: 'Em' },
    { id: 3, name: 'Neil' },
    { id: 4, name: 'Nards' },
    { id: 5, name: 'JFC' }
];
const branches = [
    { id: 1, branch: 'Laguna' },
    { id: 2, branch: 'Pasig' },
    { id: 3, branch: 'Ortigas' },
    { id: 4, branch: 'SanJuan' },
    { id: 5, branch: 'Megamall LG, Pasig City' },
    { id: 6, branch: 'Megamall GF, Pasig City' }
];
const brands = [
    { id: 1, brand: 'Lenovo' },
    { id: 2, brand: 'Acer' },
    { id: 3, brand: 'Omega' },
    { id: 4, brand: 'Alpha' },
    { id: 5, brand: 'Chowking' },
    { id: 6, brand: 'Jollibee' }
];
const positions = [
    { id: 1, position: 'Staff' },
    { id: 2, position: 'Secretary' },
    { id: 3, position: 'Gradener' },
    { id: 4, position: 'Officer'},
    { id: 5, position: 'Sales Clerk' },
    { id: 6, position: 'Janitor' }
];
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

class NewDeployment extends Component{
    constructor(props) {
        super(props);
        this.state={
            data: {
                client: '',
                branch: '',
                brand: '',
                position: '',
                date_start: '',     
                date_end: '',
                new_status: '',
                reason: '',
                remarks: '',
                status_list: [],
                disciplinary_action: []
            },
        }
    }
             
    deploymentChange(val,propName){
        let data = Object.assign({}, this.state.data);
        data[propName] = val;
        this.setState({ data });    
    }

    dateChange(jsDate,propName){
        let day  = jsDate.getDate();
            if(day < 10) day = "0"+day
        let month = jsDate.getMonth();
        let mlist = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec" ];
        let year  = jsDate.getUTCFullYear();
        let date = mlist[month] + ' ' + day + ', ' + year;
        let data = Object.assign({}, this.state.data);
        data[propName] = date
        this.setState ({ data })
    }

    render(){
        return (
            <div className="row">
                <div className="col-12"> 
                    <button 
                        id={ (this.props.deployed) ? "new-deployment-button-disabled" : null }
                        className="btn btn-sm btn-primary btn-adjust-position-deployment" 
                        data-toggle="modal" 
                        data-target={(this.props.deployed) ? null : "#new-deployment"}
                        data-tip={(this.props.deployed) ? "End Current Job First" : null }
                    >   
                        <ReactTooltip place="top" type="dark" effect="solid" disabled="true"/>
                        <i className="fa fa-plus fa-fw custm-btn-icons custm-btn-names"></i>
                        { ` New Deployment` }
                    </button>
                    <div className="modal fade" id="new-deployment">
                        <div className="modal-dialog custm-modal-new-width-deployment">
                            <div className="modal-content">
                                <div className="modal-header modal-header-color-deployment">
                                    <h4 className="modal-title">Add New Deployment</h4>
                                    <button type="button" className="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div className="modal-body">
                                    <div className="row">
                                        <div className="col-6 custm-card-labels">
                                            <Select
                                                id='id'
                                                label='Client'
                                                optionValue={'name'}
                                                options={ clients }
                                                requiredfield={ 1 }
                                                display='name'
                                                value={'name'}
                                                onChange={ e=>this.deploymentChange(e.target.value, 'client') }
                                            />
                                        </div>
                                        <div className="col-6 custm-card-labels">
                                            <Select
                                                id='id'
                                                label='Branch'
                                                options={ branches }
                                                optionValue={'branch'}
                                                requiredfield={ 1 }
                                                display='branch'
                                                value={'branch'}
                                                onChange={ e=>this.deploymentChange(e.target.value, 'branch') }
                                            />
                                        </div>
                                    </div>
                                    <div className="row">
                                        <div className="col-6 mt-2 custm-card-labels">
                                            <Select
                                                id='id'
                                                label='Brand'
                                                optionValue={'brand'}
                                                options={ brands }
                                                requiredfield={ 1 }
                                                display='brand'
                                                value={'brand'}
                                                onChange={ e=>this.deploymentChange(e.target.value, 'brand') }
                                            />
                                        </div>
                                        <div className="col-6 mt-2 custm-card-labels">
                                            <Select
                                                id='id'
                                                label='Position'
                                                optionValue={'position'}
                                                options={ positions }
                                                requiredfield={ 1 }
                                                display='position'
                                                value={'position'}
                                                onChange={ e=>this.deploymentChange(e.target.value, 'position') }
                                            />
                                        </div>
                                    </div>
                                    <hr/>
                                    <div className="row">
                                        <div className="col-6 custm-card-labels">
                                            <Label  label='Start Date' requiredfield={ 1 } />
                                            <DatePicker
                                                id={'date'}
                                                displayFormat="MMMM DD, YYYY"
                                                errors={[]}
                                                onChange={date => this.dateChange(date, 'date_start')}
                                            />   
                                        </div>
                                        <div className="col-6 custm-card-labels">
                                            <Label label='End Date' />
                                            <DatePicker
                                                id={'date'}
                                                displayFormat="MMMM DD, YYYY"
                                                errors={[]}
                                                onChange={date => this.dateChange(date, 'date_start')}
                                            /> 
                                        </div>
                                    </div>
                                    <div className="row">
                                        <div className="col-6 mt-2 custm-card-labels">
                                            <Select
                                                id='id'
                                                label='New Status'
                                                optionValue={'status'}
                                                options={ statuses }
                                                requiredfield={ 1 }
                                                display='status'
                                                value={'status'}
                                                onChange={ e=>this.deploymentChange(e.target.value, 'new_status') }
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div className="modal-footer">
                                    <button
                                        type="button"
                                        className="btn btn-success"
                                        data-dismiss="modal"
                                    >
                                        { ` Add New Deployment` }
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default NewDeployment;