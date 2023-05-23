import { createStore } from 'vuex';

import analytics from './analytics';
import candidates_per_jobs from './widgets/charts/candidates_per_jobs';

export default createStore({
    state: {},
    mutations: {},
    actions: {},
    getters: {},
    modules: {
        analytics,
        candidates_per_jobs,
    },
})
