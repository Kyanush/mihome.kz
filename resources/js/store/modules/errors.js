const state = {
    errors: null
}

const getters = {
    ListErrors: (state) => {
        return state.errors;
    },
    IsError: (state) => key => {
        if(state.errors && key)
            if(state.errors[key])
                return state.errors[key];
            else{
                var r = null;
                Object.keys(state.errors).forEach(function (error_key){
                    if(error_key == key)
                        r = state.errors[error_key];
                });
                if (r)
                    return r;
            }
        return false;
    },
}

const actions = {
    SetErrors ({ commit, state }, errors) {
        commit('SetErrors', errors);
    }
}

const mutations = {
    SetErrors(state, errors){
        state.errors = errors;
    }
}

export default {
    state,
    getters,
    actions,
    mutations
};