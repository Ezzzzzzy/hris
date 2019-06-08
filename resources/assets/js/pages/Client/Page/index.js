import React, {  Component } from "react";
import {  connect } from "react-redux";
import {  Route, Switch } from "react-router-dom";
import ViewMembers from "./ViewMembers";
import BusinessUnits from "./BusinessUnits";
import Brands from "./Brands";
import Branches from "./Branches";
import BrandsPage from "./BrandsPage";
import Sidebar from "./components/Sidebar";
import NotFound from "../../NotFound";

class Page extends Component { 
	constructor(props) { 
		super(props);

		this.state = { 
			businessUnits: { 
				ShoesStore: { 
					Adidas: { 
						Members: 1211,
						Branches: 253,
						Cities: 24,
						Regions: 12
					},
					Nike: { 
						Members: 123,
						Branches: 321,
						Cities: 12,
						Regions: 3
					},
					Puma: { 
						Members: 321,
						Branches: 3,
						Cities: 12,
						Regions: 3
					}
				},
				DoubleDragon: { 
					Chowking: { 
						Members: 312,
						Branches: 321,
						Cities: 32,
						Regions: 32
					},
					Jollibee: { 
						Members: 100,
						Branches: 3,
						Cities: 2212,
						Regions: 212
					},
					McDonalds: { 
						Members: 3321,
						Branches: 33,
						Cities: 31,
						Regions: 32
					},
					KFC: { 
						Members: 4323,
						Branches: 324,
						Cities: 142,
						Regions: 214
					}
				},
				SM: { 
					Something: { 
						Members: 53,
						Branches: 125,
						Cities: 521,
						Regions: 51
					},
					Awesome: { 
						Members: 623,
						Branches: 632,
						Cities: 61,
						Regions: 26
					},
					stuff: { 
						Members: 27,
						Branches: 27,
						Cities: 72,
						Regions: 27
					}
				}
			},
			currentTab: "",
			currentUnit: "",
			totalMembers: null,
			totalBusinessUnits: null,
			totalBrands: null,
			totalBranches: null
		};
	}

	componentWillMount() {
		this.calculate();
	}

	calculate() { // checks whether or not the newly added object is an empty object or not
		var isEmpty = _.isEqual(
			Object.values(this.state.businessUnits)[
				Object.keys(this.state.businessUnits).length - 1
			],
			{}
		)
			? false
			: true;

		// this calculations will calculate the total Members, Business Units, Brands, and Branches of the whole.
		var totalMembers = Object.keys(this.state.businessUnits)
			.map(unit => {
				if (Object.keys(this.state.businessUnits[unit]).length > 0) { // checks whether the length of the object is greater than 0 
					return Object.values(this.state.businessUnits[unit])  // since when you add a new brand or add a new business unit some businessUnits doesn't
						.map(brand => {								      // have anything in it and will cause an error.
							return brand["Members"];
						})
						.reduce((a, b) => {
							return a + b;
						});
				}
			})
			.filter(notUndefined => { // because you have to filter out the undefined
				return notUndefined;
			})						 
			.reduce((a, b) => {
				return a + b;
			});

		var totalBusinessUnits = Object.keys(this.state.businessUnits).length;

		var totalBrands = Object.keys(this.state.businessUnits)
			.map(unit => {
				return Object.keys(this.state.businessUnits[unit]).length;
			})
			.reduce((a, b) => {
				return a + b;
			});

		var totalBranches = Object.keys(this.state.businessUnits)
			.map(unit => {
				if (Object.keys(this.state.businessUnits[unit]).length > 0) { // checks whether the length of the object is greater than 0 
					return Object.values(this.state.businessUnits[unit]) // since when you add a new brand or add a new business unit some businessUnits doesn't
						.map(brand => { 								 // have anything in it and will cause an error.
							return brand["Branches"];
						})
						.reduce((a, b) => {
							return a + b;
						});
				}
			})
			.filter(notUndefined => { // because you have to filter out the undefined
				return notUndefined; 
			})
			.reduce((a, b) => {
				return a + b;
			});

		console.log("Total Members: ", totalMembers);
		console.log("Total Business Units: ", totalBusinessUnits);
		console.log("Total Brands: ", totalBrands);
		console.log("Total Branches: ", totalBranches);
		this.setState({
			totalBranches,
			totalBrands,
			totalBusinessUnits,
			totalMembers
		});
	}

