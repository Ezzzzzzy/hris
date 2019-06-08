import React, { Component } from 'react';
import Status from './Status';
import Info from './Info';
import Id from './Id';

class Personal extends Component {
    render() {
        return (
            <div className="row">
                <div className="col-12">
                    <div className="row justify-content-center">
                        <div className="col-9 card-personal">
                            <div className="row margin">
                                <Id />
                                <Info />
                                <Status />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}
export default Personal;
