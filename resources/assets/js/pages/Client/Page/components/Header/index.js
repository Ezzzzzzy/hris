import React from "react";
import { Link } from "react-router-dom";

const Header = props => {
	return (
		<div className="row header-dashboard">
			<div className="col-4">
				<div className="header-company-details">
					<div className="header-shortcode">JFC</div>
					<div className="header-company-name">Jollibee Food Corporation</div>
				</div>
			</div>
			<div className="col-8 item-container row">
				<div
					className={
						"col-3 dashboard-items" +
						(props.location.pathname.split("/")[3] == "view-members"
							? " active-client-tab"
							: "")
					}
				>
					<Link
						to="/clients/page/view-members"
						onClick={props.changeTab.bind(this)}
						name="View Members"
					>
						<div className="col-12 item-count">13212</div>
						<div className="col-12 item-count-name">MEMBERS</div>
					</Link>
				</div>
				<div
					className={
						"col-3 dashboard-items" +
						(props.location.pathname.split("/")[3] == "business-units"
							? " active-client-tab"
							: "")
					}
				>
					<Link
						to="/clients/page/business-units"
						className="link"
						onClick={props.changeTab.bind(this)}
						name="Business Units"
					>
						<div className="col-12 item-count">10</div>
						<div className="col-12 item-count-name">BUSINESS UNITS</div>
					</Link>
				</div>
				<div
					className={
						"col-3 dashboard-items" +
						(props.location.pathname.split("/")[3] == "brands"
							? " active-client-tab"
							: "")
					}
				>
					<Link
						to="/clients/page/brands"
						className="link"
						onClick={props.changeTab.bind(this)}
						name="Brands"
					>
						<div className="col-12 item-count">30</div>
						<div className="col-12 item-count-name">BRANDS</div>
					</Link>
				</div>
				<div
					className={
						"col-3 dashboard-items" +
						(props.location.pathname.split("/")[3] == "branches"
							? " active-client-tab"
							: "")
					}
				>
					<Link
						to="/clients/page/branches"
						className="link"
						onClick={props.changeTab.bind(this)}
						name="Branches"
					>
						<div className="col-12 item-count last-item">150</div>
						<div className="col-12 item-count-name last-item">BRANCHES</div>
					</Link>
				</div>
			</div>
		</div>
	);
};

export default Header;
