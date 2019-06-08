import { MEMBER_LIST_LOADED } from '../../constants/action.type'

const brand = (state = {}, action) =>{
	switch(action.type){
		case MEMBER_LIST_LOADED: {
			return {
				...state,
				inProgress: action.payload.length ? false : true,
				brand: action.payload.length && action.payload[4].data
			}
		}
		default: return state;
	}
}

export default brand;