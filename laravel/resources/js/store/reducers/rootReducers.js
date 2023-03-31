import {combineReducers} from 'redux';
import AuthReducers from "./AuthReducers";
import CustomerAuthReducers from "./CustomerAuthReducers";

const rootReducers = combineReducers({
    auth: AuthReducers,
    customerAuth: CustomerAuthReducers
});

export default rootReducers;