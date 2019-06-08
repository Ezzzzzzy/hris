import React from 'react';
import DeleteButton from  '../../../../../../components/Button/DeleteButton/index';

const EmptyRow = () => (
    <tr>
        <td colSpan="4">
            <center>
                <span id="dataHead">Add atleast one Family Background</span>
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
                <td>
                    <DeleteButton onClick={ () => props.deleteFamily(i)} title={'Delete Button'} name={'X'} />
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
                <div className="card" id="">
                    <table className="table custm-table-fonts ">
                        <thead>
                            <tr>
                                <th scope="col">Type</th>
                                <th scope="col">Name</th>
                                <th scope="col">Age</th>
                                <th scope="col">Company / Occupation</th>
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
