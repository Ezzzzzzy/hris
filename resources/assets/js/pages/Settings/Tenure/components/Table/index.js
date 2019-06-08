import React from "react";
import ReactTable from "react-table";
import Toggle from "react-toggle";

const Table = props => {
	return (
		<ReactTable
			data={props.data}
			columns={[
				{
					Header: props => <div className="text-left">ID</div>,
					accessor: "id",
					width: 70,
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
					Header: props => <div className="text-left">Title</div>,
					accessor: "name",
					width: 300,
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
					Header: props => <div className="text-left">Range</div>,
					accessor: "modified",
					width: 220,
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
					Header: "Status",
					accessor: "status",
					width: 160,
					Cell: ({ original }) => {
						return (
							<div>
								<Toggle
									defaultChecked={original.status}
									icons={false}
								/>

							</div>
						);
					}
				},
				{
					Header: "",
					accessor: "edit",
					width: 170,
					Cell: () => {
						return (
							<div>
								<button
									className="modal-button color-light-gray pointer"
									onClick={() => { props.swal() }}
								>
									<span className="fa fa-edit"></span>
									{` Edit`}
								</button>
								<button
									className="modal-button color-light-gray pointer"
									onClick={() => { props.swal() }}
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