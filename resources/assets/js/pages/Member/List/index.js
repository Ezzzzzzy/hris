import React, { Component } from 'react';

// redux
import { connect } from 'react-redux';
import member from '../../../reducers/Member/actions';
import tenure from '../../../reducers/Tenure/actions';
import position from '../../../reducers/Position/actions';
import brand from '../../../reducers/Brand/actions';
import location from '../../../reducers/Location/actions';
import employmentStatus from '../../../reducers/employmentStatus/actions';
import { MEMBER_LIST_LOADED, MEMBER_LIST_FILTERED } from '../../../constants/action.type';

// components
import Header from '../Header';
import Table from './Table';
import Filter from './Filter';
import Search from './Search';
import './style.css';

const MapStateToProps = state => {
	let { member, employeeStatus, tenure, position, brand, location } = state;
	return { member, status: employeeStatus, tenure, position, brand, location }
};

const MapDispatchToProps = dispatch => ({
    onLoad: payload => dispatch({ type: MEMBER_LIST_LOADED, payload }),
	onSubmit: payload => dispatch({ type: MEMBER_LIST_FILTERED, payload }),
});

class ListComponents extends Component{
	constructor(props) {
		super(props);
		
		this.state = {
			brand: '',
			complete: 'all', // default is all
			position: '',
			location: '',
			filters: {
				status: [],
				tenure: [],
			},
		}

		this.handleFilter = this.handleFilter.bind(this);
	}

	componentDidMount(){
		this.props.onLoad(Promise.all([
			member.getAll(),
			employmentStatus.getAll(),
			tenure.getAll(),
			position.getAll(),
			brand.getAll(),
			location.getAll()
		]));
	}

	handleFilter(filter) {
		let filters = Object.assign({}, this.state.filters);
		let complete = filter.complete ? filter.complete : this.state.complete;
		let position = filter.position ? filter.position : this.state.position;
		let brand = filter.brand ? filter.brand : this.state.brand;
		let location = filter.location ? filter.location : this.state.location;
		filters.status = filter.status ? filter.status : this.state.filters.status;
		filters.tenure = filter.tenure ? filter.tenure : this.state.filters.tenure;

		this.setState({ complete, filters, position, brand, location }, () => {
			let { brand, complete, filters, location, position, } = this.state;
			const obj = { 
				complete, filters, position, brand, location,
				limit: this.props.member.limit
			};

			this.props.onSubmit(member.filter(obj));
		});
	}

	render() {
		let { status, tenure, position, member, brand, location } = this.props;
		let { filters } = this.state;

		return (
			<div>
				<Header title='Member List'/>

				<div className='container-fluid'>
				 	<div className='row mt-5 pr-5 pl-5'>
						 <Filter 
							brand={ brand }
							location={ location }
				 			status={ status } 
							tenure={ tenure }
							position={ position }
							positionFilter={ this.state.position }
				 			statusFilter={ filters.status }
				 			tenureFilter={ filters.tenure }
				 			handleFilter={ this.handleFilter }
			 			/>

						<div className='col-10'>
							<div className='container-fluid'>
								<Search handleFilter={ this.handleFilter } filter={ this.state.complete }/>

								<div className="row mt-2">
									<div className="col-12">
										<Table
											data={ member.data }
											loading={ member.inProgress }
											limit={ member.limit }
											pages={ member.last_page }
											current_page={ member.current_page }
											next_page={ member.next_page }
											prev_page={ member.prev_page }
											onSubmit={ this.props.onSubmit }
											memberAction={ member }
											filters={ this.state }
										/>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		);
	}
}

export default connect(MapStateToProps, MapDispatchToProps)(ListComponents);