import React, {Component} from 'react';
import ReactDOM from 'react-dom';

const Item = () => {
	const items = [
		{ href: 'member_id_label', title: 'Old member ID' },
		{ href: 'personal_info_id', title: 'Personal Information' },
		{ href: 'gov_mandated_id', title: 'Government Mandated Numbers' },
		{ href: 'educ_attainment_id', title: 'Educational Attainment' },
		{ href: 'emploment_hist_id', title: 'Employment History' },
		{ href: 'fam_bg_id', title: 'Family Background' },
		{ href: 'emergency_id', title: 'In Case of Emergency' },
		{ href: 'char_reference_id', title: 'Character Reference' },
	];

	const rows = [];

	for ( let item in items ) {
		rows.push(
			<li className="nav-item" key={item} >
	            <a className="section-sub-id nav-link" href={'#' + items[item].href}>
	            	{ items[item].title }
	        	</a>
	        </li>
        )
	}

	return rows;
}

export default Item;