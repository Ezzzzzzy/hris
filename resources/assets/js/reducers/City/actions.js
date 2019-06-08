import { requests } from '../requests';

const url = '/api/v1/settings/cities';

const city = {
	getAll: () => requests.get(url),
}

export default city;