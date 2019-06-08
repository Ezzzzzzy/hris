import React from 'react';
import './style.css';

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
                    <td>
                        <button className="btn-red" onClick={ () => props.deleteSchool(i) }>
                            X
                        </button>
                    </td>
                </tr>
        );
    })
)

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
                                <th>Type</th>
                                <th>School</th>
                                <th>Course / Degree</th>
                                <th>Year Graduated</th>
                                <th></th>
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