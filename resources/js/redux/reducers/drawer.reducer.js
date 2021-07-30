import { SETOPEN } from "../../constants/redux";

const initialState = {
    open: false
};

const drawerReducer = (state = initialState, action) => {
    switch (action.type) {
        case SETOPEN:
            return {
                open: action.payload
            }
        default:
            return state;
    }
};

export default drawerReducer;