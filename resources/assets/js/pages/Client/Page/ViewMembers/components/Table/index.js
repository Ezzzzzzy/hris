import React from "react";

import ReactTable from "react-table";
import { Checkbox, Select } from "../../../../../../components";
import "../../../react-table.css";
import ReactTooltip from "react-tooltip";
import {
	UpdateStatus,
	ReassignMember,
	EndTenure,
	QuickViewMember
} from "../Modal";

const data = [
	{
		id: "1203",
		profile_status: "Incomplete Profile",
		name: "Am Rivera",
		data_completion: "Seasonal, BU",
		position: "Web Developer",
		business: "Brand, BU",
		gender: "Male",
		addressOne: "Guiguinto, Bulacan",
		addressTwo: "Cavite Area, Cavite",
		hiringDate: "Jan. 28 2018",
		status: "PROBATIONARY",
		lastModified: "May 05 2018",
		modifiedBy: "Neil Nato",
		da: <i className="fa fa-check" aria-hidden="true" />
	},
	{
		id: "1204",
		profile_status: "",
		name: "Em Rivera",
		data_completion: "Seasonal, BU",
		position: "Web Developer",
		business: "Brand, BU",
		location: "Guiguinto, Bulacan",
		location2: "Cavite Area, Cavite",
		hiringDate: "Jan. 28 2018",
		status: "QUALIFIED",
		lastModified: "May 05 2018",
		modifiedBy: "Neil Nato",
		da: <i className="fa fa-check" aria-hidden="true" />
	},
	{
		id: "1205",
		profile_status: "Incomplete Profile",
		name: "Em Rivera",
		data_completion: "Seasonal, BU",
		position: "Web Developer",
		business: "Sanuk, UTCI",
		location: "Guiguinto, Bulacan",
		location2: "Cavite Area, Cavite",
		hiringDate: "Jan. 28 2018",
		status: "TRAINING",
		lastModified: "May 05 2018",
		modifiedBy: "Neil Nato",
		da: <i className="fa fa-minus" aria-hidden="true" />
	},
	{
		id: "1206",
		profile_status: "Incomplete Profile",
		name: "Em Rivera",
		data_completion: "Seasonal, BU",
		position: "Web Developer",
		business: "Sanuk, UTCI",
		location: "Guiguinto, Bulacan",
		location2: "Cavite Area, Cavite",
		hiringDate: "Jan. 28 2018",
		status: "NOT QUALIFIED",
		lastModified: "May 05 2018",
		modifiedBy: "Neil Nato",
		da: <i className="fa fa-minus" aria-hidden="true" />
	},
	{
		id: "1203",
		profile_status: "Incomplete Profile",
		name: "Am Rivera",
		data_completion: "Seasonal, BU",
		position: "Web Developer",
		business: "Brand, BU",
		location: "Guiguinto, Bulacan",
		location2: "Cavite Area, Cavite",
		hiringDate: "Jan. 28 2018",
		status: "PROBATIONARY",
		lastModified: "May 05 2018",
		modifiedBy: "Neil Nato",
		da: <i className="fa fa-minus" aria-hidden="true" />
	},
	{
		id: "1204",
		profile_status: "",
		name: "Em Rivera",
		data_completion: "Seasonal, BU",
		position: "Web Developer",
		business: "Brand, BU",
		location: "Guiguinto, Bulacan",
		location2: "Cavite Area, Cavite",
		hiringDate: "Jan. 28 2018",
		status: "QUALIFIED",
		lastModified: "May 05 2018",
		modifiedBy: "Neil Nato",
		da: <i className="far fa-clock" aria-hidden="true" />
	},
	{
		id: "1205",
		profile_status: "Incomplete Profile",
		name: "Em Rivera",
		data_completion: "Seasonal, BU",
		position: "Web Developer",
		business: "Sanuk, UTCI",
		location: "Guiguinto, Bulacan",
		location2: "Cavite Area, Cavite",
		hiringDate: "Jan. 28 2018",
		status: "TRAINING",
		lastModified: "May 05 2018",
		modifiedBy: "Neil Nato",
		da: <i className="fa fa-check" aria-hidden="true" />
	},
	{
		id: "1206",
		profile_status: "Incomplete Profile",
		name: "Em Rivera",
		data_completion: "Seasonal, BU",
		position: "Web Developer",
		business: "Sanuk, UTCI",
		location: "Guiguinto, Bulacan",
		location2: "Cavite Area, Cavite",
		hiringDate: "Jan. 28 2018",
		status: "NOT QUALIFIED",
		lastModified: "May 05 2018",
		modifiedBy: "Neil Nato",
		da: <i className="far fa-clock" aria-hidden="true" />
	},
	{
		id: "1203",
		profile_status: "Incomplete Profile",
		name: "Am Rivera",
		data_completion: "Seasonal, BU",
		position: "Web Developer",
		business: "Brand, BU",
		location: "Guiguinto, Bulacan",
		location2: "Cavite Area, Cavite",
		hiringDate: "Jan. 28 2018",
		status: "PROBATIONARY",
		lastModified: "May 05 2018",
		modifiedBy: "Neil Nato",
		da: <i className="fa fa-minus" aria-hidden="true" />
	},
	{
		id: "1204",
		profile_status: "",
		name: "Em Rivera",
		data_completion: "Seasonal, BU",
		position: "Web Developer",
		business: "Brand, BU",
		location: "Guiguinto, Bulacan",
		location2: "Cavite Area, Cavite",
		hiringDate: "Jan. 28 2018",
		status: "QUALIFIED",
		lastModified: "May 05 2018",
		modifiedBy: "Neil Nato",
		da: <i className="fa fa-check" aria-hidden="true" />
	},
	{
		id: "1205",
		profile_status: "Incomplete Profile",
		name: "Em Rivera",
		data_completion: "Seasonal, BU",
		position: "Web Developer",
		business: "Sanuk, UTCI",
		location: "Guiguinto, Bulacan",
		location2: "Cavite Area, Cavite",
		hiringDate: "Jan. 28 2018",
		status: "TRAINING",
		lastModified: "May 05 2018",
		modifiedBy: "Neil Nato",
		da: <i className="fa fa-check" aria-hidden="true" />
	},
	{
		id: "1206",
		profile_status: "Incomplete Profile",
		name: "Em Rivera",
		data_completion: "Seasonal, BU",
		position: "Web Developer",
		business: "Sanuk, UTCI",
		location: "Guiguinto, Bulacan",
		location2: "Cavite Area, Cavite",
		hiringDate: "Jan. 28 2018",
		status: "NOT QUALIFIED",
		lastModified: "May 05 2018",
		modifiedBy: "Neil Nato",
		da: <i className="fa fa-check" aria-hidden="true" />
	}
];

