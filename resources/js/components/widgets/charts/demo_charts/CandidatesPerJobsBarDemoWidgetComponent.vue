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
            <h4>Bar chart [vue chartjs]</h4>
            <Bar :data="data" :options="options" />
        </div>
    </div>
</template>

<script>
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
} from 'chart.js';

import { Bar } from 'vue-chartjs';

ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend);

import { actionTypes } from '../../../../store/widgets/charts/candidates_per_jobs/actions';
import { mapState } from 'vuex';

export default {
    name: 'CandidatesPerJobsBarDemoWidgetComponent',

    components: { Bar },

    data() {
        return {
            data: {
                labels: [
                    'Jan 30, 2023',
                    'Feb 6, 2023',
                    'Feb 13, 2023',
                    'Feb 20, 2023',
                    'Feb 27, 2023',
                    'Mar 6, 2023',
                    'Mar 13, 2023',
                    'Mar 20, 2023',
                    'Mar 27, 2023',
                ],
                datasets: [
                    {
                        label: '1y',
                        backgroundColor: '#649CDD',
                        data: [5.21, 5.22, 5.49, 5.56, 5.69, 5.77, 3.71, 5.72, 5.77]
                    },
                    {
                        label: '2y',
                        backgroundColor: '#7272AA',
                        data: [4.12, 4.8, 4.24, 4.41, 4.51, 4.7, 4.59, 4.12, 4.53]
                    },
                    {
                        label: '3y',
                        backgroundColor: '#A6D7D8',
                        data: [3.00, 3.11, 3.27, 3.45, 3.53, 3.6, 3.69, 3.82, 3.83]
                    },
                    {
                        label: '5y',
                        backgroundColor: '#F3D570',
                        data: [8.26, 8.61, 8.62, 8.66, 8.68, 8.88, 8.99, 9.13, 9.06]
                    },
                    {
                        label: 'No exp.',
                        backgroundColor: '#94BD5D',
                        data: [32.89, 33.93, 32.67, 31.75, 32.73, 35.2, 36.05, 35.4, 36.8]
                    }
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        align: 'start',

                        title: {
                            display: true,
                            text: 'Candidates per jobs dynamic, weekly',
                            font: {
                                size: 13,
                                weight: 'bold',
                            }
                        },

                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                        },
                    },
                    tooltip: {
                        intersect: false,
                        usePointStyle: true,
                        callbacks: {
                            labelPointStyle: function(context) {
                                return {
                                    pointStyle: 'circle',
                                    rotation: 0
                                };
                            }
                        }
                    }
                },
            }
        };
    },

    computed: {
        ...mapState({
            isLoading: (state) => state.candidates_per_jobs.isLoading,
            isLoaded: (state) => state.candidates_per_jobs.isLoaded,
            // chart: (state) => state.candidates_per_jobs.chart,
        }),
    },

    mounted() {
        // this.$store.dispatch(actionTypes.init);
    }
}
</script>

<style scoped>
</style>
