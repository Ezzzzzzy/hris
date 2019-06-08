import React, { Component } from "react";
import Header from "../components/Header";
import { Table, Menu } from "./components";

class BusinessUnits extends Component {
    constructor(props) {
        super(props);
        this.state = {
            data: [
                {
                    id: 1,
                    business_unit_name: "Retail Group",
                    code: "RG",
                    brands: 12,
                    members: 210,
                    status: true,
                    last_modified: "Oct.12, 2017"
                },
                {
                    id: 2,
                    business_unit_name: "Industrial Services",
                    code: "IS",
                    brands: 4,
                    members: 53,
                    status: true,
                    last_modified: "Oct.12, 2017"
                },
                {
                    id: 3,
                    business_unit_name: "New Ventures",
                    code: "NV",
                    brands: 10,
                    members: 6,
                    status: true,
                    last_modified: 'Oct.12, 2017'
                },
                {
                    id: 4,
                    business_unit_name: "Concept Stores",
                    code: "CS",
                    brands: 2,
                    members: 0,
                    status: true,
                    last_modified: "Oct.12, 2017"
                }
            ]
        }
    }

    handleStatusChange(id) {
        let data = this.state.data;
        let targetData = data.find(businessUnit => businessUnit.id === id);
        targetData.status = !targetData.status;
        this.setState({ data });
    }

    addBusinessUnit(businessUnit) {
        let newData = {};
        newData["id"] = this.state.data.length + 1;
        newData["business_unit_name"] = businessUnit["business_unit_name"];
        newData["code"] = businessUnit["code"].toUpperCase();
        newData["brands"] = 0;
        newData["members"] = 0;
        newData["status"] = true;
        newData["last_modified"] = this.getDateToday();
        this.setState({ data: [...this.state.data, newData] });
    }

    editBusinessUnit(businessUnit) {
        let data = this.state.data;
        let targetData = data.find(data => data.id === businessUnit.id);
        targetData.business_unit_name = businessUnit["business_unit_name"];
        targetData.code = businessUnit["code"].toUpperCase();
        targetData.last_modified = this.getDateToday();
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
                    <Menu addBusinessUnit={this.addBusinessUnit.bind(this)} />
                    <Table
                        data={this.state.data}
                        handleStatusChange={this.handleStatusChange.bind(this)}
                        editBusinessUnit={this.editBusinessUnit.bind(this)} />
                </div>
            </div>
        );
    }
}

export default BusinessUnits;
