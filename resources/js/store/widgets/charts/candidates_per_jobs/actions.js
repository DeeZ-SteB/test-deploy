import { default as api } from './../../../../api/analyticsApi';
import { mutationTypes } from './mutations';

export const actionTypes = {
    init: '[chart-candidates-per-jobs] init',
};

const actions = {
    [actionTypes.init](context) {
        context.commit(mutationTypes.initStart);

        return new Promise(() => {
            api.getDemoChart()
                .then((response) => {
                    // console.log(response.data.chart);
                    context.commit(mutationTypes.initSuccess, response.data.chart);
                })
                .catch((e) => {
                    context.commit(mutationTypes.initFailure, e.response.data);
                })
        });
    },
};

export default actions;
