import React from 'react';
import { Blockquote } from '../../../../../../components';

const EmptyRow = () => (
    <tr>
        <td colSpan="4">
            <center>
                <span id="dataHead">Add atleast one Educational Attainment</span>
            </center>
        </td>
    </tr>
)

const Rows = ({list, ...props}) => (
    list.map((val,i)=>{
          return (
                <tr key={i}>
                    <th scope="row" id="dataHead">{ val.school_type }</th>
                    <td id="dataBody">{ val.school_name }</td>
                    <td id="dataBody">{ val.degree ? val.degree: '--' }</td>
                    <td id="dataHead">{`${val.started_at} - ${val.ended_at}`}</td>
                </tr>
        );
    })
)

const Education = (props) => {
    return (
        <div className="row">
            <Blockquote title={'Educational Attainment'} id={'educ_attainment_id'} />

            <div className="col-6">
                <div className="card" id="">
                    <table className="table">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>School</th>
                                <th>Course / Degree</th>
                                <th>Year Graduated</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            {
                                (props.data.school_data && props.data.school_data.length !== 0)
                                    ? <Rows list={ props.data.school_data } {...props}/>
                                    : <EmptyRow/>
                            }
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
}

export default Education;