import React, { Component }     from 'react';
import { Blockquote, TextInput } from '../../../../../components';
import './styles.css';

class MemberID extends Component{
    state = { id: '' }

    static getDerivedStateFromProps(props, state) {
        // clears the form
        if (props.reset) { return { id: '' } }

        // if edit == populate the form
        return (props.form && props.form.existing_member_id)
                ? { id: props.form.existing_member_id }
                : null;
    }

    handleChange(id) {
        this.setState({ id }, ()=>{
            this.props.handleChange(this.state.id, 'existing_member_id')
        });
    }

    render() {
        return(
            <div className="row">
                <Blockquote title='Old Member ID' id={'member_id_label'} />

                <div className="col-6 input-container">
                    <div className="form-group row">
                        <div className="col-7">
                            <TextInput
                                id='existing_member_id'
                                errors={ this.props.errors }
                                value={ this.state.id }
                                requiredfield={ 1 }
                                onChange={ e=>this.handleChange(e.target.value) }
                                placeholder='Old Member ID'
                            />
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default MemberID;
