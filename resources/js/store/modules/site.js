import Vue from 'vue'

const state = {
    card_success_popup_product_id: []
}

const getters = {
    getCardSuccessPopupProductId: (state) => {
        return state.card_success_popup_product_id;
    }
}

const actions = {

}

const mutations = {

    setCardSuccessPopupProductId(state, product_id){
        state.card_success_popup_product_id = product_id;
    }

}

export default {
    state,
    getters,
    actions,
    mutations
};