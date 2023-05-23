<template>
    <Line
        id="my-chart-id"
        :options="options"
        :data="chartData"
    />
</template>

<script>
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
} from 'chart.js';

import { Line } from 'vue-chartjs';

ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
);

export default {
    name: 'LineChart',

    components: { Line },

    props: ['chartData'],

    data() {
        return {
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
                elements: {
                    arc: {
                        backgroundColor: '#000',
                    },
                    line: {
                        borderWidth: 2,
                    },
                    point: {
                        backgroundColor: '#fff',
                        borderWidth: 2,
                    }
                }
            },
        }
    },
}
</script>

<style scoped>

</style>
