import React, { Component } from "react";
import { connect } from "react-redux";
import { Select } from "../../../../components";
import Table from "./components/Table";
import Menu from "./components/Menu";
import Header from "../components/Header";

class ViewMembers extends Component {
	constructor(props) {
		super(props);

		this.state = {
			datas: [
				{
					id: 1,
					memberId: "1204",
					oldId: "321",
					name: "Bloodseeker",
					gender: "Male",
					birthday: "Dec. 12, 1979",
					age: null,
					addressOne: "BLK 15, St. Blessed Ville Subd.,",
					addressTwo: "Sampaloc Dasma",
					latestLocationOne: "Dasmarinas Cavite",
					latestLocationTwo: "Cavite, Cavite Area",
					hiringDate: "September 3, 2001",
					mobile: "+63917-123-1234",
					email: "rubinahammond@gmail.com",
					status: "Probationary",
					hireDate: "March 20, 2016",
					position: "Cashier",
					brand: "Mang Inasal",
					branch: "Megamall GF, Pasig City",
					disciplinaryAction: [
						{ date: "July 12, 2018", status: "Pending", done: "Theft" },
						{ date: "July 29, 2010", status: "Resolved", done: "Some Stuff" },
						{ date: "August 7, 2011", status: "Resolved", done: "Sleeping" },
						{
							date: "December 10, 2013",
							status: "Resolved",
							done: "Day Dreaming"
						}
					],
					remarks: "",
					da: <i className="fa fa-check" aria-hidden="true" />
				},
				{
					id: 2,
					memberId: "1204",
					oldId: "321",
					name: "Pudge",
					gender: "Male",
					birthday: "Dec. 12, 1979",
					age: null,
					addressOne: "BLK 15, St. Blessed Ville Subd.,",
					addressTwo: "Sampaloc Dasma",
					latestLocationOne: "Dasmarinas Cavite",
					latestLocationTwo: "Cavite, Cavite Area",
					hiringDate: "September 3, 2001",
					mobile: "+63917-123-1234",
					email: "rubinahammond@gmail.com",
					status: "Probationary",
					hireDate: "March 20, 2016",
					position: "Cashier",
					brand: "Mang Inasal",
					branch: "Megamall GF, Pasig City",
					disciplinaryAction: [
						{ date: "July 12, 2018", status: "Pending", done: "Theft" },
						{ date: "July 29, 2010", status: "Resolved", done: "Some Stuff" },
						{ date: "August 7, 2011", status: "Resolved", done: "Sleeping" },
						{
							date: "December 10, 2013",
							status: "Resolved",
							done: "Day Dreaming"
						}
					],
					remarks: "",
					da: <i className="fa fa-check" aria-hidden="true" />
				},
				{
					id: 3,
					memberId: "1204",
					oldId: "321",
					name: "Sniper",
					gender: "Male",
					birthday: "Dec. 12, 1979",
					age: null,
					addressOne: "BLK 15, St. Blessed Ville Subd.,",
					addressTwo: "Sampaloc Dasma",
					latestLocationOne: "Dasmarinas Cavite",
					latestLocationTwo: "Cavite, Cavite Area",
					hiringDate: "September 3, 2001",
					mobile: "+63917-123-1234",
					email: "rubinahammond@gmail.com",
					status: "Probationary",
					hireDate: "March 20, 2016",
					position: "Cashier",
					brand: "Mang Inasal",
					branch: "Megamall GF, Pasig City",
					disciplinaryAction: [
						{ date: "July 12, 2018", status: "Pending", done: "Theft" },
						{ date: "July 29, 2010", status: "Resolved", done: "Some Stuff" },
						{ date: "August 7, 2011", status: "Resolved", done: "Sleeping" },
						{
							date: "December 10, 2013",
							status: "Resolved",
							done: "Day Dreaming"
						}
					],
					remarks: "",
					da: <i className="fa fa-check" aria-hidden="true" />
				},
				{
					id: 4,
					memberId: "1204",
					oldId: "321",
					name: "Crystal Maiden",
					gender: "Male",
					birthday: "Dec. 12, 1979",
					age: null,
					addressOne: "BLK 15, St. Blessed Ville Subd.,",
					addressTwo: "Sampaloc Dasma",
					latestLocationOne: "Dasmarinas Cavite",
					latestLocationTwo: "Cavite, Cavite Area",
					hiringDate: "September 3, 2001",
					mobile: "+63917-123-1234",
					email: "rubinahammond@gmail.com",
					status: "Probationary",
					hireDate: "March 20, 2016",
					position: "Cashier",
					brand: "Mang Inasal",
					branch: "Megamall GF, Pasig City",
					disciplinaryAction: [
						{ date: "July 12, 2018", status: "Pending", done: "Theft" },
						{ date: "July 29, 2010", status: "Resolved", done: "Some Stuff" },
						{ date: "August 7, 2011", status: "Resolved", done: "Sleeping" },
						{
							date: "December 10, 2013",
							status: "Resolved",
							done: "Day Dreaming"
						}
					],
					remarks: "",
					da: <i className="fa fa-check" aria-hidden="true" />
				},
				{
					id: 5,
					memberId: "1204",
					oldId: "321",
					name: "Earth Shaker",
					gender: "Male",
					birthday: "Dec. 12, 1979",
					age: null,
					addressOne: "BLK 15, St. Blessed Ville Subd.,",
					addressTwo: "Sampaloc Dasma",
					latestLocationOne: "Dasmarinas Cavite",
					latestLocationTwo: "Cavite, Cavite Area",
					hiringDate: "September 3, 2001",
					mobile: "+63917-123-1234",
					email: "rubinahammond@gmail.com",
					status: "Probationary",
					hireDate: "March 20, 2016",
					position: "Cashier",
					brand: "Mang Inasal",
					branch: "Megamall GF, Pasig City",
					disciplinaryAction: [
						{ date: "July 12, 2018", status: "Pending", done: "Theft" },
						{ date: "July 29, 2010", status: "Resolved", done: "Some Stuff" },
						{ date: "August 7, 2011", status: "Resolved", done: "Sleeping" },
						{
							date: "December 10, 2013",
							status: "Resolved",
							done: "Day Dreaming"
						}
					],
					remarks: "",
					da: <i className="fa fa-check" aria-hidden="true" />
				},
				{
					id: 6,
					memberId: "1204",
					oldId: "321",
					name: "Lina",
					gender: "Male",
					birthday: "Dec. 12, 1979",
					age: null,
					addressOne: "BLK 15, St. Blessed Ville Subd.,",
					addressTwo: "Sampaloc Dasma",
					latestLocationOne: "Dasmarinas Cavite",
					latestLocationTwo: "Cavite, Cavite Area",
					hiringDate: "September 3, 2001",
					mobile: "+63917-123-1234",
					email: "rubinahammond@gmail.com",
					status: "Probationary",
					hireDate: "March 20, 2016",
					position: "Cashier",
					brand: "Mang Inasal",
					branch: "Megamall GF, Pasig City",
					disciplinaryAction: [
						{ date: "July 12, 2018", status: "Pending", done: "Theft" },
						{ date: "July 29, 2010", status: "Resolved", done: "Some Stuff" },
						{ date: "August 7, 2011", status: "Resolved", done: "Sleeping" },
						{
							date: "December 10, 2013",
							status: "Resolved",
							done: "Day Dreaming"
						}
					],
					remarks: "",
					da: <i className="fa fa-check" aria-hidden="true" />
				},
				{
					id: 7,
					memberId: "1204",
					oldId: "321",
					name: "Luna",
					gender: "Male",
					birthday: "Dec. 12, 1979",
					age: null,
					addressOne: "BLK 15, St. Blessed Ville Subd.,",
					addressTwo: "Sampaloc Dasma",
					latestLocationOne: "Dasmarinas Cavite",
					latestLocationTwo: "Cavite, Cavite Area",
					hiringDate: "September 3, 2001",
					mobile: "+63917-123-1234",
					email: "rubinahammond@gmail.com",
					status: "Probationary",
					hireDate: "March 20, 2016",
					position: "Cashier",
					brand: "Mang Inasal",
					branch: "Megamall GF, Pasig City",
					disciplinaryAction: [
						{ date: "July 12, 2018", status: "Pending", done: "Theft" },
						{ date: "July 29, 2010", status: "Resolved", done: "Some Stuff" },
						{ date: "August 7, 2011", status: "Resolved", done: "Sleeping" },
						{
							date: "December 10, 2013",
							status: "Resolved",
							done: "Day Dreaming"
						}
					],
					remarks: "",
					da: <i className="fa fa-check" aria-hidden="true" />
				},
				{
					id: 8,
					memberId: "1204",
					oldId: "321",
					name: "Slark",
					gender: "Male",
					birthday: "Dec. 12, 1979",
					age: null,
					addressOne: "BLK 15, St. Blessed Ville Subd.,",
					addressTwo: "Sampaloc Dasma",
					latestLocationOne: "Dasmarinas Cavite",
					latestLocationTwo: "Cavite, Cavite Area",
					hiringDate: "September 3, 2001",
					mobile: "+63917-123-1234",
					email: "rubinahammond@gmail.com",
					status: "Probationary",
					hireDate: "March 20, 2016",
					position: "Cashier",
					brand: "Mang Inasal",
					branch: "Megamall GF, Pasig City",
					disciplinaryAction: [
						{ date: "July 12, 2018", status: "Pending", done: "Theft" },
						{ date: "July 29, 2010", status: "Resolved", done: "Some Stuff" },
						{ date: "August 7, 2011", status: "Resolved", done: "Sleeping" },
						{
							date: "December 10, 2013",
							status: "Resolved",
							done: "Day Dreaming"
						}
					],
					remarks: "",
					da: <i className="fa fa-check" aria-hidden="true" />
				},
				{
					id: 9,
					memberId: "1204",
					oldId: "321",
					name: "Tide Hunter",
					gender: "Male",
					birthday: "Dec. 12, 1979",
					age: null,
					addressOne: "BLK 15, St. Blessed Ville Subd.,",
					addressTwo: "Sampaloc Dasma",
					latestLocationOne: "Dasmarinas Cavite",
					latestLocationTwo: "Cavite, Cavite Area",
					hiringDate: "September 3, 2001",
					mobile: "+63917-123-1234",
					email: "rubinahammond@gmail.com",
					status: "Probationary",
					hireDate: "March 20, 2016",
					position: "Cashier",
					brand: "Mang Inasal",
					branch: "Megamall GF, Pasig City",
					disciplinaryAction: [
						{ date: "July 12, 2018", status: "Pending", done: "Theft" },
						{ date: "July 29, 2010", status: "Resolved", done: "Some Stuff" },
						{ date: "August 7, 2011", status: "Resolved", done: "Sleeping" },
						{
							date: "December 10, 2013",
							status: "Resolved",
							done: "Day Dreaming"
						}
					],
					remarks: "",
					da: <i className="fa fa-check" aria-hidden="true" />
				},
				{
					id: 10,
					memberId: "1204",
					oldId: "321",
					name: "Tinker",
					gender: "Male",
					birthday: "Dec. 12, 1979",
					age: null,
					addressOne: "BLK 15, St. Blessed Ville Subd.,",
					addressTwo: "Sampaloc Dasma",
					latestLocationOne: "Dasmarinas Cavite",
					latestLocationTwo: "Cavite, Cavite Area",
					hiringDate: "September 3, 2001",
					mobile: "+63917-123-1234",
					email: "rubinahammond@gmail.com",
					status: "Probationary",
					hireDate: "March 20, 2016",
					position: "Cashier",
					brand: "Mang Inasal",
					branch: "Megamall GF, Pasig City",
					disciplinaryAction: [
						{ date: "July 12, 2018", status: "Pending", done: "Theft" },
						{ date: "July 29, 2010", status: "Resolved", done: "Some Stuff" },
						{ date: "August 7, 2011", status: "Resolved", done: "Sleeping" },
						{
							date: "December 10, 2013",
							status: "Resolved",
							done: "Day Dreaming"
						}
					],
					remarks: "",
					da: <i className="fa fa-check" aria-hidden="true" />
				},
				{
					id: 11,
					memberId: "1204",
					oldId: "321",
					name: "Phantom Assassin",
					gender: "Male",
					birthday: "Dec. 12, 1979",
					age: null,
					addressOne: "BLK 15, St. Blessed Ville Subd.,",
					addressTwo: "Sampaloc Dasma",
					latestLocationOne: "Dasmarinas Cavite",
					latestLocationTwo: "Cavite, Cavite Area",
					hiringDate: "September 3, 2001",
					mobile: "+63917-123-1234",
					email: "rubinahammond@gmail.com",
					status: "Probationary",
					hireDate: "March 20, 2016",
					position: "Cashier",
					brand: "Mang Inasal",
					branch: "Megamall GF, Pasig City",
					disciplinaryAction: [
						{ date: "July 12, 2018", status: "Pending", done: "Theft" },
						{ date: "July 29, 2010", status: "Resolved", done: "Some Stuff" },
						{ date: "August 7, 2011", status: "Resolved", done: "Sleeping" },
						{
							date: "December 10, 2013",
							status: "Resolved",
							done: "Day Dreaming"
						}
					],
					remarks: "",
					da: <i className="fa fa-check" aria-hidden="true" />
				},
				{
					id: 12,
					memberId: "1204",
					oldId: "321",
					name: "Io",
					gender: "Male",
					birthday: "Dec. 12, 1979",
					age: null,
					addressOne: "BLK 15, St. Blessed Ville Subd.,",
					addressTwo: "Sampaloc Dasma",
					latestLocationOne: "Dasmarinas Cavite",
					latestLocationTwo: "Cavite, Cavite Area",
					hiringDate: "September 3, 2001",
					mobile: "+63917-123-1234",
					email: "rubinahammond@gmail.com",
					status: "Probationary",
					hireDate: "March 20, 2016",
					position: "Cashier",
					brand: "Mang Inasal",
					branch: "Megamall GF, Pasig City",
					disciplinaryAction: [
						{ date: "July 12, 2018", status: "Pending", done: "Theft" },
						{ date: "July 29, 2010", status: "Resolved", done: "Some Stuff" },
						{ date: "August 7, 2011", status: "Resolved", done: "Sleeping" },
						{
							date: "December 10, 2013",
							status: "Resolved",
							done: "Day Dreaming"
						}
					],
					remarks: "",
					da: <i className="fa fa-check" aria-hidden="true" />
				},
				{
					id: 13,
					memberId: "1204",
					oldId: "321",
					name: "Drow Ranger",
					gender: "Male",
					birthday: "Dec. 12, 1979",
					age: null,
					addressOne: "BLK 15, St. Blessed Ville Subd.,",
					addressTwo: "Sampaloc Dasma",
					latestLocationOne: "Dasmarinas Cavite",
					latestLocationTwo: "Cavite, Cavite Area",
					hiringDate: "September 3, 2001",
					mobile: "+63917-123-1234",
					email: "rubinahammond@gmail.com",
					status: "Probationary",
					hireDate: "March 20, 2016",
					position: "Cashier",
					brand: "Mang Inasal",
					branch: "Megamall GF, Pasig City",
					disciplinaryAction: [
						{ date: "July 12, 2018", status: "Pending", done: "Theft" },
						{ date: "July 29, 2010", status: "Resolved", done: "Some Stuff" },
						{ date: "August 7, 2011", status: "Resolved", done: "Sleeping" },
						{
							date: "December 10, 2013",
							status: "Resolved",
							done: "Day Dreaming"
						}
					],
					remarks: "",
					da: <i className="fa fa-check" aria-hidden="true" />
				},
				{
					id: 14,
					memberId: "1204",
					oldId: "321",
					name: "Abaddon",
					gender: "Male",
					birthday: "Dec. 12, 1979",
					age: null,
					addressOne: "BLK 15, St. Blessed Ville Subd.,",
					addressTwo: "Sampaloc Dasma",
					latestLocationOne: "Dasmarinas Cavite",
					latestLocationTwo: "Cavite, Cavite Area",
					hiringDate: "September 3, 2001",
					mobile: "+63917-123-1234",
					email: "rubinahammond@gmail.com",
					status: "Probationary",
					hireDate: "March 20, 2016",
					position: "Cashier",
					brand: "Mang Inasal",
					branch: "Megamall GF, Pasig City",
					disciplinaryAction: [
						{ date: "July 12, 2018", status: "Pending", done: "Theft" },
						{ date: "July 29, 2010", status: "Resolved", done: "Some Stuff" },
						{ date: "August 7, 2011", status: "Resolved", done: "Sleeping" },
						{
							date: "December 10, 2013",
							status: "Resolved",
							done: "Day Dreaming"
						}
					],
					remarks: "",
					da: <i className="fa fa-check" aria-hidden="true" />
				},
				{
					id: 15,
					memberId: "1204",
					oldId: "321",
					name: "Rubina J Hammond",
					gender: "Male",
					birthday: "Dec. 12, 1979",
					age: null,
					addressOne: "BLK 15, St. Blessed Ville Subd.,",
					addressTwo: "Sampaloc Dasma",
					latestLocationOne: "Dasmarinas Cavite",
					latestLocationTwo: "Cavite, Cavite Area",
					hiringDate: "September 3, 2001",
					mobile: "+63917-123-1234",
					email: "rubinahammond@gmail.com",
					status: "Probationary",
					hireDate: "March 20, 2016",
					position: "Cashier",
					brand: "Mang Inasal",
					branch: "Megamall GF, Pasig City",
					disciplinaryAction: [
						{ date: "July 12, 2018", status: "Pending", done: "Theft" },
						{ date: "July 29, 2010", status: "Resolved", done: "Some Stuff" },
						{ date: "August 7, 2011", status: "Resolved", done: "Sleeping" },
						{
							date: "December 10, 2013",
							status: "Resolved",
							done: "Day Dreaming"
						}
					],
					remarks: "",
					da: <i className="fa fa-check" aria-hidden="true" />
				},
				{
					id: 16,
					memberId: "1204",
					oldId: "321",
					name: "Rubina J Hammond",
					gender: "Male",
					birthday: "Dec. 12, 1979",
					age: null,
					addressOne: "BLK 15, St. Blessed Ville Subd.,",
					addressTwo: "Sampaloc Dasma",
					latestLocationOne: "Dasmarinas Cavite",
					latestLocationTwo: "Cavite, Cavite Area",
					hiringDate: "September 3, 2001",
					mobile: "+63917-123-1234",
					email: "rubinahammond@gmail.com",
					status: "Probationary",
					hireDate: "March 20, 2016",
					position: "Cashier",
					brand: "Mang Inasal",
					branch: "Megamall GF, Pasig City",
					disciplinaryAction: [
						{ date: "July 12, 2018", status: "Pending", done: "Theft" },
						{ date: "July 29, 2010", status: "Resolved", done: "Some Stuff" },
						{ date: "August 7, 2011", status: "Resolved", done: "Sleeping" },
						{
							date: "December 10, 2013",
							status: "Resolved",
							done: "Day Dreaming"
						}
					],
					remarks: "",
					da: <i className="fa fa-check" aria-hidden="true" />
				}
			],
			currentDatum: {},
			selectStatus: [
				{ value: "Probationary", display: "Probationary" },
				{ value: "Training", display: "Training" },
				{ value: "Seasonal", display: "Seasonal" }
			],
			selectReasonForLeaving: [
				{ value: "Sleeping", display: "Sleeping" },
				{ value: "Daydream", display: "Daydream" },
				{ value: "Sit", display: "Sit" }
			],
			selectClients: [{ value: "Client 1", display: "Client 1" }],
			selectBrands: [{ value: "Brand 1", display: "Brand 1" }],
			selectBranches: [{ value: "Branch 1", display: "Branch 1" }],
			selectPositions: [{ value: "Position 1", display: "Position 1" }],
			selectMenuLocation: [
				{ value: "SAL", display: "Show All Locations" },
				{ value: "BCL", display: "Bicol" },
				{ value: "MNL", display: "Manila" },
				{ value: "QC", display: "Quezon City" }
			],
			selectMenuBrand: [{ value: "SAB", display: "Show All Brands" }],
			selectMenuGender: [
				{ value: "0", display: "Male" },
				{ value: "1", display: "Female" }
			],
			selectMenuStatus: [
				{ value: "0", display: "All Status" },
				{ value: "1", display: "All Enabled" },
				{ value: "2", display: "All Disabled" }
			],
			selectMenuPosition: [
				{ value: "AP", display: "All Position" },
				{ value: "CR", display: "Cashier" },
				{ value: "DR", display: "Driver" }
			]
		};
	}

