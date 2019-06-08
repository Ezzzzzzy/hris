import React, { Component } from 'react';
import EvaluationModal from '../../Modal/Evaluation';

class Evaluation extends Component {
    state = {
        evaluation: {
            evaluation_date: 'March 01, 2016',
            result: 'Satisfactory Performance'
        }
    }

    render() {
        let { result, evaluation_date } = this.state.evaluation;
        return (
            <div className="row">
                <div className="col-6 gen-label-deployment">Last Evaluation Date</div>
                <div className="col-6 gen-edit-deployment">
                    <EvaluationModal />
                </div>
                <div className="col-12 gen-details-deployment">
                    {evaluation_date}
                </div>
                <div className="col-6 gen-label-deployment">
                    {`Evaluation Result`}
                </div>
                <div className="col-12 gen-details-deployment">
                    {result}
                </div>
            </div>
        );
    }
}

export default Evaluation;