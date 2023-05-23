export const mutationTypes = {
    initStart: '[chart-candidates-per-jobs] initStart',
    initSuccess: '[chart-candidates-per-jobs] initSuccess',
    initFailure: '[chart-candidates-per-jobs] initFailure',
};

const mutations = {
    [mutationTypes.initStart](state) {
        state.error = null;
        state.isLoading = true;
        state.isLoaded = false;
        state.chart = null;
    },
    [mutationTypes.initSuccess](state, payload) {
        state.isLoading = false;
        state.isLoaded = true;
        state.chart = {
            data: payload,
        };
    },
    [mutationTypes.initFailure](state, payload) {
        state.isLoading = false;
        state.isLoaded = false;
        state.error = payload;
    },
};

export default mutations;
