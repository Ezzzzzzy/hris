import { MEMBER_LIST_LOADED } from '../../constants/action.type'

const tenure = (state = {}, action) =>{
	switch(action.type){
		case MEMBER_LIST_LOADED: {
			return {
				...state,
				inProgress: action.payload.length ? false : true,
				tenure: action.payload.length && action.payload[2].data
			}
		}
		default: return state;
	}
}

export default tenure;