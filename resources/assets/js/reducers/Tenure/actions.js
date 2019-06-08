import { requests } from '../requests.js'

const url = '/api/v1/settings/tenure-types';

const tenure = {
	getAll: () => requests.get(url),
}

export default tenure;