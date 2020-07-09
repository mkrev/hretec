import store from '~/store'

export default async(to, from, next) => {
    if (!store.getters['basic_data/politicalViews']) {
        await store.dispatch('basic_data/fetchPoliticalViews')
    }
    next()
}


