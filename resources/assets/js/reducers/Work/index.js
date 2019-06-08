import {
    MEMBER_WORK_LOADED
} from '../../constants/action.type'

const work = (state = {}, action) => {
    switch(action.type) {
        case MEMBER_WORK_LOADED:
        console.log(action.payload)
            return {
                ...state,
                inProgress: false,
                member: action.payload.length ? action.payload[0].data : null,
                work: action.payload.length ? action.payload[1].data : null
            }
    }
    return state;
}
export default work;