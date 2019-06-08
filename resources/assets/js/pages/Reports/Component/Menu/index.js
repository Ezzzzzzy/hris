import React from "react";
import { Link } from "react-router-dom";
import "./styles.css";

const Menu = () => {
	return (
		<div className="menu">
			<ul>
				<h6>Menu</h6>
				<li>
					<Link to="/reports/generated-reports" className="btn btn-block">
						Generated Reports
					</Link>
				</li>
				<li>
					<Link to="/reports/saved-templates" className="btn btn-block">
						Saved Templates
					</Link>
				</li>
			</ul>
		</div>
	);
};

export default Menu;
