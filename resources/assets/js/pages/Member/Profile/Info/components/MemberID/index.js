import React from 'react';
import { Blockquote, TextInput } from '../../../../../../components';

const MemberID = (props) => {
	return (
		<div className="row"> 
			<Blockquote title='Old Member ID' />
			
			<div className="col-5">
				<div className="form-group row">
					<div className="col-8 custm-TextInput-align-body">
						<TextInput placeholder={ props.data.existing_member_id } disabled='true'/>
					</div>
				</div>
			</div>
			<div className="col"></div>
		</div>
	);
}

export default MemberID;