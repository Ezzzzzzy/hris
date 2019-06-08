import React , { Component } from 'react';
import { 
	TextBox, 
	Select, 
	Label, 
	DatePicker 
} from '../../../../../../components';

const client = [
    { id: 1, name: 'SK' },
    { id: 2, name: 'WK' },
    { id: 3, name: 'BTBRS' },
    { id: 4, name: 'PG' },
    { id: 5, name: 'JFC' }
];
const branch = [
    { id: 1, name: 'Laguna' },
    { id: 2, name: 'Pasig' },
    { id: 3, name: 'Ortigas' },
    { id: 4, name: 'SanJuan' },
    { id: 5, name: 'Megamall LG, Pasig City' },
    { id: 6, name: 'Megamall GF, Pasig City' }
];
const brand = [
    { id: 1, name: 'Lenovo' },
    { id: 2, name: 'Acer' },
    { id: 3, name: 'Omega' },
    { id: 4, name: 'Alpha' },
    { id: 5, name: 'Chowking' },
    { id: 6, name: 'Jollibee' }
];
const position = [
    { id: 1, name: 'Staff' },
    { id: 2, name: 'Secretary' },
    { id: 3, name: 'Gradener' },
    { id: 4, name: 'Officer'},
    { id: 5, name: 'Sales Clerk' },
    { id: 6, name: 'Janitor' }
];
const status = [
    { id: 1, name: 'Pool' },
    { id: 2, name: 'Floating' },
    { id: 3, name: 'Endorsed' },
    { id: 4, name: 'Qualified' },
    { id: 5, name: 'Not Qualified' },
    { id: 6, name: 'Backed-out' },
    { id: 7, name: 'Training' },
    { id: 8, name: 'Probationary' },
    { id: 9, name: 'Seasonal' },
    { id: 10, name: 'Regular' },
    { id: 11, name: 'Event' },
    { id: 12, name: 'Weekender' },
    { id: 13, name: 'Part-timer' },
];

class NewDeployment extends Component{
    constructor(props) {
        super(props);
        this.state={
        }
    }

    render() {
        return (
            <div>
                <button className="deployment-btn" data-toggle="modal" data-target="#new-deployment">
                    <i className="fa fa-plus-circle fa-2x" aria-hidden="true"></i>
                </button>

                <div className="modal fade" id="new-deployment">
                    <div className="modal-dialog">
                        <div className="modal-content">
                            <div className="modal-header modal-header-color">
                                <h4 className="modal-title">{ ` Add New Deployment ` }</h4>
                                    <button 
                                    	type="button" 
                                    	className="close" 
                                    	data-dismiss="modal"
                                    >
                                    	&times;
                                    </button>
                            </div>
                            <div className="modal-body">
                                <div className="row">
                                    <div className="col-6 custm-card-labels">
                                        <Select
                                            id='id'
                                            label='Client'
                                            options={ client }
                                            optionValue={'name'}
                                            requiredfield={ 1 }
                                            display='name'
                                            selectValue={ 'name' }
                                            onChange={()=>console.log()}
                                        />
                                    </div>
                                    <div className="col-6 custm-card-labels">
                                        <Select
                                            id='id'
                                            label='Branch'
                                            options={ branch }
                                            optionValue={'name'}
                                            requiredfield={ 1 }
                                            display='name'
                                            selectValue={ 'name' }
                                            onChange={()=>console.log()}
                                        />
                                    </div>
                                </div>
                                <div className="row">
                                    <div className="col-6 mt-2 custm-card-labels">
                                        <Select
                                            id='id'
                                            label='Brand'
                                            options={ brand }
                                            optionValue={'name'}
                                            requiredfield={ 1 }
                                            display='name'
                                            selectValue={ 'name' }
                                            onChange={()=>console.log()}
                                        />
                                    </div>
                                    <div className="col-6 mt-2 custm-card-labels">
                                        <Select
                                            id='id'
                                            label='Position'
                                            optionValue={'name'}
                                            options={ position }
                                            requiredfield={ 1 }
                                            display='name'
                                            selectValue={ 'name' }
                                            onChange={()=>console.log()}
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
                                        />   
                                    </div>
                                    <div className="col-6 custm-card-labels">
                                        <Label label='End Date' />
                                        <DatePicker
                                            id={'date'}
                                            displayFormat="MMMM DD, YYYY"
                                            errors={[]}
                                        /> 
                                    </div>
                                </div>
                                <div className="row">
                                    <div className="col-6 mt-2 custm-card-labels">
                                        <Select
                                            id='id'
                                            label='New Status'
                                            options={ status }
                                            optionValue={'name'}
                                            requiredfield={ 1 }
                                            display='name'
                                            value={ 'name' }
                                            onChange={()=>console.log()}
                                        />
                                    </div>
                                </div>
                            </div>
                            <div className="modal-footer">
                                <button
                                    onClick={ ()=>this.addNewDeployment() }
                                    type="button"
                                    className="btn btn-success"
                                    data-dismiss="modal">
                                        { ` Add New Deployment ` }
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default NewDeployment;