import React from "react";
import { connect } from "react-redux";
import { Link } from "react-router-dom";

import { AddBrands, AddBusinessUnits } from "../Modal";
import ReactTooltip from "react-tooltip";

const Sidebar = props => {
	const renderBrands = unit => {
		return Object.keys(props.businessUnits[unit]).map((brand, i) => {
			return (
				<Link
					key={i}
					name={brand}
					onClick={e => props.changeBrand(e, unit)}
					to={`/clients/page/${brand}`}
				>
					<div className="row food-group-content">
						<div className="col-9 fg-content-name">{brand}</div>
						<div className="col-3 fg-content-qty">
							{props.businessUnits[unit][brand]["Members"]}
						</div>
					</div>
				</Link>
			);
		});
	};

	const renderBU = () => {
		return Object.keys(props.businessUnits).map((unit, i) => {
			var totalMember =
				Object.keys(props.businessUnits[unit]).length > 0
					? Object.keys(props.businessUnits[unit])
							.map(brand => {
								return Object.values(props.businessUnits[unit][brand])[0];
							})
							.reduce((a, b) => {
								return a + b;
							})
					: 0;
			return (
				<div key={i} className="food-group-card show side-bar-business-units">
					<div className="row food-group-header pointer">
						<div
							className="col-10 fg-header-title collapsed"
							data-toggle="collapse"
							data-target={`#${unit}`}
							aria-expanded="true"
							aria-controls="collapseOne"
							data-parent="#accordion"
						>
							{unit} ({totalMember})
						</div>
						<div
							data-tip=""
							data-for="add-brand"
							className="col-2 fg-header-button"
							onClick={() => props.openAddBrand(unit)}
						>
							<i className="fa fa-plus" />
						</div>
					</div>
					<div
						id={unit}
						name="business-units"
						className="collapse"
						area-expanded="false"
						aria-labelledby="headingTwo"
						data-parent="#ccordion"
					>
						{renderBrands(unit)}
					</div>
				</div>
			);
		});
	};

	return (
		<div className="client-page-sidebar col-2 left-panel-clientpage">
			<ReactTooltip id="add-brand">Add Brand</ReactTooltip>
			<Link
				name={"View Members"}
				onClick={props.changeTab.bind(this)}
				to="/clients/page/view-members"
			>
				<div className="company-card">
					<div className="container-fluid">
						<div className="row card-container-clientpage">
							<div className="col-3 aligner">
								<div className="row logo-div" />
							</div>

							<div className="col-9 name-container">
								<div className="row">
									<div className="company-shortcode">JFC</div>
								</div>
								<div className="row">
									<div className="company-name">Jollibee Food Corporation</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</Link>
			<div className="accordion" id="accordion">
				{renderBU()}
			</div>
			<div className="food-group-card-bottom">
				<div className="footer-details-card">
					<div className="row food-group-content">
						<div className="col-9 fg-content-name">MEMBERS</div>
						<div className="col-3 fg-content-qty">13212</div>
					</div>
					<div className="row food-group-content">
						<div className="col-9 fg-content-name">BRANDS</div>
						<div className="col-3 fg-content-qty">30</div>
					</div>
				</div>

				<div className="row">
					<div className="col-12 fg-btn-add">
						<button
							className="btn btn-success col-10"
							type="submit"
							data-toggle="modal"
							data-target="#add-business-units"
						>
							{" "}
							Add Business Unit{" "}
						</button>
					</div>
				</div>
			</div>
			<AddBrands
				currentUnit={props.currentUnit}
				addBrand={props.addBrand.bind(this)}
			/>
			<AddBusinessUnits addBusinessUnit={props.addBusinessUnit.bind(this)} />
		</div>
	);
};

export default connect(() => ({}))(Sidebar);
