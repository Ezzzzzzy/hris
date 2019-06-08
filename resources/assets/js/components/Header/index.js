import React from 'react';

const Header = ({title}) => {
    return (
        <div className="header-container">
            <div className="col-md-auto">
                <span id="header-text">{ title }</span>
            </div>
        </div>
    )
}

export default Header;