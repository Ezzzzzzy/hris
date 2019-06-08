import React from 'react';
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
			<div className="col-4">
				<div className="row">
					<div className="col-6">
						<Select
							id={'status'}
							optionValue={'value'}
							options={status}
							display={'display'}
							value={'value'}
						/>
					</div>
				</div>
			</div>
			<div className="col-8 btn-block">
				<div className="row menu-filter-right">
					<div className="col-7 search-input-menu">
						<input
							className="form-control search-input"
							placeholder="Search by Tenure or ID"
						/>
					</div>
					<div className="col-1 search-input-menu">
						<button className="btn search-button" type="submit">
							<i className="fa fa-search" />
						</button>
					</div>
					<div className="col-4">
						<button
							className="btn btn-success add-btn-settings"
							data-toggle="modal"
							data-target="#1"
						>
							<span className="fa fa-plus" />
							{` New Range `}
						</button>
					</div>
				</div>
			</div>
		</div>
	);
}

export default Menu;