const Table = props => {
	return (
		<div className="row table-container default-cursor">
			<ReactTooltip id="quick-view">Quick View</ReactTooltip>
			<ReactTable
				data={data}
				columns={[
					{
						Header: () => (
							<label className="flex-container rows">
								<Checkbox className="text-center" />
							</label>
						),
						accessor: "",
						Cell: ({ original }) => {
							return (
								<label className="flex-container rows">
									<Checkbox className="text-center" />
								</label>
							);
						},
						width: 50,
						sortable: false
					},
					{
						Header: "DA",
						accessor: "da",
						Cell: ({ original }) => {
							return <div>{original.da}</div>;
						},
						width: 60,
						sortable: false
					},
					{
						Header: "Name",
						accessor: "name",
						Cell: ({ original }) => {
							return (
								<div className="flex-container column text-left">
									<div
										className="member-name pointer"
										onClick={() => props.quickViewMemberModal(original)}
										data-tip=""
										data-for="quick-view"
									>{`${original.name}`}</div>
									<div>{original.data_completion}</div>
								</div>
							);
						}
					},
					{
						Header: "Position",
						accessor: "position",
						Cell: ({ original }) => {
							return (
								<div>
									<div>{original.business}</div>
								</div>
							);
						},
						sortable: false
					},
					{
						Header: "Latest Branch",
						accessor: "branch",
						Cell: ({ original }) => {
							return (
								<div>
									<div>{original.location}</div>
									<div>{original.location2}</div>
								</div>
							);
						},
						sortable: false
					},
					{
						Header: "Hiring Date",
						accessor: "hiringDate",
						Cell: ({ original }) => {
							return (
								<div>
									<div>{original.hiringDate}</div>
									<div>4 months ago</div>
								</div>
							);
						},
						sortable: false
					},
					{
						Header: "Status as Hired",
						accessor: "hiredStatus",
						Cell: ({ original }) => {
							return (
								<div className="btn-success btn-block status">
									<div>{original.status}</div>
								</div>
							);
						},
						sortable: false
					},
					{
						Header: "",
						accessor: "",
						Cell: ({ original }) => {
							return (
								<div>
									<select
										onChange={props.actionsModal}
										id={original.id}
										className="form-control"
									>
										<option value="" selected disabled hidden>
											Actions
										</option>
										<option value="update-status-solo">Update Status</option>
										<option value="reassign-member-solo">
											Reassign Member
										</option>
										<option value="end-tenure-solo">End Tenure</option>
									</select>
								</div>
							);
						},
						sortable: false
					}
				]}
				defaultPageSize={10}
				className="-highlight"
			/>
			<UpdateStatus
				selectStatus={props.selectStatus}
				selectReasonForLeaving={props.selectReasonForLeaving}
			/>
			<ReassignMember
				selectStatus={props.selectStatus}
				selectReasonForLeaving={props.selectReasonForLeaving}
				selectBranches={props.selectBranches}
				selectBrands={props.selectBrands}
				selectClients={props.selectClients}
				selectPositions={props.selectPositions}
			/>
			<EndTenure
				selectStatus={props.selectStatus}
				selectReasonForLeaving={props.selectReasonForLeaving}
			/>
			<QuickViewMember currentDatum={props.currentDatum} />
		</div>
	);
};

export default Table;
