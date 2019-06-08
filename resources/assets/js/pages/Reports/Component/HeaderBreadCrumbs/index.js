import React from "react";
import "./styles.css";

const HeaderBreadCrumbs = () => {
	return (
		<div>
			<ol className="breadcrumb">
				<li className="breadcrumb-item">
					<a href="#">Reports</a>
				</li>
				<li className="breadcrumb-item active">Generated Reports</li>
			</ol>
		</div>
	);
};

export default HeaderBreadCrumbs;
