import {
	ADD_FORM_LOADED,
	EDIT_FORM_LOAD,
	ASYNC_START,
	ASYNC_END,
} from '../../constants/action.type'

const city = (state = {}, action) =>{
	switch(action.type){
		case EDIT_FORM_LOAD:
		case ADD_FORM_LOADED:
			return{
				...state,
				payload: action.payload.length && action.payload[0],
			}
			break;
		default: return state;
	}
}

export default city;