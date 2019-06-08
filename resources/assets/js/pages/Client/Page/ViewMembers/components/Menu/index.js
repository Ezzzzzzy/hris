import React from "react";

import { Select, DatePicker } from "../../../../../../components";

const Menu = props => {
	return (
		<div>
			<div className="row details-container">
				<div className="col-6 column-slim">
					<div className="row container-slim">
						<div className="col-6 column-slim">
							<label>LOCATIONS</label>
							<Select
								options={props.selectMenuLocation}
								display={"display"}
								optionValue={"value"}
								value={"value"}
								onChange={e => console.log("Selected: " + e.target.value)}
							/>
						</div>
						<div className="col-6 column-slim">
							<label>BRAND</label>
							<Select
								options={props.selectMenuBrand}
								display={"display"}
								optionValue={"value"}
								value={"value"}
								onChange={e => console.log("Selected: " + e.target.value)}
							/>
						</div>
					</div>
				</div>
				<div className="col-6 column-slim">
					<div className="row container-slim">
						<div className="col-3 column-slim">
							<label>GENDER</label>
							<Select
								options={props.selectMenuGender}
								display={"display"}
								optionValue={"value"}
								value={"value"}
								onChange={e => console.log("Selected: " + e.target.value)}
							/>
						</div>
						<div className="col-4 column-slim">
							<label>HIRING DATE</label>
							<DatePicker
								errors={[]}
								onChange={() => console.log("Changed Date Picked")}
							/>
						</div>
						<div className="col-1">
							<label>&emsp;</label>
							<label>&#x2015;</label>
						</div>
						<div className="col-4 column-slim">
							<label>&emsp;</label>
							<DatePicker
								errors={[]}
								onChange={() => console.log("Changed Date Picked")}
							/>
						</div>
					</div>
				</div>
			</div>
			<div className="row table-components">
				<div className="col-5 col-left select-row">
					<div className="row margin-top-20">
						<div className="col-6">
							<Select
								options={props.selectMenuStatus}
								display={"display"}
								optionValue={"value"}
								value={"value"}
								onChange={e => console.log("Selected: " + e.target.value)}
							/>
						</div>
						<div className="col-6">
							<Select
								options={props.selectMenuPosition}
								display={"display"}
								optionValue={"value"}
								value={"value"}
								onChange={e => console.log("Selected: " + e.target.value)}
							/>
						</div>
					</div>
				</div>
				<div className="col-7 col-right margin-top-23">
					<div className="row">
						<div className="col-7 offset-2 column-slim">
							<div className="row margin-top-23">
								<div className="col-10 search-container">
									<input
										onChange={e => console.log("Filtering")}
										className="form-control search-input pull-left"
										placeholder="Search"
									/>
								</div>
								<div className="col-2 search-container">
									<button className="btn search-button" type="submit">
										<i className="fa fa-search" />
									</button>
								</div>
							</div>
						</div>
						<div className="col-3 column-slim bulk-actions margin-top-23">
							<select className="form-control" id="bulk-actions">
								<option value="" selected disabled hidden>
									Bulk Actions
								</option>
								<option value="update-status-bulk">Update Status</option>
								<option value="end-tenure-bulk">End Tenure</option>
								<option value="reassign-member-bulk">Reassign Member</option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	);
};

export default Menu;
