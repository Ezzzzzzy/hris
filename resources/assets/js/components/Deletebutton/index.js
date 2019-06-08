import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import './style.css';

const Deletebutton = (props) =>{
  return(
    <div>
      <button {...props}>{props.name}</button>
    </div>
  );
}

export default Deletebutton;
