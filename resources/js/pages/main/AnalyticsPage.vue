<template>
    <div>
        <div class="row mb-5">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <FiltersComponent :filters="filters" />
            </div>
        </div>

        <div
            v-if="isChartsLoaded"
            class="loading-spinner d-flex justify-content-center align-items-center"
        >
            <div class="spinner-border text-secondary mt-5 mb-5" role="status">
                <span class="visually-hidden">Data loading...</span>
            </div>
        </div>

        <div v-else>
            <div class="row mb-3">
                <h3>Candidates per jobs, dynamic (weekly)</h3>
            </div>
            <div class="row mb-4">
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <LineAreaChart
                        :series="charts.candidatesPerJobs.dou"
                        :title="chartsOptions.candidatesPerJobs.titles.dou"
                        :ytitle="chartsOptions.candidatesPerJobs.ytitle"
                        :xcategories="categories"
                    />
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <LineAreaChart
                        :series="charts.candidatesPerJobs.djinni"
                        :title="chartsOptions.candidatesPerJobs.titles.djinni"
                        :ytitle="chartsOptions.candidatesPerJobs.ytitle"
                        :xcategories="categories"
                    />
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <LineAreaChart
                        :series="charts.candidatesPerJobs.workua"
                        :title="chartsOptions.candidatesPerJobs.titles.workua"
                        :ytitle="chartsOptions.candidatesPerJobs.ytitle"
                        :xcategories="categories"
                    />
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <LineAreaChart
                        :series="charts.candidatesPerJobs.rabotaua"
                        :title="chartsOptions.candidatesPerJobs.titles.rabotaua"
                        :ytitle="chartsOptions.candidatesPerJobs.ytitle"
                        :xcategories="categories"
                    />
                </div>
            </div>
        </div>

        <!-- TODO These are demo charts. Before merging with dev branch, you need to display them -->
        <div style="display: none">
            <h1>Demo charts</h1>
            <div class="row mb-5">
                <div class="col-sm-12 col-md-8 col-lg-8">
                    <CandidatesPerJobsWidgetComponent />
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-sm-12 col-md-8 col-lg-8">
                    <CandidatesPerJobsBarDemoWidgetComponent />
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-sm-12 col-md-8 col-lg-8">
                    <LineWithDataLabelsChartComponent />
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-sm-12 col-md-8 col-lg-8">
                    <AreaStackedChartComponent />
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-sm-12 col-md-8 col-lg-8">
                    <ColumnChartsComponent />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { actionTypes } from '../../store/analytics/actions';
import { mapState } from 'vuex';

/**
 * Components
 */
import FiltersComponent from '../../components/analytics/FiltersComponent.vue';
import LineAreaChart from '../../components/widgets/charts/apexcharts/LineAreaChart.vue';

// TODO Demo charts
import CandidatesPerJobsWidgetComponent from '../../components/widgets/charts/CandidatesPerJobsWidgetComponent.vue';
import CandidatesPerJobsBarDemoWidgetComponent
    from '../../components/widgets/charts/demo_charts/CandidatesPerJobsBarDemoWidgetComponent.vue';
import LineWithDataLabelsChartComponent
    from '../../components/widgets/charts/demo_charts/apexcharts/LineWithDataLabelsChartComponent.vue';
import AreaStackedChartComponent
    from '../../components/widgets/charts/demo_charts/apexcharts/AreaStackedChartComponent.vue';
import ColumnChartsComponent from '../../components/widgets/charts/demo_charts/apexcharts/ColumnChartsComponent.vue';

export default {
    name: 'AnalyticsPage',

    props: ['filters'],

    components: {
        FiltersComponent,
        LineAreaChart,


        // TODO demo charts
        CandidatesPerJobsWidgetComponent,
        CandidatesPerJobsBarDemoWidgetComponent,
        LineWithDataLabelsChartComponent,
        AreaStackedChartComponent,
        ColumnChartsComponent,
    },

    data() {
        return {
            chartsOptions: {
                candidatesPerJobs: {
                    titles: { dou: 'dou.ua', djinni: 'djinni.co', workua: 'work.ua', rabotaua: 'rabota.ua'},
                    ytitle: 'Candidates per job',
                }
            }
        };
    },

    computed: {
        ...mapState({
            isLoading: (state) => state.analytics.isLoading,
            isLoaded: (state) => state.analytics.isLoaded,
            isChartsLoaded: (state) => state.analytics.isChartsLoaded,
            categories: (state) => state.analytics.weeklyPeriod,
            charts: (state) => state.analytics.charts,
        }),
    },

    mounted() {
        this.$store.dispatch(actionTypes.init, {
            specializationPosition: 'sp_qa_middle',
            experience: ['exp_all'], // must be array
            dateStart: this.filters.periodStart,
            dateEnd: this.filters.periodEnd,
        });
    }
}
</script>

<style scoped>

</style>
