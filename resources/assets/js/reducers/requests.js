import axios from 'axios';
import city from './City/actions'
import member from './Member/actions'
import work from './Work/actions'

const responseData = res => res.data;

const requests = {
	get: url => axios.get(url).then(responseData),
	post: (url, body) => axios.post(url, body).then(responseData),
	put: (url, body) => axios.put(url, body).then(responseData),
	delete: url => axios.delete(url, body).then(responseData),
}

export {
	city,
	member,
	requests,
	work
}

