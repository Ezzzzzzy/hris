import { MEMBER_LIST_LOADED } from '../../constants/action.type'

const position = (state = {}, action) =>{
	switch(action.type){
		case MEMBER_LIST_LOADED: {
			return {
				...state,
				inProgress: action.payload.length ? false : true,
				position: action.payload.length && action.payload[3].data
			}
		}
		default: return state;
	}
}

export default position;