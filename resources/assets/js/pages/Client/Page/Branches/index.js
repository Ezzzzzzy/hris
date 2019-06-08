import React, { Component } from "react";
import Header from "../components/Header";
import Table from "./components/Table";
import { Menu } from "./components";

class Branches extends Component {
    constructor(props) {
        super(props);
        this.state = {
            data: [
                {
                    branch_name: "JolliYeezy",
                    location: "Batasan",
                    city: "Quezon City",
                    region: "NCR",
                    members: 23,
                    status: true,
                    last_modified: "Oct 14, 2017"
                },
                {
                    branch_name: "McDonuts",
                    location: "Malate",
                    city: "Manila",
                    region: "NCR",
                    members: 23,
                    status: true,
                    last_modified: "Jan 05, 2017"
                },
                {
                    branch_name: "Okay If Sea",
                    location: "Burgos",
                    city: "Dagupan",
                    region: "Region I",
                    members: 44,
                    status: true,
                    last_modified: "June 22, 2017"
                },
                {
                    branch_name: "Mang Kakasal",
                    location: "Intramuros",
                    city: "Manila",
                    region: "NCR",
                    members: 1,
                    status: true,
                    last_modified: "February 27, 2017"
                }
            ],
            filters: {
                filterStatus: "",
                filterRegion: "",
                filterCity: ""
            },
            searchTerm: ""
        };
    }

    handleStatusChange(i) {
        let data = this.state.data;
        data[i].status = !data[i].status;
        this.setState({ data });
    }

    addBranch(branch) {
        let newData = {};
        newData["branch_name"] = branch["branch_name"];
        newData["location"] = branch["location"];
        newData["city"] = branch["city"];
        newData["region"] = branch["region"];
        newData["members"] = 0;
        newData["status"] = true;
        newData["last_modified"] = this.getDateToday();
        this.setState({ data: [...this.state.data, newData] });
    }

    getDateToday() {
        const month = ["Jan", "Feb", "Mar", "Apr", "May",
            "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        var today = new Date();
        var dd = today.getDate();
        var mm = month[today.getMonth()];
        var yyyy = today.getFullYear();
        return mm + "." + dd + ", " + yyyy;
    }

    editBranch(branch) {
        let data = this.state.data;
        let i = branch.index;
        data[i].branch_name = branch.branch_name;
        data[i].location = branch.location;
        data[i].city = branch.city;
        data[i].region = branch.region;
        data[i].last_modified = this.getDateToday();
        this.setState({ data });
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
                    <Menu addBranch={this.addBranch.bind(this)} />
                    <div className="row table-container">
                        <Table
                            handleStatusChange={this.handleStatusChange.bind(this)}
                            className={"table-container"}
                            data={this.state.data}
                            editBranch={this.editBranch.bind(this)}
                        />
                    </div>
                </div>
            </div>
        );
    }
}

export default Branches;
