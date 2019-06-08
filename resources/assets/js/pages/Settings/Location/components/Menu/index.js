import React, { Component } from 'react';
import { 
	Select, 
	TextInput, 
	Label 
} from '../../../../../components';

const status = [
	{ value: '0', display: 'All' },
	{ value: '1', display: 'All Enabled' },
	{ value: '2', display: 'All Disabled' }
];

const sort = [
	{ value: '0', display: 'ID' },
	{ value: '1', display: 'Status Name' },
	{ value: '2', display: 'Type' },
	{ value: '2', display: 'Modified' },
	{ value: '2', display: 'Order' },
	{ value: '2', display: 'Status' }
]

const Menu = () => {
	return (
		<div className="row menu-filter">
			<div className="col-7">	
				<div className="row">
					<div className="col-3">
					   <Select 
							id={'status'}
							optionValue={ 'value' }
							options={ status }
							display={ 'display' }
							value={ 'value' }
						/>
					</div>
					<div className="col-3">
					   <Select 
							id={'status'}
							optionValue={ 'value' }
							options={ status }
							display={ 'display' }
							value={ 'value' }
						/>
					</div>
					<div className="col-3">
					   <Select 
							id={'status'}
							optionValue={ 'value' }
							options={ status }
							display={ 'display' }
							value={ 'value' }
						/>
					</div>
				</div>
			</div>
			<div className="col-5">
				<div className="row margin-right-search">
					<div className="col-11 search-input-menu">
                        <input
                            className="form-control search-input"
                            placeholder="Search by Location Name or ID, City, Region"
                        />
                    </div>
                    <div className="col-1 search-input-menu">
                        <button className="btn search-button" type="submit">
                            <i className="fa fa-search" />
                        </button>
                    </div>
				</div>
	        </div>
		</div>
	);
}

export default Menu;