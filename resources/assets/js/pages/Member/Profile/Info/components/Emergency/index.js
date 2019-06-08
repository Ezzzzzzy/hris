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
                    <th id="dataHead">{ val.name }</th>
                    <td id='dataBody'>{ val.relationship }</td>
                    <td id="dataBody">{ val.address }</td>
                    <td id="dataBody">{ val.contact }</td>
                </tr>
        );
    })
)

const Emergency = (props) => {
    return (
        <div className="row">
            <Blockquote title='In Case of Emergency' id='emergency_id' />

            <div className="col-6">
                <div className="card" id="">
                    <table className="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Relationship</th>
                                <th>Address</th>
                                <th>Contact Number</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            {
                                 (props.data.emergency_data && props.data.emergency_data.length !== 0)
                                    ? <Rows list={ props.data.emergency_data } {...props}/>
                                    : <EmptyRow/>
                            }
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
}

export default Emergency;