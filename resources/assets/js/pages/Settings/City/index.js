import React, { Component } from 'react';
import { Header, Menu } from '../components';
import { Details } from './components';
import swal from 'sweetalert2'

class City extends Component {
	constructor(props) {
	  super(props);
	
	  this.state = {
	  		data: [
	  			{
		  			id: '1',
		  			name: 'Pasig',
		  			region: 'Metro Manila',
		  			modified: 'Jessie Gabudao',
		  			order: '1',
		  			status: true,
		  			color: 'color-green'
		  		},
		  		{
		  			id: '2',
		  			name: 'San Juan',
		  			region: 'Cetral Luzon',
		  			modified: 'Daryl Sinon',
		  			order: '2',
		  			status: true,
		  			color: 'color-red'
		  		},
		  		{
		  			id: '3',
		  			name: 'Mandaluyong',
		  			region: 'Metro Manila',
		  			modified: 'Daniella Camaya',
		  			order: '3',
		  			status: false,
		  			color: 'color-pink'
		  		},
		  		{
		  			id: '4',
		  			name: 'Angeles',
		  			region: 'Metro Manila',
		  			modified: 'Vincent Ulap',
		  			order: '4',
		  			status: true,
		  			color: 'color-light-gray'
		  		},
	  		]
	  };
	}

	swal(){
		swal ({
			title: 'Are you sure?',
			text: "Once deleted, you will not be able to recover this status.",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ok'
		})	
		.then((result) => {
  			if (result.value) {
    			swal(
			        'Deleted!',
			        'Your file has been deleted.',
			        'success'
    			)
  			}
		})
	}

	render (){
		return (
			<div>
				<Details 
					data={ this.state.data }
					swal={ this.swal.bind(this) }
				/>
			</div>
		);
	}
}

export default City;