import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import {
    NavBar,
    HeaderBreadcrumbs
} from '../common/_all';

import DeploymentBody from './Member/Deployment';

import {
    MembersProfileHeader,
    MembersProfileBody,
} from './membersProfile/_all';

export default class DeploymentDetails extends Component {
    render() {
        return (
            <div>
                <NavBar/>
                <MembersProfileHeader/>
                <HeaderBreadcrumbs/>
                <DeploymentBody/> 
            </div>
        );
    }
}

