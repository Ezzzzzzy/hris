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
							<div>
								<div> {original.id} </div>
							</div>
						);
					}
				},
				{
					Header: "Status Name",
					accessor: "name",
					width: 230,
					Cell: ({ original }) => {
						return (
							<div>
								<div className="text-left">
									&nbsp; <span className={ "fa fa-circle " + `${original.color}` }></span> 
									&nbsp; &nbsp; {original.name}
								</div>
							</div>
						);
					}
				},
				{
					Header: "Type",
					accessor: "type",
					width: 80,
					Cell: ({ original }) => {
						return (
							<div>
								<div>{original.type}</div>
							</div>
						);
					}
				},
				{
					Header: "Last Modified",
					accessor: "modified",
					width: 200,
					Cell: ({ original }) => {
						return (
							<div>
								<div>{original.modified}</div>
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
							<div>
								<div>{original.order}</div>
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
									// onChange={ (e)=>props.statusChange(e.target.checked, row._viewIndex) }
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
