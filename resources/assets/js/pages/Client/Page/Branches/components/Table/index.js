import React, { Component } from "react";
import { render } from "react-dom";
import Toggle from "react-toggle";
import ReactTable from "react-table";
import ReactTooltip from "react-tooltip";
import { EditBranch } from "../Modal";

import "./react-table.css";
import "react-toggle/style.css";

const Table = props => {
    let { header, data } = props;

    const columns = [
        {
            Header: "Branch Name",
            accessor: "branch_name"
        },
        {
            Header: "Location",
            accessor: "location"
        },
        {
            Header: "City",
            accessor: "city"
        },
        {
            Header: "Region",
            accessor: "region"
        },
        {
            Header: "Members",
            accessor: "members"
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
            accessor: "last_modified",
            Cell: props => {
                return (
                    <div>
                        <div data-tip="Reese Lansangan">{props.original.last_modified}</div>
                        <ReactTooltip place="top" type="dark" effect="solid" />
                    </div>
                );
            }
        },
        {
            Header: "",
            accessor: "edit",
            Cell: ({ row }) => {
                return (
                    <EditBranch
                        editBranch={props.editBranch}
                        data={row}
                    />
                );
            }
        }
    ];

    return (
        <ReactTable
            data={props.data}
            columns={columns}
            defaultPageSize={10}
            className="-highlight"
        />
    );
};

export default Table;
