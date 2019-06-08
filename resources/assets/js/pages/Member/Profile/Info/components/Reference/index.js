import React , { Component }from 'react';
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
                <th id="dataHead"> { val.name }
                    <span className="custm-text-hlp">
                    { val.position }
                    <br />
                    { val.company }
                    </span>
                </th>
                <td id="dataBody"> { val.address } </td>
                <td id="dataHead"> { val.contact }</td>
            </tr>
        );
    })
)

const Reference = (props) => {
    return (
        <div className="row">
            <Blockquote title='Character Reference' id='char_reference_id' />

            <div className="col-6">
                <div className="card" id="">
                    <table className="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Contact Number</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            {
                                (props.data.references_data && props.data.references_data.length !== 0)
                                    ? <Rows list={ props.data.references_data } {...props}/>
                                    : <EmptyRow/>
                            }
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
}

export default Reference;