	actionsModal(e) {
		var memberModal = this.state.datas[e.target.id - 1];
		this.setState({ memberModal });
		$(`#${e.currentTarget.value}`).modal("show");
		e.currentTarget.value = "";
	}

	quickViewMemberModal(currentDatum) {
		this.setState({ currentDatum });
		$("#quick-view-member").modal("show");
	}

	render() {
		return (
			<div className="col-10 offset-2 right-panel-clientpage">
				<Header
					totalMembers={this.props.totalMembers}
					totalBusinessUnits={this.props.totalBusinessUnits}
					totalBranches={this.props.totalBranches}
					totalBrands={this.props.totalBrands}
					changeTab={this.props.changeTab}
					{...this.props}
				/>
				<div className="client-container-clientpage">
					<div className="row breadcrumbs">
						<div className="client-breadcrumb"> Clients&emsp;></div>
						<div className="client-breadcrumb"> JFC&emsp;></div>
						<div className="client-breadcrumb breadcrumb-active">
							{this.props.currentTab}
						</div>
					</div>
					<Menu
						selectMenuLocation={this.state.selectMenuLocation}
						selectMenuBrand={this.state.selectMenuBrand}
						selectMenuGender={this.state.selectMenuGender}
						selectMenuStatus={this.state.selectMenuStatus}
						selectMenuPosition={this.state.selectMenuPosition}
					/>
					<Table
						selectStatus={this.state.selectStatus}
						selectReasonForLeaving={this.state.selectReasonForLeaving}
						selectBranches={this.state.selectBranches}
						selectBrands={this.state.selectBrands}
						selectClients={this.state.selectClients}
						selectPositions={this.state.selectPositions}
						actionsModal={this.actionsModal.bind(this)}
						currentDatum={this.state.currentDatum}
						quickViewMemberModal={this.quickViewMemberModal.bind(this)}
					/>
				</div>
			</div>
		);
	}
}

export default connect(() => ({}))(ViewMembers);
