import React, { Component } from 'react';
import ReactDOM from 'react-dom';

const DeleteButton = (props) =>{
  return(
    <div className=".btn-container">
      <button {...props} className="btn-delete">{props.name}</button>
    </div>
  );
}

export default DeleteButton;
