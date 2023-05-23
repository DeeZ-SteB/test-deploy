<template>
    <apexchart
        ref="testChart"
        type="area"
        height="550"
        :options="chartOptions"
        :series="series"
    ></apexchart>
</template>

<script>
/**
 * https://apexcharts.com/javascript-chart-demos/area-charts/stacked/
 */
import VueApexCharts from 'vue3-apexcharts';

export default {
    name: 'LineAreaChart',

    components: { apexchart: VueApexCharts },

    props: ['series', 'title', 'ytitle', 'xcategories'],

    data() {
        return {
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
                    text: this.title,
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
                        text: this.ytitle,
                    },
                    labels: {
                        formatter: (val) => val.toFixed(0),
                    }
                },
                xaxis: {
                    title: {
                        // text: 'Weekly'
                    },
                    categories: this.xcategories,
                },
            },
        };
    },


}
</script>

<style scoped>

</style>
