import { default as api } from './../../api/analyticsApi';
import { mutationTypes } from './mutations';

export const actionTypes = {
    init: '[page-analytics-init] init',
};

const actions = {
    [actionTypes.init](context, credentials) {
        console.log(credentials)
        context.commit(mutationTypes.initStart);

        return new Promise(() => {
            api.getAllDataForCharts(credentials)
                .then((response) => {
                    console.log(response.data);
                    context.commit(mutationTypes.initSuccess, response.data);
                })
                .catch((e) => {
                    context.commit(mutationTypes.initFailure, e.response.data.errors);
                })
        });
    },
};

export default actions;
