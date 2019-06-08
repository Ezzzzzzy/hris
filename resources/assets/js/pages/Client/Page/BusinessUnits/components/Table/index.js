import React from "react";
import Toggle from "react-toggle";
import ReactTooltip from "react-tooltip";
import ReactTable from "react-table";
import { EditBusinessUnit } from '../Modal';
import "./toggle.css";

const memberProfile = b => (b === 1 ? subdata : hidden);

const Table = props => {
    return (
        <div className="row table-container">
            <ReactTooltip />
            <ReactTable
                data={props.data}
                columns={[
                    {
                        Header: "Business Unit Name",
                        accessor: "business_unit_name",
                        Cell: ({ original }) => {
                            return (
                                <div>{original.business_unit_name}</div>
                            );
                        }
                    },
                    {
                        Header: "Short Code",
                        accessor: "code",
                        Cell: ({ original }) => {
                            return (
                                <div>{original.code}</div>
                            );
                        }
                    },
                    {
                        Header: "Brands",
                        accessor: "brands",
                        Cell: ({ original }) => {
                            return (
                                <div>{original.brands}</div>
                            );
                        }
                    },
                    {
                        Header: "Members",
                        accessor: "members",
                        Cell: ({ original }) => {
                            return (
                                <div>{original.members}</div>
                            );
                        }
                    },
                    {
                        Header: "Status",
                        accessor: "status",
                        sortable: false,
                        Cell: ({ original }) => {
                            return (
                                <label>
                                    <Toggle
                                        checked={original.status}
                                        onChange={() => props.handleStatusChange(original.id)}
                                        icons={false} />
                                </label>
                            );
                        }
                    },
                    {
                        Header: "Last Modified",
                        accessor: "last_modified",
                        Cell: ({ original }) => {
                            return (
                                <div data-tip="Jessie Gubadao">{original.last_modified}</div>
                            );
                        }
                    },
                    {
                        Header: "",
                        accessor: "",
                        sortable: false,
                        Cell: ({ original }) => {
                            return (
                                <EditBusinessUnit
                                    data={original}
                                    editBusinessUnit={props.editBusinessUnit} />
                            );
                        }
                    }
                ]}
                defaultPageSize={10}
                className="-highlight" />
        </div>
    );
};

export default Table;
