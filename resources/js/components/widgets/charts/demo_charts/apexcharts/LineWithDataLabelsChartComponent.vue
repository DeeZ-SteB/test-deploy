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
            <h4>Line chart with data labels [apexcharts]</h4>
            <apexchart
                type="line"
                height="550"
                :options="chartOptions"
                :series="series"
            ></apexchart>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex';

/**
 * https://apexcharts.com/vue-chart-demos/line-charts/data-labels/
 */
import VueApexCharts from 'vue3-apexcharts';

export default {
    name: 'LineWithDataLabelsChartComponent',

    components: { apexchart: VueApexCharts },

    data() {
        return {
            series: [
                {
                    name: '1y',
                    data: [5.21, 5.22, 5.49, 5.56, 5.69, 5.77, 3.71, 5.72, 5.77],
                },
                {
                    name: '2y',
                    data: [4.12, 4.8, 4.24, 4.41, 4.51, 4.7, 4.59, 4.12, 4.53],
                },
                {
                    name: '3y',
                    data: [3.00, 3.11, 3.27, 3.45, 3.53, 3.6, 3.69, 3.82, 3.83]
                },
                {
                    name: '5y',
                    data: [8.26, 8.61, 8.62, 8.66, 8.68, 8.88, 8.99, 9.13, 9.06]
                },
                {
                    name: 'No exp.',
                    data: [32.89, 33.93, 32.67, 31.75, 32.73, 35.2, 36.05, 35.4, 36.8]
                },
            ],
            chartOptions: {
                chart: {
                    height: 400,
                    type: 'line',
                    dropShadow: {
                        enabled: true,
                        color: '#000',
                        top: 18,
                        left: 7,
                        blur: 10,
                        opacity: 0.2
                    },
                    toolbar: {
                        show: true,
                        tools: {
                            selection: false,
                            zoom: false,
                        },
                    }
                },
                colors: ['#649CDD', '#7272AA', '#A6D7D8', '#F3D570', '#94BD5D'],
                dataLabels: {
                    enabled: true,
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                title: {
                    text: 'Candidates per jobs dynamic',
                    align: 'left',
                    offsetX: 25
                },
                grid: {
                    borderColor: '#e7e7e7',
                    row: {
                        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                    },
                },
                markers: {
                    size: 1
                },
                xaxis: {
                    categories: [
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
                    title: {
                        text: 'Weekly'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Candidates per job'
                    },
                    min: 1,
                    max: 40,
                    labels: {
                        formatter: (val) => val.toFixed(0),
                    }
                },
                tooltip: {
                    y: {
                        formatter: (val) => val
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'left',
                    floating: true,
                    offsetY: -10,
                    offsetX: 0
                }
            },
        }
    },

    computed: {
        ...mapState({
            isLoading: (state) => state.candidates_per_jobs.isLoading,
            isLoaded: (state) => state.candidates_per_jobs.isLoaded,
            chart: (state) => state.candidates_per_jobs.chart,
        }),
    },
}
</script>

<style scoped>

</style>
