import React from "react";
import Table from "../Component/Table";
import { Select, TextInput } from "../../../components";

const GeneratedReport = () => {
	return (
		<div>
			<h2 className="reports-title">Generated Reports</h2>
			<div className="bar">
				<div className="left-bar">
					<Select />
					<Select />
				</div>
				<div className="right-bar">
					<TextInput />
					<button className="btn btn-success" data-target="#">
						+ New Report
					</button>
				</div>
			</div>
			<Table className="col-lg-9" />
		</div>
	);
};

export default GeneratedReport;
