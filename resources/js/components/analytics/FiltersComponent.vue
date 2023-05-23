<template>
    <div>
        <div class="row mb-2">
            <div class="form-group col">
                <select
                    v-model="filterData.specializationPosition"
                    @change="filterHandler()"
                    class="form-control"
                    id="inputState"
                >
                    <option value="sp_all" selected>--Specialization/Position--</option>
                    <option v-for="(key, value) in filters.specializationPosition" :value="value">
                        {{ key }}
                    </option>
                </select>
            </div>
            <div class="form-group col">
                <select
                    v-model="filterData.experience"
                    @change="filterHandler()"
                    class="form-control"
                    id="inputState"
                    multiple
                >
                    <option value="exp_all" selected>--Experience--</option>
                    <option v-for="(key, value) in filters.experience" :value="value">
                        {{ key }}
                    </option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col">
                <Datepicker
                    v-model="filterData.period.start"
                    :format="dateFormat"
                    @update:model-value="filterHandler()"
                    :enableTimePicker="false"
                />
            </div>
            <div class="form-group col">
                <Datepicker
                    v-model="filterData.period.end"
                    :format="dateFormat"
                    @update:model-value="filterHandler()"
                    :enableTimePicker="false"
                />
            </div>
        </div>
    </div>
</template>

<script>
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

import { actionTypes as analyticsActions } from '../../store/analytics/actions';

export default {
    name: 'FiltersComponent',

    props: ['filters'],

    components: { Datepicker },

    data() {
        return {
            filterData: {
                specializationPosition: 'sp_all',
                experience: ['exp_all'],
                period: {
                    start: this.filters.periodStart,
                    end: this.filters.periodEnd,
                }
            },
        };
    },

    methods: {
        dateFormat(date) {
            const day = date.getDate();
            const month = date.getMonth() + 1;
            const year = date.getFullYear();

            return `${day}.${month}.${year}`;
        },

        filterHandler() {
            this.$store.dispatch(analyticsActions.init, {
                specializationPosition: this.filterData.specializationPosition,
                experience: this.filterData.experience,
                dateStart: this.filterData.period.start,
                dateEnd: this.filterData.period.end,
            });
        }
    },
}
</script>

<style scoped>

</style>
