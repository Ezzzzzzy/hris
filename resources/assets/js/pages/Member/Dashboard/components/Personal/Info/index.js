import React from 'react';

const Info = () => {
	return (
		<div className="col-8">
            <div className="col-8">
                <div className="row">
                    <h1 className="name"> { ` Daryl Elvin Sinon ` } </h1>
                </div>
                <div className="row">
                    <span className="gender-text">
                        <i className="fa fa-venus"></i>
                            { ` Female ` }
                    </span>
                    <span className="dot-info">
                        { ` · ` }
                    </span> 
                    <span className="city-text">
                        { ` PASIG CITY (present address)` }
                    </span> 
                </div>
                <br/>
            </div>
            <div className="row">
                <div className="col-7">
                    <ul className="personal-details">
                        <li>
                            <i className="fa fa-birthday-cake fa-fw"></i>
                                { ` April 02, 1993` }
                            <span className="dot">{ ` · ` }</span>
                             	{ ` 31 yrs OLD ` }
                        </li>
                        <li>
                            <i className="fa fa-home fa-fw"></i> 
                            	{ ` BLK 3 LT 7 CROCODILE AVENUE ` }
                        </li>
                        <li>
                            <i className="fa fa-phone fa-fw"></i> 
                            	{ ` 09176762893 / 09817829232 ` }
                        </li>
                        <li>
                            <i className="fa fa-envelope fa-fw"></i> 
                                { ` Botbros.ai.com.ph.sg ` }
                            </li>
                        <li>
                            <i className="fa fa-male fa-fw"></i> 
                                { ` From Mar. 20, 2018 - Jun. 20, 2018 ` } 
                                <span className="dot">{ ` · ` }</span> 
                                <span className="onLeave">{ ` On Leave ` }</span>
                        </li>
                    </ul>
                </div>
                <div className="vertical-line"></div>
                <div className="col-4">
                    <ul className="personal-details">
                        <li>{ ` TIN ` }<span className="govt-num">{ ` 1309-155-340 ` }</span></li>
                        <li>{ ` PGI ` }<span className="govt-num">{ ` 010511157019 ` }</span></li>
                        <li>{ ` PHL ` }<span className="govt-num">{ ` - ` }</span></li>
                        <li>{ ` SSS ` }<span className="govt-num">{ `  - ` }</span></li>
                    </ul>
                </div>
            </div>
        </div>
	);
}

export default Info;