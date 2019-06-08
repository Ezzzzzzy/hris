import { createStore, applyMiddleware } from 'redux';
import thunk from 'redux-thunk';
import logger from 'redux-logger'
import rootReducer from './reducers';
import promiseMiddleware from './middleware/promiseMiddleware';
import createHistory from 'history/createBrowserHistory';
import { routerMiddleware } from 'react-router-redux'

const history = createHistory();

const myRouterMiddleware = routerMiddleware(history);

const createStoreWithMiddleware = applyMiddleware(
		myRouterMiddleware,
		thunk, 
		// logger, 
		promiseMiddleware,
	)(createStore);

const store = createStoreWithMiddleware(rootReducer);

export {
	store,
	history
}