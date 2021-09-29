require('./bootstrap');

import VuePersianDatetimePicker from 'vue-persian-datetime-picker';

Vue.component('date-picker', VuePersianDatetimePicker);
import vSelect from 'vue-select'

Vue.component('v-select', vSelect);

const app = new Vue({
    el: '#ivi3',
    components: {},
    data: {
        options: [],
        optionsAgencies: [],
        valueCitiesTour: null,
        value_cities_tour: null,
        valueContinentsTour: null,
        value_continents_tour: null,
        valueCountriesTour: null,
        value_countries_tour: null,
        valueServiceTour: null,
        value_service_tour: null,
        valueOriginTour: null,
        value_origin_tour: null,
        value_agencies: null,
        valueAgency: null,
        agency: null
    },
    watch: {
        value_cities_tour: function (val) {
            this.valueCitiesTour = JSON.stringify(val);
            this.options = [];
        },
        value_continents_tour: function (val) {
            this.valueContinentsTour = JSON.stringify(val);
            this.options = [];
        },
        value_countries_tour: function (val) {
            this.valueCountriesTour = JSON.stringify(val);
            this.options = [];
        },
        value_service_tour: function (val) {
            this.valueServiceTour = JSON.stringify(val);
        },
        value_origin_tour: function (val) {
            this.valueOriginTour = val.id;
            this.options = [];
        },
        value_agencies: function (val) {
            this.valueAgency = val.id;
            this.optionsAgencies = [];
        },
    },
    methods: {
        onSearch(search, loading) {
            loading(true);
            axios.get('/admin/lisCity', {
                params: {
                    search: search,
                },
            }).then(({data}) => {
                this.options = data;
                loading(false);
            }).catch(error => console.log(error));
        },
        onSearchCountry(search, loading) {
            loading(true);
            axios.get('/admin/lisCountries', {
                params: {
                    search: search,
                },
            }).then(({data}) => {
                this.options = data;
                loading(false);
            }).catch(error => console.log(error));
        },
        onSearchContinent(search, loading) {
            loading(true);
            axios.get('/admin/lisContinents', {
                params: {
                    search: search,
                },
            }).then(({data}) => {
                this.options = data;
                loading(false);
            }).catch(error => console.log(error));
        },
        onSearchAgency(search, loading) {
            loading(true);
            axios.get('/admin/listAgencies', {
                params: {
                    search: search,
                },
            }).then(({data}) => {
                this.optionsAgencies = data;
                loading(false);
            }).catch(error => console.log(error));
        },
    }
});