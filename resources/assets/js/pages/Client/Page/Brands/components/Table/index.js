import React, { Component } from "react";
import ReactTable from "react-table";
import Toggle from "react-toggle";
import ReactTooltip from "react-tooltip";
import "./react-table.css";
import "./react-toggle.css";
import { EditBrand } from "../Modal";

const Table = props => {
    return (
        <div className="row table-container">
            <ReactTable
                data={props.data}
                columns={[
                    {
                        Header: "Brand Name",
                        accessor: "brand",
                        Cell: ({ original }) => {
                            return <div>{original.brand}</div>;
                        }
                    },

                    {
                        Header: "Business Unit",
                        accessor: "unit",
                        Cell: ({ original }) => {
                            return (
                                <div>
                                    <a data-tip={original.business_unit}> {original.business_unit} </a>
                                    <ReactTooltip place="top" type="dark" effect="float" />
                                </div>
                            );
                        }
                    },
                    {
                        Header: "Branches",
                        accessor: "branches",
                        Cell: ({ original }) => {
                            return (
                                <div>
                                    <div>{original.branches}</div>
                                </div>
                            );
                        }
                    },
                    {
                        Header: "Members",
                        accessor: "members",
                        Cell: ({ original }) => {
                            return (
                                <div>
                                    <div>{original.members}</div>
                                </div>
                            );
                        }
                    },
                    {
                        Header: "Status",
                        accessor: "status",
                        Cell: ({ row }) => {
                            return (
                                <div>
                                    <label>
                                        <Toggle
                                            checked={row.status}
                                            onChange={() => props.handleStatusChange(row._index)}
                                            icons={false}
                                        />
                                    </label>
                                </div>
                            );
                        }
                    },
                    {
                        Header: "Last Modified",
                        accessor: "modified",
                        Cell: ({ original }) => {
                            return (
                                <div>
                                    <a data-tip={original.modified_name}>
                                        {" "}
                                        {original.modified_date}{" "}
                                    </a>
                                    <ReactTooltip place="top" type="dark" effect="float" />
                                </div>
                            );
                        }
                    },
                    {
                        Header: "",
                        accessor: "edit",
                        Cell: ({ original, row }) => (
                            <div>
                                <EditBrand
                                    data={original}
                                    index={row._viewIndex}
                                    editBrand={props.editBrand}
                                />
                            </div>
                        )
                    }
                ]}
                defaultPageSize={10}
                className="-highlight"
            />
        </div>
    );
};

export default Table;
