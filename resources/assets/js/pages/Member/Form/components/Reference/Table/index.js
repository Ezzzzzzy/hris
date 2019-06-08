import React from 'react';
import DeleteButton from  '../../../../../../components/Button/DeleteButton/index';

const EmptyRow = () => (
    <tr>
        <td colSpan="4">
            <center>
                <span id="dataHead">Add atleast one Character Reference</span>
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
                <td>
                    <DeleteButton onClick={ () => props.deleteReference(i)} title={'Delete Button'} name={'X'}/>
                </td>
            </tr>
        );
    })
)

const Table = (props) =>{
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
                                <th>Name</th>
                                <th>Address</th>
                                <th>Contact Number</th>
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
