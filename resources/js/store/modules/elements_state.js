

// state
export const state = {
  visibleSideBar : true
}

// getters
export const getters = {
  visibleSideBar: state => state.visibleSideBar,
}

// mutations
export const mutations = {
  setVisibleSideBar (state, isVisible) {
    state.visibleSideBar = isVisible
  }
}


