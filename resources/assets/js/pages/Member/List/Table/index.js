import React from "react";
import { Link } from 'react-router-dom';
import ReactTable from "react-table";
import member_style from '../member_style';
import "./react-table.css";

const Table = props => {
    return (
        <ReactTable
            data={ props.data ? props.data : [] }
            defaultPageSize={10}
            loading={ props.loading }
            pages={ props.pages }
            manual
            onPageChange={ i => {
                let { filters, limit, current_page, next_page, prev_page } = props;
                let obj = { 
                    complete: filters.complete, 
                    filters: filters.filters,
                    limit: limit,
                };
                obj.page = (++i >= current_page) ? next_page : prev_page;

                props.onSubmit(props.memberAction.filter(obj));
            }}
            onPageSizeChange={size=>{
                let { filters } = props;
                let obj = { comlete: filters.complete, filters: filters.filters };
                obj.limit = size;
                props.onSubmit(props.memberAction.filter(obj));
            }}
            columns={[
                {
                    Header: "ID",
                    accessor: "id",
                    Cell: ({original}) => {
                        return(
                            <div style={member_style.soloDiv}>
                                <div> { original.id } </div>
                            </div>
                        )
                    }
                },
                {
                    Header: "Name",
                    accessor: "name",
                    Cell: ({original}) => {
                        return(
                            <div>
                                <div style={member_style.memberName}>
                                    { `${original.first_name} ${original.middle_name} ${original.last_name}` }
                                </div> 
                                <div style={member_style.subdata}>
                                    { 
                                        (original.data_completion !== 1) && 'Incomplete Profile'
                                    }
                                </div>
                            </div>
                        )
                    }
                },
                {
                    Header: "Position",
                    accessor: "position",
                    Cell: ({original}) => {
                        return(
                            <div>
                                <div> { original.bwh ? original.bwh.position : '---' } </div> 
                                <div style={member_style.subdata2}>
                                    { 
                                        original.bwh ? `${original.bwh.brand}, ${original.bwh.business_unit}` : null
                                    }
                                </div>
                            </div>
                        )
                    }
                },
                {
                    Header: "Location",
                    accessor: "location",
                    Cell: ({original}) => {
                        return(
                            <div>
                                <div>{ original.bwh && original.bwh.location }</div> 
                                <div style={member_style.subdata2}>
                                    { 
                                        original.bwh
                                            && original.bwh.bwh_id
                                                ? `${original.bwh.region} ${original.bwh.city}`
                                                : '---'
                                    }
                                </div>
                            </div>
                        )
                    }
                },
                {
                    Header: "Hiring Date",
                    Cell: ({original}) => {
                        return(
                            <div>
                                <div>{ original.bwh ? original.bwh.date_start : '---' }</div> 
                                <div style={member_style.subdata2}> 
                                 {
                                    original.bwh && original.bwh.time_difference
                                 }
                                </div>
                            </div>
                        )
                    }
                },
                {
                    Header: "Status",
                    accessor: "status",
                    Cell: ({original}) => {
                        const status = original ? original.employment_status : '---';
                        return (
                            <div style={member_style.statusDiv}>
                                <span 
                                    className='badge'
                                    style={{
                                        ...member_style.employmentStatus,
                                        backgroundColor: `${ (status !== '---') 
                                            ? original.status_color
                                            : 'transparent'}`
                                    }}>
                                    { status }
                                </span> 
                            </div>
                        )
                    }
                },
                {
                    Header: "Last Modified",
                    accessor: "lastModified",
                    Cell: ({original}) => {
                        return(
                            <div >
                                <div >
                                    { original.updated_at }
                                </div> 
                                <div style={member_style.subdata2}>
                                    { original.last_modified_by }
                                </div>
                            </div>
                        )
                    }
                },
                {
                    Header: "",
                    accessor: "manageBtn",
                    Cell: ({original}) => {
                        return (
                            <div style={member_style.buttonsDiv}>
                                <Link to={`/members/profile/${original.id}`}>
                                    <i className="fa fa-sign-out-alt"></i> View
                                </Link>

                                <Link to={`/members/edit/${original.id}`}>
                                    <i className="fa fa-edit"></i> Edit
                                </Link>
                            </div>

                        )
                    }
                },
            ]}
            className="-highlight"
        />
    );
}

export default Table;