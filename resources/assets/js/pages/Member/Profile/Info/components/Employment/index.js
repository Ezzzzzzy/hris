import React from 'react';
import { Blockquote } from '../../../../../../components';

const EmptyRow = () => (
    <tr>
        <td colSpan="4">
            <center>
                <span id="dataHead">Add atleast one Employment History</span>
            </center>
        </td>
    </tr>
)

const Rows = ({list, ...props}) => (
    list.map((val,i)=>{
        return (
                <tr key={i}>
                <th scope="row" id="dataHead"> { val.company_name } </th>
                <td id="dataBody"> { val. position} </td>
                <td id="dataBody"> {`${val.started_at} - ${val.ended_at}`} </td>
                <td id="dataBody"> { val.reason_for_leaving } </td>
            </tr> 
        );
    })
)

const Employment = (props) => {
    return (
        <div className="row">
            <Blockquote title='Employment History' id='emploment_hist_id' />

            <div className="col-6">
                <div className="card" id="">
                    <table className="table">
                        <thead>
                            <tr>
                                <th scope="col">Company</th>
                                <th scope="col">Position</th>
                                <th scope="col">Inclusive Dates</th>
                                <th scope="col">Reason for Leaving</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            {
                                 (props.data.emp_history_data && props.data.emp_history_data.length !== 0)
                                    ? <Rows list={ props.data.emp_history_data } {...props}/>
                                    : <EmptyRow/>
                            }
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
}

export default Employment;