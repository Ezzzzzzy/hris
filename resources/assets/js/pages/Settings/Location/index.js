import React, { Component } from 'react';
import { Details } from './components';
import swal from 'sweetalert2';

class Location extends Component {
	constructor(props) {
	  super(props);
	
	  this.state = {
	  		data: [
	  			{
		  			id: '1',
		  			name: 'Megamall',
		  			city: 'Mandaluyong',
		  			modified: 'Jessie Gabudao',
		  			region: 'Metro Manila',
		  			status: true,
		  			color: 'color-green'
		  		},
		  		{
		  			id: '2',
		  			name: 'Mall of Asia',
		  			city: 'Pasay',
		  			modified: 'Daryl Sinon',
		  			region: 'Metro Manila',
		  			status: true,
		  			color: 'color-red'
		  		},
		  		{
		  			id: '3',
		  			name: 'Robinsons Galleria',
		  			city: 'Pasig',
		  			modified: 'Daniella Camaya',
		  			region: 'Metro Manila',
		  			status: false,
		  			color: 'color-pink'
		  		},
		  		{
		  			id: '4',
		  			name: 'Greenhills Promenade',
		  			city: 'San Juan',
		  			modified: 'Vincent Ulap',
		  			region: 'Metro Manila',
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

export default Location;