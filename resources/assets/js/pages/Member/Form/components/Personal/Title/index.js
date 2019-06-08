import React from 'react';
import { Blockquote } from '../../../../../../components';

const Title = () => {
    return (
        <Blockquote 
            title={'Personal Information'}
            subtitle={'Add at least one contact detail either tel number, mobile number or any of the email addresses'}
            id={'personal_info_id'}
        />
    );
}

export default Title;