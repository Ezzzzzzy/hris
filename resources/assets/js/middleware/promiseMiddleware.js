import axios from 'axios';
import { ASYNC_START, ASYNC_END } from '../constants/action.type'

const promiseMiddleware = store => next => action => {
	if(isPromise(action.payload)){
		store.dispatch({type: ASYNC_START, subtype: action.type});

		action.payload
			.then(res=>{
				action.payload = res
				store.dispatch({type: ASYNC_END, payload: action.payload})
				store.dispatch(action);
			}).catch(err=>{
		        action.error = true;
		        action.payload = err.response.data;
				store.dispatch({type: ASYNC_END, payload: action.payload});
				store.dispatch(action);
			});
	}

	next(action);
}

// checks if action.payload is a Promise
const isPromise = v => {
	return v && typeof v.then === 'function';
}

export default promiseMiddleware;