const initialStates = {
    customerLoggedIn: false,
    customers: {},
};

const CustomerAuthReducers = (state = initialStates, actions) => {

    switch (actions.type){

        case 'CUSTOMER_LOGIN':
            return {...state, customerLoggedIn:true, customers:actions.payload};

        case 'CUSTOMER_REGISTER':
            return {...state, customerLoggedIn:false, customers:actions.payload};

        case 'CUSTOMER_LOGOUT':
            return {...state, customerLoggedIn:false, customers:{}};

        default:
            return state
    }
};

export default CustomerAuthReducers;