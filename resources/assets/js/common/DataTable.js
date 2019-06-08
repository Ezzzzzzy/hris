import React , { Component } from 'react';


export default class DataTable extends Component{
    constructor(props){
        super(props);
    }

    renderHeaders(){
        const headersJSX = this.props.headers.map((value) => 
                <th key={value}>{value}</th>
        );

        return headersJSX;
    }

    renderData(){
        const data = this.props.data.map((value) =>
            <tr>
            {Object.values(value).map((value2) => 
                <td key={value2}>{value2}</td>
            )}
            </tr>
        );

        return data;
    }

    render(){
        return(
            <table className="table custm-component-table ">
                <thead>
                    <tr>
                        {this.renderHeaders()}
                    </tr>
                </thead>
                <tbody>
                    {this.renderData()} 
                </tbody>
            </table>
        );
    }
}