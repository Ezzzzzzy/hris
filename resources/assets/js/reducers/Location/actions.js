import { requests } from '../requests.js'

const url = '/api/v1/settings/locations';

const brand = {
	getAll: () => requests.get(url),
}

export default brand;