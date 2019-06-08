import { MEMBER_LIST_LOADED } from '../../constants/action.type'

const location = (state = {}, action) =>{
	switch(action.type){
		case MEMBER_LIST_LOADED: {
			return {
				...state,
				inProgress: action.payload.length ? false : true,
				location: action.payload.length && action.payload[5].data
			}
		}
		default: return state;
	}
}

export default location;