<template>
    <div>
        <div
            v-if="isLoading"
            class="loading-spinner d-flex justify-content-center align-items-center"
        >
            <div class="spinner-border text-secondary mt-5 mb-5" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div v-else-if="!isLoading && isLoaded">
            <h4>Line chart [vue chartjs]</h4>
            <LineChart :chartData="chart.data" />
        </div>
    </div>
</template>

<script>
import LineChart from './chart_types/LineChart.vue';
import { actionTypes } from '../../../store/widgets/charts/candidates_per_jobs/actions';
import { mapState } from 'vuex';

export default {
    name: 'CandidatesPerJobsWidgetComponent',

    components: { LineChart },

    data() {
        return {};
    },

    computed: {
        ...mapState({
            isLoading: (state) => state.candidates_per_jobs.isLoading,
            isLoaded: (state) => state.candidates_per_jobs.isLoaded,
            chart: (state) => state.candidates_per_jobs.chart,
        }),
    },

    mounted() {
        this.$store.dispatch(actionTypes.init);
    }
}
</script>

<style scoped>

</style>
