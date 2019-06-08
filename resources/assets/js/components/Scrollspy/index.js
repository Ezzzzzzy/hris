import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import Item from './Item';

const Scrollspy = () => {
    return (
        <div id="section_id">
            <nav id="nav_section_id" className="navbar navbar-light navbar-fixed-top">
                <label id="section_label_id">SECTIONS</label>
                <div className="container" >
                    <ul className="navbar-nav">
                        <Item />
                    </ul>
                </div>
            </nav>
        </div>
    );
}

export default Scrollspy;