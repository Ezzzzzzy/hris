import { requests } from '../requests';

const url = '/api/v1/member';

const work = {
    get: id => requests.get(url+ '/' + id + '/works'),
}

export default work;