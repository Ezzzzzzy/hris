import React, { Component } from "react";
import { connect } from "react-redux";
import { Menu, Table } from "./Components";

class BrandsPage extends Component {
	constructor(props) {
		super(props);

		this.state = {};
	}

	render() {
		return (
			<div className="col-10 offset-2 right-panel-clientpage">
				<div className="row header-dashboard brands-header">
					<div className="col-4">
						<div className="header-company-details">
							<div className="header-shortcode">{this.props.currentTab}</div>
							<div className="header-company-name">
								Jollibee Foods Corporation
							</div>
						</div>
					</div>
					<div className="col-8 item-container row">
						<div className="col-3 dashboard-items">
							<div className="col-12 item-count">100</div>
							<div className="col-12 item-count-name">MEMBERS</div>
						</div>
						<div className="col-3 dashboard-items">
							<div className="col-12 item-count">30</div>
							<div className="col-12 item-count-name">BRANCHES</div>
						</div>
						<div className="col-3 dashboard-items">
							<div className="col-12 item-count">3</div>
							<div className="col-12 item-count-name">CITIES</div>
						</div>
						<div className="col-3 dashboard-items">
							<div className="col-12 item-count last-item">1</div>
							<div className="col-12 item-count-name last-item">REGIONS</div>
						</div>
					</div>
				</div>
				<div className="client-container-clientpage">
					<Menu />
					<Table datas={this.state.datas} className={"table-container"} />
				</div>
			</div>
		);
	}
}

export default connect(() => ({}))(BrandsPage);
