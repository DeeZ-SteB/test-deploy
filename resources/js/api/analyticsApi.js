const getAllDataForCharts = (credentials) => {
    return axios.post('/analytics/charts/all', {
        spec_pos: credentials.specializationPosition,
        exp: credentials.experience,
        date_start: credentials.dateStart,
        date_end: credentials.dateEnd,
    });
};

const getDemoChart = () => axios.get('/analytics/chart/candidates-per-jobs');

export default {
    getAllDataForCharts,
    getDemoChart,
};
