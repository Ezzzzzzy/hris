import React, { Component } from "react";
import Label from "../Label";

/**
 * Display an select tag Component
 *
 * @param object props
 * @param array errors || optional
 * @param array options || required - list of data/options to display
 * @param array optionValue || required - value to put in value tag
 * @param string selectValue || required - value to put in select tag
 * @param string display || required - string to display in option
 * @param boolean requiredfield || optional
 *
 */

const Select = (props) => {

    let { id, label, options, optionValue, display, onChange, selectValue, errors, name } = props;

    errors = props.errors ? props.errors : [];
    options = options ? options : [];

    return (
        <div>
            <div className="text-left">
                {
                    props.label && <Label label={props.label} requiredfield={props.requiredfield} />
                }
            </div>
            <select
                name={name}
                id={id}
                className={'form-control '} // + `${ errors.includes(id) && 'error' }` } //pending to be removed
                onChange={onChange}
                value={selectValue}
            >
                <option key={label}> Select {label} </option>
                {options.map((val, i) => (
                    <option key={i} value={val[optionValue]}>
                        {val[display]}
                    </option>
                ))}
            </select>
        </div>
    );
};

export default Select;
