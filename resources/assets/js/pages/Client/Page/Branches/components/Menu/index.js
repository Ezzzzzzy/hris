import React, { Component } from "react";
import { AddBranch } from '../Modal';
import { Select } from "../../../../../../components";

let options = {
    status: [
        { name: "All" },
        { name: "All Enabled" },
        { name: "All Disabled" }
    ],
    region: [
        { name: 'NCR' },
        { name: 'Region I' }
    ],
    city: [
        { name: 'Quezon City' },
        { name: 'Manila' },
        { name: 'Dagupan' }
    ]
};

class Menu extends Component {
    constructor(props) {
        super(props);
        this.state = {
            filters: {
                status: "",
                region: "",
                city: ""
            },
            searchTerm: ''
        };
    }

    onSearchSubmit(e) {
        e.preventDefault();
        //request filtered data through api
        console.log(this.state.searchTerm);
    }

    handleFilterChange(filter, props) {
        let filters = this.state.filters;
        filters[props] = filter;
        this.setState({ filters });
        //request filtered data through api
        console.log(this.state.filters);
    }

    handleInputChange(value) {
        let searchTerm = this.state.searchTerm;
        searchTerm = value;
        this.setState({ searchTerm });
    }

    render() {
        return (
            <div className="row table-components select-row">
                <div className="col-5 col-left">
                    <div className="row">
                        <div className="col-4">
                            <Select
                                optionValue="name"
                                display="name"
                                options={options.status}
                                name="status"
                                onChange={(e) => this.handleFilterChange(e.target.value, "status")}
                            />
                        </div>
                        <div className="col-4">
                            <Select
                                optionValue="name"
                                display="name"
                                options={options.region}
                                name="region"
                                onChange={(e) => this.handleFilterChange(e.target.value, "region")}
                            />
                        </div>
                        <div className="col-4">
                            <Select
                                optionValue="name"
                                display="name"
                                options={options.city}
                                name="city"
                                onChange={(e) => this.handleFilterChange(e.target.value, "city")}
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
                                            type="search"
                                            placeholder="Search"
                                            aria-label="Search"
                                            onChange={(e) => this.handleInputChange(e.target.value)}
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
                            <AddBranch addBranch={this.props.addBranch} />
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default Menu;