import React, { Component } from "react";
import { connect } from "react-redux";
import Header from "../Header";
import Info from "./info";
import { HeaderBreadcrumbs } from "../../../common/_all";
import member from "../../../reducers/Member/actions";
import { PROFILE_PAGE_LOADED } from "../../../constants/action.type";

const MapStateToProps = state => ({
	member: state.member
});

const MapDispatchToProps = dispatch => ({
	onLoad: payload => dispatch({ type: PROFILE_PAGE_LOADED, payload })
});

class Profile extends Component {
	state = {};

	static getDerivedStateFromProps(props, prev) {
		if (props.member.inProgress === "false") {
			return { state: props.member };
		}
		return null;
	}

	componentDidMount() {
		this.props.onLoad(
			Promise.all([member.get(this.props.match.params.memberId)])
		);
	}

	render() {
		let header = `Add New Member`;
		if (this.props.member && this.props.member.payload) {
			let {
				first_name,
				middle_name,
				last_name,
				extension_name
			} = this.props.member.payload;
			header =
				this.props.member.payload &&
				`Member - ${first_name} ${middle_name} ${last_name} ${extension_name ||
					""}`;
		}

		return (
			<div>
				<Header
					title={header}
					memberId={this.props.match.params.memberId}
					type="view"
				/>
				<HeaderBreadcrumbs />
				{this.props.member.inProgress ? (
					<center>
						<h2> Loading ... </h2>
					</center>
				) : this.props.member.payload && "id" in this.props.member.payload ? (
					<Info data={this.props.member.payload} />
				) : null}
			</div>
		);
	}
}

export default connect(
	MapStateToProps,
	MapDispatchToProps
)(Profile);
