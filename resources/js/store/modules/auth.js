import Vue from 'vue'

const state = {
    user: []
}

const getters = {
    RoleName: (state) => {
        if(state.user)
            if( state.user.role)
        return state.user.role.name;
    },
    UserId: (state) => {
        if(state.user)
            return parseInt(state.user.id);
    },
    RoleDesc: (state) => {
        if(state.user)
            if(state.user.role)
                return state.user.role.description;
    },
    UserName: (state) => {
        if(state.user)
            return state.user.name;
    }
}

const actions = {
    SetUser ({ commit, state }, user) {
       commit('SetUser', user);
    }
}

const mutations = {

    SetUser(state, user){
        state.user = user;
    }

}

export default {
    state,
    getters,
    actions,
    mutations
};