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
            <h4>Area stacked chart [apexcharts]</h4>
            <apexchart
                type="area"
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
 * https://apexcharts.com/javascript-chart-demos/area-charts/stacked/
 */
import VueApexCharts from 'vue3-apexcharts';

export default {
    name: 'AreaStackedChartComponent',

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
                    stacked: true,
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
                    curve: 'smooth'
                },
                title: {
                    text: 'Candidates per jobs dynamic',
                    align: 'left',
                    offsetX: 25
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        opacityFrom: 0.6,
                        opacityTo: 0.8,
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'left',
                    floating: true,
                    offsetY: -10,
                    offsetX: 0,
                },
                tooltip: {
                    y: {
                        formatter: (val) => val
                    }
                },
                yaxis: {
                    title: {
                        text: 'Candidates per job'
                    },
                    labels: {
                        formatter: (val) => val.toFixed(0),
                    }
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
            },
        };
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
