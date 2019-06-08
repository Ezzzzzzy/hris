import { requests } from '../requests.js'

const url = '/api/v1/settings/positions';

const position = {
	getAll: () => requests.get(url),
}

export default position;