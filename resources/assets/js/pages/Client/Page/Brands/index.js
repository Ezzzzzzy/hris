import React, { Component } from "react";
import Table from "./components/Table";
import Menu from "./components/Menu";
import { Select, TextInput } from "../../../../components";
import Header from "../components/Header";

class Brands extends Component {
    constructor(props) {
        super(props);

        this.state = {
            data: [
                {
                    brand: "Jollibee",
                    business_unit: "RG",
                    branches: "1,120",
                    members: 0,
                    status: true,
                    modified_date: "October 12, 2017",
                    modified_name: "Daryl Sinon"
                },
                {
                    brand: "Mang Inasal",
                    business_unit: "RG",
                    branches: "30",
                    members: 1,
                    status: true,
                    modified_date: "May 12, 2018",
                    modified_name: "Daryl Sinon"
                },
                {
                    brand: "ABC",
                    business_unit: "RG",
                    branches: "30",
                    members: 1,
                    status: true,
                    modified_date: "May 12, 2018",
                    modified_name: "Daryl Sinon"
                },
                {
                    brand: "ZALALA",
                    business_unit: "RG",
                    branches: "30",
                    members: 1,
                    status: true,
                    modified_date: "May 12, 2018",
                    modified_name: "Daryl Sinon"
                }
            ]
        };
    }

    addBrand(value) {
        let data = {};
        data["brand"] = value.brand;
        data["business_unit"] = value.business_unit;
        data["branches"] = value.branches;
        data["members"] = value.members;
        data["status"] = value.status;
        data["modified_date"] = this.getDateToday();
        data["modified_name"] = value.modified_name;
        this.setState({ data: [...this.state.data, data] });
    }

    editBrand(brand, i) {
        let data = this.state.data;
        data[i].brand = brand.brand;
        data[i].business_unit = brand.business_unit;
        data[i].last_modified = this.getDateToday();
        this.setState({ data });
    }

    getDateToday() {
        const month = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
            "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        var today = new Date();
        var dd = today.getDate();
        var mm = month[today.getMonth()];
        var yyyy = today.getFullYear();
        return mm + "." + dd + ", " + yyyy;
    }

    handleStatusChange(i) {
        let data = this.state.data;
        data[i].status = !data[i].status;
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
                    <Menu addBrand={this.addBrand.bind(this)} />
                    <Table
                        editBrand={this.editBrand.bind(this)}
                        handleStatusChange={this.handleStatusChange.bind(this)}
                        rowHeight={50}
                        rowsCount={10}
                        data={this.state.data}
                    />
                </div>
            </div>
        );
    }
}
export default Brands;
