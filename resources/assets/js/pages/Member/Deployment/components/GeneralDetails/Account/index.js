import React, { Component } from 'react';
import AccountNumberModal from '../../Modal/AccountNumber';


const type = [
    { id: '1', type: 'Express Card' },
    { id: '2', type: 'Express Way' },
    { id: '3', type: 'Bicol Express' }

]

class Account extends Component {
    state = {
        account: {
            account_type: type[1].type,
            account_number: '10928198192801'
        }
    }

    render() {
        let { account_number, account_type } = this.state.account;
        return (
            <div className="row">
                <div className="col-12 gen-edit-deployment">
                    <AccountNumberModal />
                </div>
                <div className="row col-12">
                    <div className="col-7 account-details-deployment">
                        <div className="col-12 gen-label-deployment">
                            {`Account Number`}
                        </div>
                        <div className="col-6 gen-details-deployment">
                            {account_number}
                        </div>
                    </div>
                    <div className="col-5 account-details-deployment">
                        <div className="col-12 gen-label-deployment">
                            {`Account Type`}
                        </div>
                        <div className="col-12 gen-details-deployment">
                            {account_type}
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default Account;