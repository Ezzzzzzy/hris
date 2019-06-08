import React, { Component } from 'react';
import { Table, Menu } from '../../components';
import { Label } from '../../../../../components';

const Details = (props) => {
	return(
		<div className="col-12 table-card">
			<div className="row">
				<div className="col-8">
					<h3><Label label={'Manage Branch Locations'} /></h3>
				</div>
				<div className="col-4">
					<div className="row menu-button-location-margin">
						<button className="btn btn-upload-location">
							<i className="fa fa-upload upload-icon-location"></i> {`Bulk Upload`}
						</button>
						<button className="btn btn-success new-location-button-margin">
							<i className="fa fa-plus"></i> {`New Location`}
						</button>
					</div>
				</div>
			</div>
			<Menu />
			<Table data={ props.data } />
		</div>
	);
}
export default Details;