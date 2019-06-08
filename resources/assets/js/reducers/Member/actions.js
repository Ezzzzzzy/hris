import { requests } from '../requests.js'

const url = '/api/v1/members';

const member = {
	get: id => requests.get(url+ '/' +id),
	getAll: () => requests.get(url),
	create: body => requests.post(url, body),
	update: body => requests.put(url+'/'+body.id, body),
	filter: obj => {
		// destructured `obj` object
		let { 
			brand,
			complete, 
			page, 
			filters, 
			limit,
			location,
			position } = obj;

		// set default page and limit
		page = page ? page : '/?page=1';
		limit = limit ? limit : 10;
		
		// return promise
		let filter_url = `${url}/filter${page}&limit=${limit}&completeness=${complete}&position=${position}&brand=${brand}&location=${location}`;
		return requests.post(filter_url, { filters });
	}
}

export default member;