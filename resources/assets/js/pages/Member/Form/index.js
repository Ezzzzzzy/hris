import React, { Component } from "react";

// redux
import { connect } from "react-redux";
import { city, member } from "../../../reducers/requests";
import { ADD_FORM_LOADED, EDIT_FORM_LOAD } from "../../../constants/action.type";

// components
import * as component from "./components";
import { Scrollspy } from "../../../components";
import Header from "../Header";
import { HeaderBreadcrumbs } from "../../../common/_all";

const MapStateToProps = state => ({ member: state.member });
const MapDispatchToProps = dispatch => ({ onLoad: (type, payload) => dispatch({ type, payload }) });

class Form extends Component {
	constructor(props) {
		super(props);

		this.state = {
			form: {},
			error: false,
			errors: [],
			reset: false,
			type: ADD_FORM_LOADED
		};

		this.handleChange = this.handleChange.bind(this);
	}

	static getDerivedStateFromProps(nextProps, prevState) {
		if (nextProps.member.error) {
			return { error: true, errors: nextProps.member.errorMessage };
		};

		return nextProps.member.payload
			? { form: nextProps.member.payload }
			: { form: prevState.form };
	}

	shouldComponentUpdate(nextProps, nextState) {
		if (this.state.type === EDIT_FORM_LOAD) {
			return nextProps.member.inProgress === false && true;
		} else return true;
	}

	componentDidMount() {
		let payload = [city.getAll()];

		if (this.props.match.params.memberId) {
			payload.push(member.get(this.props.match.params.memberId));
			this.setState({ type: EDIT_FORM_LOAD }, () => {
				this.props.onLoad(this.state.type, Promise.all(payload));
			});
		} else this.props.onLoad(this.state.type, Promise.all(payload));
	}

	handleChange(val, propName) {
		let form = this.state.form;

		if (Array.isArray(val) && (val.length === 0 || val[0] === "")) {
			delete form[propName];
		} else form[propName] = val;

		this.setState({ form, reset: false });
	}

	resetForm() {
		this.setState({ form: {}, reset: true });
	}

	scrollToTop() {
		document.body.scrollTop = 0;
    	document.documentElement.scrollTop = 0;
	}

	getErrors(errors) {
		this.scrollToTop();
		this.setState({ errors });
	}

	readableString(world) {
		while(world.indexOf('_') > 0) {
			world = world.replace('_', ' ');
		}

	  	return world.charAt(0) + world.slice(1);
	}

	render() {
		let header = `Add New Member`;
		
		if (this.props.member && this.props.member.payload) {
			let { first_name, middle_name, last_name, extension_name } = this.props.member.payload;
			header = this.props.member.payload && `Member - ${first_name} ${middle_name} ${last_name} ${extension_name || ""}`;
		}

		if (this.state.error) this.scrollToTop();

		return (
			<div className="container-fluid">
				<Header title={ header } />
				<HeaderBreadcrumbs />
				<Scrollspy />
				{
					<center>
						<h6 style={{color: 'red'}}>
						{
							(this.state.error)
								? this.state.errors[0]
								: (this.state.errors.length)
									? `The ${this.readableString(this.state.errors[0])} field is required.`
									: null
						}
						</h6>
					</center>					
				}

				<component.MemberID handleChange={ this.handleChange } {...this.state} />
				<component.Personal handleChange={ this.handleChange } {...this.state} />
				<component.Government handleChange={ this.handleChange } {...this.state} />
				<component.Education handleChange={ this.handleChange } {...this.state} />
				<component.Employment handleChange={ this.handleChange } {...this.state} />
				<component.Family handleChange={ this.handleChange } {...this.state} />
				<component.Emergency handleChange={ this.handleChange } {...this.state} />
				<component.Reference handleChange={ this.handleChange } {...this.state} />
				<component.SaveButton 
					{ ...this.state }
					redirect={ this.props.history }
					reset={ this.resetForm.bind(this) }
					getErrors={ this.getErrors.bind(this) }
				/>
			</div>
		);
	}
}

export default connect(MapStateToProps, MapDispatchToProps)(Form);