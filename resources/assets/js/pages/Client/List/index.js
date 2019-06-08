import React, { Component } from "react";
import { Header } from "./../../../components";
import Table from "./components/Table";
import Add from "./components/Modal/Add";
import View from "./components/Modal/View";
import Edit from "./components/Modal/Edit";

class List extends Component {
	render() {
		let headerTitle = `Clients List`;
		return (
			<div>
				<Header title={headerTitle} />
				<div className="col-10 offset-1 container">
					<div className="row">
						<div className="col-6 offset-6">
							<div className="row">
								<div className="col-9">
									<div className="row right">
										<div className="col-10 search-container">
											<input
												className="form-control search-input"
												type="search"
												placeholder="Search by Client Name or Shortcode"
												aria-label="Search"
											/>
										</div>
										<div className="col-2 search-container">
											<button className="btn search-button" type="submit">
												<i className="fa fa-search" />
											</button>
										</div>
									</div>
								</div>
								<div className="col-3">
									<button
										className="btn btn-success pull-right"
										type="submit"
										data-toggle="modal"
										data-target="#add-new-client-modal"
									>
										<i className="fa fa-plus" />
										&nbsp; New Client
									</button>
								</div>
							</div>
						</div>
					</div>
					<Add />
					<Edit />
					<View />
					<div className="row table-container">
						<Table header={"Name"} />
					</div>
				</div>
			</div>
		);
	}
}

export default List;
