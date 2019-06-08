import React, { Component } from "react";
import { Select } from "../../../../../../components";
import AddBrand from "../../components/Modal/AddBrand";

const status = [
    { name: "All" },
    { name: "All Enabled" },
    { name: "All Disabled" }
];

const businessUnit = [
    { name: "Food Groups" },
    { name: "Pool Groups" },
    { name: "Cool Groups" }
];

class Menu extends Component {
    constructor(props) {
        super(props);
        this.state = {
            filters: {
                status: "",
                businessUnit: "",
            },
            searchTerm: ""
        };
    }

    handleSearchChange(searchTerm) {
        this.setState({ searchTerm });
    }

    onSearchSubmit(e) {
        e.preventDefault();
        //request searched data through api
        console.log("searched data: ", this.state.searchTerm);
    }

    handleFilterChange(filter, props) {
        let filters = this.state.filters;
        filters[props] = filter;
        this.setState({ filters });
        //request filtered data through api
        console.log(this.state.filters);
    }

    render() {
        return (
            <div className="row table-components select-row">
                <div className="col-5 col-left">
                    <div className="row">
                        <div className="col-6">
                            <Select
                                id={"id"}
                                optionValue={"value"}
                                options={status}
                                display={"name"}
                                value={"name"}
                                onChange={e => this.handleFilterChange(e.target.value, "status")}
                            />
                        </div>
                        <div className="col-6">
                            <Select
                                id={"id"}
                                optionValue={"value"}
                                options={businessUnit}
                                display={"name"}
                                value={"name"}
                                onChange={e => this.handleFilterChange(e.target.value, "businessUnit")}
                            />
                        </div>
                    </div>
                </div>
                <div className="col-7 col-right padding-right-5">
                    <div className="row">
                        <div className="col-7 offset-1 padding-right-0">
                            <form onSubmit={(e) => this.onSearchSubmit(e)}>
                                <div className="row">
                                    <div className="col-10 search-container">
                                        <input
                                            className="form-control search-input pull-left no-outline"
                                            placeholder="Search"
                                            onChange={e => this.handleSearchChange(e.target.value)}
                                        />
                                    </div>
                                    <div className="col-2 search-container">
                                        <button className="btn search-button no-outline" type="submit">
                                            <i className="fa fa-search" />
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div className="col-4 padding-left-4">
                            <AddBrand addBrand={this.props.addBrand} />
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default Menu;
