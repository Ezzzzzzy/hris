import {
	MEMBER_LIST_LOADED
} from '../../constants/action.type'

const employeeStatus = (state = {}, action) =>{
	switch(action.type){
		case MEMBER_LIST_LOADED: {
			return {
				...state,
				inProgress: action.payload.length ? false : true,
				employeeStatus: action.payload.length && action.payload[1].data
			}
		}
		default: return state;
	}
}

export default employeeStatus;