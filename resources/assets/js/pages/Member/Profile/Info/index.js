import React, { Component } from "react";
import * as component from "./components";
import "./style.css";
import Scrollspy from "../../../../components/Scrollspy";

class Info extends Component {
	render() {
		return (
			<div className="container-fluid">
				<Scrollspy />
				<component.MemberID data={this.props.data} />
				<component.Personal data={this.props.data} />
				<component.Government data={this.props.data} />
				<component.Education data={this.props.data} />
				<component.Employment data={this.props.data} />
				<component.Family data={this.props.data} />
				<component.Emergency data={this.props.data} />
				<component.Reference data={this.props.data} />
			</div>
		);
	}
}

export default Info;
