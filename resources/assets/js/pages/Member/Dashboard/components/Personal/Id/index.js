import React from 'react';

const Id = () => {
	return (
		<div className="col-2 id-component">
            <div className="circle-image">
                <div className="icon">
                    { ` DR ` }
                </div>
            </div>
            <div className="member-id">
               { ` 1234567890 ` }
            </div>
            <div className="member-label">
                <small>
                    { ` MEMBER ID ` }
                </small>
            </div>
            <div className="old-id">
               { ` 0987654321 ` }
            </div>
            <div className="member-label">
                <small>
                    { ` OLD ID ` }
                </small>
            </div>
        </div>
	);
}

export default Id;