import React, { Component } from "react";
import { AddBusinessUnit } from "../Modal";
import { Select } from "../../../../../../components";

const options = [
    { name: "All" },
    { name: "All Enabled" },
    { name: "All Disabled" }
];

class Menu extends Component {
    constructor(props) {
        super(props);
        this.state = {
            filter: "All",
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

    handleFilterChange(filter) {
        this.setState({ filter }, () =>
            console.log("filtered data: ", this.state.filter)
        );
        //request filtered data through api
    }

    render() {
        return (
            <div className="row table-components select-row">
                <div className="col-5 col-left">
                    <div className="row">
                        <div className="col-6">
                            <Select
                                value={this.state.filter}
                                options={options}
                                optionValue="name"
                                display="name"
                                selectValue={this.state.filter}
                                onChange={e => this.handleFilterChange(e.target.value)}
                            />
                        </div>
                        <div className="offset-6" />
                    </div>
                </div>
                <div className="col-7 col-right padding-right-5">
                    <div className="row">
                        <div className="col-7 offset-1 padding-right-0">
                            <form onSubmit={e => this.onSearchSubmit(e)}>
                                <div className="row">
                                    <div className="col-10 search-container">
                                        <input
                                            className="form-control search-input pull-left no-outline"
                                            placeholder="Search"
                                            value={this.state.searchTerm}
                                            onChange={(e) => this.handleSearchChange(e.target.value)}
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
                            <AddBusinessUnit addBusinessUnit={this.props.addBusinessUnit} />
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default Menu;
