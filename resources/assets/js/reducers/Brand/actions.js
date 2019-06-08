import { requests } from '../requests.js'

const url = '/api/v1/brands';

const brand = {
	getAll: () => requests.get(url),
}

export default brand;