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
                <th id="dataHead">{ val.family_type }</th>
                <td id="dataBody">{ val.name }</td>
                <td id="dataBody">{ val.age ? val.age : '--' }</td>
                <td id="dataHead">{ val.occupation ? val.occupation : '--' }</td>
            </tr>
        );
    })
)

const Family = (props) => {
    return (
        <div className="row">
            <Blockquote title='Family' id='fam_bg_id' />

            <div className="col-6">
                <div className="card" id="">
                    <table className="table">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Company / Occupation</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            {
                                (props.data.family_data && props.data.family_data.length !== 0)
                                    ? <Rows list={ props.data.family_data } {...props}/>
                                    : <EmptyRow/>
                            }
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
}

export default Family;