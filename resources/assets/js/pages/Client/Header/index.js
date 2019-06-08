import React, { Component } from "react";
import ReactDOM from "react-dom";
import "./style.css";

const Header = ({ title }) => {
	return (
		<div id="header-all" className="container-fluid">
			<div id="header-upper-part" className="row justify-content-between">
				<div className="col-md-auto header-text-adjust">
					<span id="header-text">{title}</span>
				</div>
			</div>
		</div>
	);
};

export default Header;