	changeTab(e) {
		this.setState({
			currentTab: e.currentTarget.name
		});
	}

	changeBrand(e, unit) { 
		this.setState({ 
			currentTab: e.currentTarget.name,
			currentUnit: unit
		});
	}

	openAddBrand(unit) { 
		$("#add-brands").modal("show");
		this.setState({  currentUnit: unit });
	}

	addBrand(name) { 
		var businessUnits = Object.assign(this.state.businessUnits);
		var brands = Object.assign(
			this.state.businessUnits[this.state.currentUnit]
		);
		brands[name] = { 
			Members: 0,
			Branches: 0,
			Cities: 0,
			Regions: 0
		};
		businessUnits[this.state.currentUnit] = brands;
		this.setState({  businessUnits });
	}

	addBusinessUnit(name, shortcode) { 
		var businessUnits = Object.assign(this.state.businessUnits);
			businessUnits[name] = { };
		this.setState({  businessUnits });
	}

	render() { 
		return (
			<div className="main-panel">
				<Switch>
					<Route
						path={ this.props.match.url + "/view-members"}
						component={ () => (
							<ViewMembers
								{ ...this.props}
								totalMembers={ this.totalMembers }
								totalBusinessUnits={ this.totalBusinessUnits }
								totalBranches={ this.totalBranches }
								totalBrands={ this.totalBrands }
								currentTab={ this.state.currentTab }
								changeTab={ this.changeTab.bind(this) }
							/>
						) }
						exact
					/>
					<Route
						path={ this.props.match.url + "/business-units" }
						component={ () => (
							<BusinessUnits
								{ ...this.props }
								totalMembers={ this.totalMembers }
								totalBusinessUnits={ this.totalBusinessUnits }
								totalBranches={ this.totalBranches }
								totalBrands={ this.totalBrands }
								currentTab={ this.state.currentTab }
								changeTab={ this.changeTab.bind(this) }
							/>
						) }
						exact
					/>
					<Route
						path={ this.props.match.url + "/branches" }
						component={ () => (
							<Branches
								{ ...this.props }
								totalMembers={ this.totalMembers }
								totalBusinessUnits={ this.totalBusinessUnits }
								totalBranches={ this.totalBranches }
								totalBrands={ this.totalBrands }
								currentTab={ this.state.currentTab }
								currentTab={ this.state.currentTab }
								changeTab={ this.changeTab.bind(this) }
							/>
						) }
						exact
					/>
					<Route
						path={ this.props.match.url + "/brands" }
						component={ () => (
							<Brands
								{ ...this.props }
								totalMembers={ this.totalMembers }
								totalBusinessUnits={ this.totalBusinessUnits }
								totalBranches={ this.totalBranches }
								totalBrands={ this.totalBrands }
								currentTab={ this.state.currentTab }
								changeTab={ this.changeTab.bind(this) }
							/>
						) }
						exact
					/>

					<Route
						path={ this.props.match.url + "/:brands" }
						component={ () => (
							<BrandsPage
								{ ...this.props }
								currentTab={ this.state.currentTab }
								currentUnit={ this.state.currentUnit }
								businessUnits={ this.state.businessUnits }
							/>
						) }
					/>
					<Route component={ NotFound } />
				</Switch>
				<Sidebar
					currentUnit={ this.state.currentUnit }
					openAddBrand={ this.openAddBrand.bind(this) }
					addBrand={ this.addBrand.bind(this) }
					addBusinessUnit={ this.addBusinessUnit.bind(this) }
					changeTab={ this.changeTab.bind(this) }
					changeBrand={ this.changeBrand.bind(this) }
					totalMembers={ this.totalMembers }
					totalBrands={ this.totalBrands }
					currentTab={ this.state.currentTab }
					businessUnits={ this.state.businessUnits }
					{ ...this.props}
				/>
			</div>
		);
	}
}

export default connect(() => ({ }))(Page);
