import React, { Component } from 'react';
import { Link } from 'react-router-dom';

const Menu = (props) => {
	return (
		<div className="col-2">
			<ul>
				<span className="menu-text">MENU</span>
				<li>
					<Link 
						to="/settings/status" 
						className={'btn btn-block menu-hover-link ' + `${ props.path === '/settings/status' ? 'menu-active-link' : '' }` }
					>
						Employee Status
					</Link>
				</li>
				<li>
					<Link 
						to="/settings/document"
						className={'btn btn-block menu-hover-link ' + `${ props.path === '/settings/document' ? 'menu-active-link' : '' }` }
					>
						Document Types
					</Link>
				</li>
				<li>
					<Link 
						to="reason" 
						className={'btn btn-block menu-hover-link ' + `${ props.path === '/settings/reason' ? 'menu-active-link' : '' }` }
					>
						Reasons for Leaving
					</Link>
				</li>
				<li>
					<Link 
						to="/settings/region" 
						className={'btn btn-block menu-hover-link ' + `${ props.path === '/settings/region' ? 'menu-active-link' : '' }` }
					>
						Regions
					</Link>
				</li>
				<li>
					<Link 
						to="/settings/city" 
						className={'btn btn-block menu-hover-link ' + `${ props.path === '/settings/city' ? 'menu-active-link' : '' }` } 
					>
						Cities
					</Link>
				</li>
				<li>
					<Link 
						to="/settings/location" 
						className={'btn btn-block menu-hover-link ' + `${ props.path === '/settings/location' ? 'menu-active-link' : '' }` }
					>
						Branch Locations
					</Link>
				</li>
				<li>
					<Link 
						to="/settings/position" 
						className={'btn btn-block menu-hover-link ' + `${ props.path === '/settings/position' ? 'menu-active-link' : '' }` }
					>
						Positions
					</Link>
				</li>
				<li>
					<Link 
						to="/settings/tenure" 
						className={'btn btn-block menu-hover-link ' + `${ props.path === '/settings/tenure' ? 'menu-active-link' : '' }` }
					>
						Tenure Ranges
					</Link>
				</li>
			</ul>
		</div>
	);
}
export default Menu;