import React, { Component } from "react";
import ReactTable from "react-table";
import "./styles.css";

const Table = props => {
	return (
		<ReactTable
			data={props.data}
			columns={[
				{
					Header: "Date",
					accessor: "date",
					width: 150,
					Cell: ({ original }) => {
						return (
							<div>
								<div> {original.date} </div>
							</div>
						);
					}
				},
				{
					Header: "Title",
					accessor: "title",
					width: 250,
					Cell: ({ original }) => {
						return (
							<div>
								<div>{original.title}</div>
							</div>
						);
					}
				},
				{
					Header: "Type",
					accessor: "type",
					width: 100,
					Cell: ({ original }) => {
						return (
							<div>
								<div> {original.type} </div>
							</div>
						);
					}
				},
				{
					Header: "Template",
					accessor: "template",
					width: 150,
					Cell: ({ original }) => {
						return (
							<div>
								<div>{original.template}</div>
							</div>
						);
					}
				},
				{
					Header: "Generated by",
					accessor: "generatedBy",
					width: 150,
					Cell: ({ original }) => {
						return (
							<div>
								<div>{original.generatedBy}</div>
							</div>
						);
					}
				},
				{
					Header: "",
					accessor: "",
					width: 100,
					Cell: () => {
						return (
							<div>
								<a>View</a>
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
