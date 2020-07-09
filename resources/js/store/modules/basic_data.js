import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
    politicalViews: null,
}

// getters
export const getters = {
    politicalViews: state => state.politicalViews,
}

// mutations
export const mutations = {
    
  [types.FETCH_POLITICAL_VIEWS_SUCCESS] (state, { politicalViews }) {
    state.politicalViews = politicalViews
  },

  [types.FETCH_POLITICAL_VIEWS_FAILURE] (state) {
   
  },

}

// actions
export const actions = {
 
  async fetchPoliticalViews ({ commit }) {
    try {
      const { data } = await axios.get('/api/political-views')

      commit(types.FETCH_POLITICAL_VIEWS_SUCCESS, { politicalViews: data })
    } catch (e) {
      commit(types.FETCH_POLITICAL_VIEWS_FAILURE)
    }
  },


}
