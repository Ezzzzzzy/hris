import React, { Component } from "react";
import ReactTable from "react-table";
import Toggle from "react-toggle";
import SweetAlert from 'react-bootstrap-sweetalert';
import { EditStatus } from '../Modal';

const Table = props => {
	return (
		<ReactTable
			data={props.data}
			columns={[
				{
					Header: "ID",
					accessor: "id",
					width: 60,
					Cell: ({ original }) => {
						return (
							<div className="text-left table-data-adjust-type-2">
								{original.id}
							</div>
						);
					}
				},
				{
					Header: <div className="text-left"> Name </div>,
					accessor: "name",
					width: 250,
					Cell: ({ original }) => {
						return (
							<div>
								<div className="text-left table-data-adjust-type-1">
									<b> {original.name} </b>
								</div>
							</div>
						);
					}
				},
				{
					Header: "Type",
					accessor: "type",
					width: 70,
					Cell: ({ original }) => {
						return (
							<div className="text-left table-data-adjust-type-2"> 
								{original.type} 
							</div>
						);
					}
				},
				{
					Header: <div className="text-left"> Last Modified </div>,
					accessor: "modified",
					width: 190,
					Cell: ({ original }) => {
						return (
							<div className="text-left table-data-adjust-type-1"> 
								{original.modified}
							</div>
						);
					}
				},
				{
					Header: "Order",
					accessor: "order",
					width: 90,
					Cell: ({ original }) => {
						return (
							<div className="text-left table-data-adjust-type-1"> 
								 {original.order}
							</div>
						);
					}
				},
				{
					Header: "Status",
					accessor: "status",
					width: 100,
					Cell: ({ original }) => {
						return (
							<div>
								<Toggle
									defaultChecked={ original.status }
									icons={ false }	
								/>

							</div>
						);
					}
				},
				{
					Header: "",
					accessor: "edit",
					width: 80,
					Cell: () => {
						return (
							<div>
								<EditStatus />
							</div>
						);
					}
				},
				{
					Header: "",
					accessor: "delete",
					width: 80,
					Cell: () => {
						return (
							<div>
								<button 
									className="modal-button color-light-gray"
									onClick={ ()=>{ props.swal() } }
								> 
									<span className="fa fa-trash"></span> 
										Delete 
								</button>
							</div>
						);
					}
				}
			]}
			defaultPageSize={10}
			className="-highlight"
		/>
	);
};

export default Table;
