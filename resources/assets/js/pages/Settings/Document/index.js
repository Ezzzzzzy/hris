import React, { Component } from 'react';
import { Details } from './components';
import swal from 'sweetalert2';


class Document extends Component {
	constructor(props) {
	  super(props);
	  this.state = {
	  		data: [
	  			{
		  			id: '0',
		  			name: 'Birth Certificate',
		  			type: 'Req',
		  			modified: 'Jessie Gabudao',
		  			order: '1',
		  			status: true
		  		},
		  		{
		  			id: '1',
		  			name: 'TIN ID',
		  			type: 'Req',
		  			modified: 'Daryl Sinon',
		  			order: '2',
		  			status: true
		  		},
		  		{
		  			id: '2',
		  			name: 'PMFRF',
		  			type: 'Con',
		  			modified: 'Daniella Camaya',
		  			order: '3',
		  			status: false
		  		},
		  		{
		  			id: '3',
		  			name: 'SSS',
		  			type: 'Con',
		  			modified: 'Vincent Ulap',
		  			order: '4',
		  			status: false
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

export default Document;