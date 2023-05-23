export const mutationTypes = {
    initStart: '[page-analytics-init] initStart',
    initSuccess: '[page-analytics-init] initSuccess',
    initFailure: '[page-analytics-init] initFailure',
};

const mutations = {
    [mutationTypes.initStart](state) {
        state.error = null;
        state.isLoading = true;
        state.isLoaded = false;
        state.isChartsLoaded = true;
        state.weeklyPeriod = [];
        state.charts = {
            candidatesPerJobs: {
                dou: null,
                djinni: null,
                workua: null,
                rabotaua: null,
            },
        };
    },
    [mutationTypes.initSuccess](state, payload) {
        state.isLoading = false;
        state.isLoaded = true;
        state.isChartsLoaded = false;
        state.weeklyPeriod = payload.weeklyPeriod;
        state.charts = {
            candidatesPerJobs: {
                dou: payload.charts.candidatesPerJobs.dou,
                djinni: payload.charts.candidatesPerJobs.djinni,
                workua: payload.charts.candidatesPerJobs.workua,
                rabotaua: payload.charts.candidatesPerJobs.rabotaua
            },
        };
    },
    [mutationTypes.initFailure](state, payload) {
        state.isLoading = false;
        state.isLoaded = false;
        state.isChartsLoaded = true;
        state.error = payload;
    },
};

export default mutations;
