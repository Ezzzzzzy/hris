import { requests } from '../requests';

const url = '/api/v1/employment-status';

const employmentStatus = {
	getAll: () => requests.get(url),
}

export default employmentStatus;