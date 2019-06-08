import React from "react";
import ReactTable from "react-table";

const Table = props => {
	let { header } = props;
	return (
		<ReactTable
			data={props.data}
			columns={[
				{
					Header: header,
					accessor: "name",
					Cell: ({ original }) => {
						return (
							<div>
								<div>{original.name}</div>
							</div>
						);
					}
				},
				{
					Header: "Shortcode",
					accessor: "shortcode",
					Cell: ({ original }) => {
						return (
							<div>
								<div>
									{`${original.first_name} ${original.middle_name} ${
										original.last_name
									}`}
								</div>
								<div> {original.data_completion} </div>
							</div>
						);
					}
				},
				{
					Header: "Members",
					accessor: "members",
					Cell: ({ original }) => {
						return (
							<div>
								<div> {original.first_name} </div>
								<div> {original.business} </div>
							</div>
						);
					}
				},
				{
					Header: "Brands",
					accessor: "brands",
					Cell: ({ original }) => {
						return (
							<div>
								<div> {original.location} </div>
								<div> {original.location2} </div>
							</div>
						);
					}
				},
				{
					Header: "Last Modified",
					accessor: "lastmodified",
					Cell: ({ original }) => {
						return (
							<div>
								<div>{original.hiringDate}</div>
								<div> 4 months ago </div>
							</div>
						);
					}
				},
				{
					Header: "Last Modified By",
					accessor: "lastmodifiedby",
					Cell: row => (
						<div>
							<span className="badge"> {row.value} </span>
						</div>
					)
				},
				{
					Header: "",
					accessor: "",
					Cell: ({ original }) => {
						return (
							<div>
								<div>
									<div>
										<i className="fa fa-eye" />
									</div>
								</div>
								<div>
									<div>
										<i className="fa fa-edit" />
									</div>
								</div>
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
