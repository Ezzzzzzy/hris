import React, { Component } from "react";
import ReactTable from "react-table";
import Toggle from "react-toggle";

const Table = props => {
	return (
		<ReactTable
			data={props.data}
			columns={[
				{
					Header: props => <div className="text-left"> ID </div>,
					accessor: "id",
					width: 60,
					Cell: ({ original }) => {
						return (
							<div>
								<div className="text-left table-data-adjust-type-1">
									{original.id} 
								</div>
							</div>
						);
					}
				},
				{
					Header: props => <div className="text-left"> Name </div>,
					accessor: "name",
					width: 270,
					Cell: ({ original }) => {
						return (
							<div>
								<div className="text-left table-data-adjust-type-1">
									{` ${original.name}`}
								</div>
							</div>
						);
					}
				},
				{
					Header: props => <div className="text-left"> Last Modified </div>,
					accessor: "modified",
					width: 200,
					Cell: ({ original }) => {
						return (
							<div>
								<div className="text-left table-data-adjust-type-1">
									{original.modified}
								</div>
							</div>
						);
					}
				},
				{
					Header: props => <div className="text-left"> Order </div>,
					accessor: "order",
					width: 90,
					Cell: ({ original }) => {
						return (
							<div>
								<div className="text-left table-data-adjust-type-1">
									{original.order}
								</div>
							</div>
						);
					}
				},
				{
					Header: "Status",
					accessor: "status",
					width: 140,
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
					width: 160,
					Cell: () => {
						return (
							<div>
								<button 
									className="modal-button color-light-gray pointer"
									onClick={ ()=>{ props.swal() } }
								> 
									<span className="fa fa-edit"></span> 
										{` Edit`}  
								</button>
								<button 
									className="modal-button color-light-gray pointer"
									onClick={ ()=>{ props.swal() } }
								> 
									<span className="fa fa-trash"></span> 
										{` Delete`} 
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