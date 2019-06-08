import { combineReducers } from 'redux';
import city from './City';
import member from './Member';
import employeeStatus from './EmploymentStatus';
import tenure from './Tenure';
import work from './Work';
import position from './Position';
import brand from './Brand';
import location from './Location';

const rootReducer = combineReducers({
	city,
	member,
	employeeStatus,
	tenure,
	work,
	position,
	brand,
	location,
});

export default rootReducer;