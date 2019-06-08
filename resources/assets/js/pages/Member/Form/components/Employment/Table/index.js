import React from 'react';
import DeleteButton from  '../../../../../../components/Button/DeleteButton/index';

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
                <td id="dataBody"> {`${val.started_at.toLocaleString("en-us", dateFormat)} - ${val.ended_at.toLocaleString("en-us", dateFormat)}`} </td>
                <td id="dataBody"> { val.reason_for_leaving } </td>
                <td>
                    <DeleteButton onClick={ () => props.deleteEmployment(i)} title={'Delete Button'} name={'X'} />
                </td>
            </tr> 
        );
    })
)

const dateFormat = {
    day:   'numeric',
    year:  'numeric',
    month: 'long',
}

const Table = (props) => {
    let { list, isError } = props;

    return (
        <div className="row">
            <div className="col-6 offset-3">
                {
                    isError && <span style={{color: `red`}}>Atleast 1 is required</span>
                }
                <div className="card">
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
                                (list.length !== 0)
                                    ? <Rows {...props}/>
                                    : <EmptyRow/>
                            }
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
}

export default Table;
