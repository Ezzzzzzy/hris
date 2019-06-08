import React from 'react';
import DeleteButton from  '../../../../../../components/Button/DeleteButton/index';

const EmptyRow = () => (
    <tr>
        <td colSpan="4">
            <center>
                <span id="dataHead">Add atleast one Emergency Contact</span>
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
                <td>
                    <DeleteButton onClick={ () => props.deleteContact(i)} title={'Delete Button'} name={'X'} />
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
                <div className="card custm-card-margin" id="">
                    <table className="table custm-table-fonts ">
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