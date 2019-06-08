import React, { Component } from 'react';
import MaternityModal from '../../Modal/Maternity';

class Maternity extends Component {
    state = {
        maternity: {
            maternity_start: 'March 02, 2016',
            maternity_end: 'March 03, 2016'
        }
    }

    render() {
        return (
            <div className="row">
                <div className="col-6 gen-label-deployment">Maternity Leave</div>
                <div className="col-6 gen-edit-deployment">
                    <MaternityModal />
                </div>
                <div className="col-12 gen-details-deployment">
                    {"From " + this.state.maternity.maternity_start + " - " + this.state.maternity.maternity_end}
                </div>
            </div>
        );
    }
}

export default Maternity;