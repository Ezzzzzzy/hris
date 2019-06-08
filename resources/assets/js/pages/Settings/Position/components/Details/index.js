import React from 'react';
import { Table, Menu } from '../../components';
import { Label } from '../../../../../components';

const Details = (props) => {
	return (
		<div className="col-12 table-card">
			<h3><Label label={'Manage Positions'} /></h3>
			<Menu />
			<Table data={props.data} />
		</div>
	);
}

export default Details;