const initialStates = {
    auth:{
        loggedIn: false,
        users: {}
    }
};

const AuthReducers = (state = initialStates, actions) => {

    switch (actions.type){
        case 'SET_LOGIN':
            return {...state, loggedIn:true, users:actions.payload};

        case 'SET_LOGOUT':
            return {...state, loggedIn: false, users:{}};

        default:
            return state
    }
};

export default AuthReducers;