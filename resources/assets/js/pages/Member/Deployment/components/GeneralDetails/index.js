import React, { Component } from 'react';
import Maternity from './Maternity';
import Evaluation from './Evaluation';
import Account from './Account';

class GeneralDetails extends Component {

    render() {
        return (
            <div className="col-10 general-container-deployment">
                <label className="lbl-general-deployment">
                    {`General Details`}
                </label>
                <div className="general-card-deployment">
                    <div className="col-12 gen-row-deployment">
                        <Maternity />
                        <hr />
                        <Evaluation />
                        <hr />
                        <Account />
                    </div>
                </div>
            </div>
        )
    }
}

export default GeneralDetails;