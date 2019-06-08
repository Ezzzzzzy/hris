import {
	ADD_MEMBER,
	ADD_FORM_LOADED,
	EDIT_FORM_LOAD,
	PROFILE_PAGE_LOADED,
	MEMBER_LIST_LOADED,
	MEMBER_LIST_FILTERED,
} from '../../constants/action.type'

const member = (state = {}, action) =>{
	switch(action.type){
		case ADD_MEMBER:
			return{
				...state,
				inProgress: action.payload.length ? false : true,
				error: action.error,
				errorMessage: action.payload
			}
		case PROFILE_PAGE_LOADED: {
			return {
				...state,
   				inProgress: action.payload.length ? false : true,
				payload: action.payload.length ? action.payload[0].data : null
			}
		}
		case EDIT_FORM_LOAD: {
			return {
				...state,
				inProgress: action.payload.length ? false : true,
				payload: action.payload.length && action.payload[1].data
			}
		}
		case MEMBER_LIST_LOADED: {
			return {
				...state,
				inProgress: action.payload.length ? false : true,
				data: action.payload.length && action.payload[0].data.data,
				limit: action.payload.length && action.payload[0].data.per_page,
				current_page: action.payload.length && action.payload[0].data.current_page, 
				last_page: action.payload.length && action.payload[0].data.last_page,
				next_page: action.payload.length && action.payload[0].data.next_page_url,
				prev_page: action.payload.length && action.payload[0].data.prev_page_url,
			}
		}
		case MEMBER_LIST_FILTERED: {
			return {
				...state,
				inProgress: action.payload.data ? false : true,
				data: action.payload.data && action.payload.data.data,
				limit: action.payload.data && action.payload.data.per_page,
				current_page: action.payload.data && action.payload.data.current_page, 
				last_page: action.payload.data && action.payload.data.last_page,
				next_page: action.payload.data && action.payload.data.next_page_url,
				prev_page: action.payload.data && action.payload.data.prev_page_url,
			}
		}
		default: return state;
	}
}

export default member;