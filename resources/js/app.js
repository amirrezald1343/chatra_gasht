require('./bootstrap');







import VuePersianDatetimePicker from 'vue-persian-datetime-picker';
Vue.component('date-picker', VuePersianDatetimePicker);

import vSelect from 'vue-select'
Vue.component('v-select', vSelect);

// import vueSlider from 'vue-slider-component'
// Vue.component('vue-slider', vueSlider);


const app = new Vue({
    el: '#ivi3',
    components: {


    },
    data: {

        valueDestinationTour:null,
        value_destination_tour:null,
        Lowest_flight_prices_month:{
            chart: {
                type: 'line'
            },
            series: [{
                name: 'sales',
                data: [30,40,35,50,49,60,70,91,125]
            }],
            xaxis: {
                categories: [1991,1992,1993,1994,1995,1996,1997, 1998,1999]
            }
        },
        value: [
            20,
            200
        ],
        options:{
            formatter: v => `${('' + v).replace(/\B(?=(\d{3})+(?!\d))/g, ',')} ریال `,
            width: "100%",
            height: 2,
            dotSize: 10,
            disabled: false,
            show: true,
            tooltip: "always",
            tooltipDir: [
                "bottom",
                "top"
            ],
            piecewise: false,
            style: {
                "marginBottom": "30px"
            },
            bgStyle: {
                "backgroundColor": "#fff",
                "boxShadow": "inset 0.5px 0.5px 3px 1px rgba(0,0,0,.36)"
            },
            sliderStyle: [
                {
                    "backgroundColor": "#3498db"
                },
                {
                    "backgroundColor": "#3498db"
                }
            ],
            tooltipStyle: [
                {
                    "backgroundColor": "#3498db",
                    "borderColor": "#3498db"
                },
                {
                    "backgroundColor": "#3498db",
                    "borderColor": "#3498db"
                }
            ],
            processStyle: {
                "backgroundImage": "-webkit-linear-gradient(left, #3498db, #3498db)"
            }
        },
        from_city_flight: null,
        to_city_flight: null,
        to_city_hotel: null,
        to_country_insurance : null,
        to_duration_insurance : null,
        to_birth_date_insurance : null,
        result: null,
        picked: 'two',
        showdate_to_display: 'display : block',
        external_showdate_to_display: 'display : block',
        index: {
            search: {
                from: {
                    city: '',
                    loading: false,
                    res: {},
                    choosing: '',
                    showPanel: false
                },
                to: {
                    city: '',
                    loading: false,
                    res: {},
                    choosing: '',
                    showPanel: false
                },
                flightType: "two",
            }
        },
        listflight: {
            form: {
                passenger: false,
                body:false,
                click:true,
                errorePassnger: '',
            },
        },
        listinsurance: {
            form: {
                passenger: false,
                body:false,
                click:true,
                errorPassenger: '',
            }
        },
        listBirthDate : [{

        }],
        date: '',
        color:'var(--ivi3-color)',
        birthDateInsuranceName: null,
        fromCityFlightCode:null,
        toCityFlightCode:null,
        toCityHotelCode:null,
        toCountryInsuranceCode:null,
        toDurationInsuranceCode:null,
        toBirthDateInsuranceCode : null,
        numberpassenger:1,
        InsuranceNumberPerson:1,
        adults:1,
        person:1,
        children:0,
        baby:0,
        checkedAirlines:[],
        CheckedWatch:[],
        typeFlight:[],
        cabinType:[],
        starHotel:[],
        hotelType:[],
        sortpriceSelect:'default',
        sortPriceDefault:[],
        statusSortPriceDefault:true,
        sortwatchSelect:'default',
        sortwatchDefault:[],
        statusSortwatchDefault:true,
        birthdate:"",
        reserve:{
            nationality : []
        },
        mainValuePriceFilterFlight: [],
        DeselectFlight: {
            render: createElement => createElemfrom_city_flightent('span', '❌'),
        },
        start_date_form_flight: '',
        end_date_form_flight: '',
        statusExchangeFlightRoute: true,
        flight_form_type: 'one',
        external_flight_form_type: 'one',
        BoxLoginRegisterApp:false,
        is_active_tab_login_header:true,
        is_active_tab_register_header:false,
        titleBoxLoginRegisterApp:true,
        optionsExternalFlightFrom:[],
        from_city_external_flight: null,
        fromCityExternalFlightCode:null,
        listOptionsExternalFlightFrom:[]
    },
    watch: {
        value_destination_tour: function (val) {
            if(val == null){
                this.valueDestinationTour = '';
            }else {
                this.valueDestinationTour = JSON.stringify(val);
            }
        },
        is_active_tab_login_header:function (val) {
            this.is_active_tab_register_header = !val;
        },
        is_active_tab_register_header:function (val) {
            this.is_active_tab_login_header = !val;
        },
        end_date_form_flight: function(val){
            if(val !== null && val !== '' && this.statusExchangeFlightRoute == false){
                setTimeout(function () {
                    document.querySelector("#passengers-form-flight-index").click();
                },50);
            }
        },
        start_date_form_flight: function () {
            if(!this.statusExchangeFlightRoute){
                this.end_date_form_flight = '';
            }
            if(this.flight_form_type == 'two' && this.statusExchangeFlightRoute == false){
                setTimeout(function () {
                    document.querySelector("#flight-date-end .vpd-icon-btn").click();
                },200);
            }else if (this.flight_form_type == 'one' && this.statusExchangeFlightRoute == false){
                setTimeout(function () {
                    document.querySelector("#passengers-form-flight-index").click();
                },50);
            }
        },
        from_city_flight: function (val) {
            if(val === null){
                this.fromCityFlightCode = '';
            }else {
                this.fromCityFlightCode = val.countryCode;
                if(this.statusExchangeFlightRoute == false){
                    setTimeout(function () {
                        document.querySelector("#to_city_flight .vs__selected-options input").focus();
                    },50);
                }
            }
        },
        to_city_flight: function (val) {
            if(val === null){
                this.toCityFlightCode = '';
            }else {
                this.toCityFlightCode = val.countryCode;
                if(this.statusExchangeFlightRoute == false){
                    setTimeout(function () {
                        document.querySelector("#flight-date-start .vpd-icon-btn").click();
                    },50);
                }else {
                    this.statusExchangeFlightRoute = false;
                }
            }
        },
        to_city_hotel: function (val) {
            this.toCityHotelCode = val.countryCode
        },
        to_country_insurance: function (val) {
            this.toCountryInsuranceCode = val.countryCode
        },
        to_duration_insurance: function (val) {
            this.toDurationInsuranceCode = val.durationCode
        },
        to_birth_date_insurance : function (val) {
            this.toBirthDateInsuranceCode = val.BirthDateCode
        }
    },
    mounted(){
    },
    methods: {
        onSearch(search, loading) {
            loading(true);
            axios.get('/lisCity', {
                params: {
                    search: search,
                },
            }).then(({data}) => {
                console.log(data.items);
                this.options = data;
                loading(false);
            }).catch(error => console.log(error));
        },
        onSearchExternalFlightFrom(search) {
            this.listOptionsExternalFlightFrom = [];
            var i = 0;
            JSON.parse(this.$store.state.ExternalIata).forEach(function (itemCountry, indexCountry) {
                itemCountry.city.forEach(function (itemCity, indexCity) {
                    var patt = new RegExp("[\u0600-\u06FF]");
                    if (patt.test(search) == true) {
                        if(itemCity.cityFa.length >= search.length && search.length > 1){
                            if(itemCity.cityFa.slice(0, search.length).indexOf(search) > -1){
                                itemCity.airports.forEach(function (itemAirport, indexAirport) {
                                    var obj = {
                                        countryName: itemCity.cityFa+'، '+itemCountry.countryFa+'('+itemAirport.iata+'-'+itemAirport.fa+')',
                                        countryCode: itemAirport.iata,
                                        icon: 'fa-plane'
                                    };
                                    this.listOptionsExternalFlightFrom[i] = obj;
                                    ++i;
                                },this);
                            }
                        }
                    } else {
                        if(itemCity.cityEn.length >= search.length && search.length > 1){
                            var text =  itemCity.cityEn.toLowerCase();
                            if(text.slice(0, search.length).indexOf(search) > -1){
                                itemCity.airports.forEach(function (itemAirport, indexAirport) {
                                    var obj = {
                                        countryName: itemCity.cityEn+'، '+itemCountry.countryEn+'('+itemAirport.iata+'-'+itemAirport.en+')',
                                        countryCode: itemAirport.iata,
                                        icon: 'fa-plane'
                                    };
                                    this.listOptionsExternalFlightFrom[i] = obj;
                                    ++i;
                                },this);
                            }
                        }
                    }
                },this);
            },this);
        },
        refund(factorCode){
            if(this.$store.state.refund.factorCode != factorCode){
                this.$store.state.refund.step = 1;
                this.$store.state.refund.factorCode = factorCode;
                this.$store.state.refund.RefundType = '';
                this.$store.state.refund.RefundCause = '';
                this.$store.state.refund.RefundPassengers = '';
                this.$store.state.RefundGateway = '';
                this.$store.state.refund.InfoPassengers.ListPassengers = [];
                this.$store.state.refund.InfoPassengers.confirmationRules = false;
                this.$store.state.refund.AccountHolderNameAndSurname = '';
                this.$store.state.refund.cardNumber = '';
                this.$store.state.refund.shabaNumber = '';
            }
            var ComponentClass = Vue.extend(RefundOnline);
            var instance = new ComponentClass({
                store,
                propsData:{

                }
            });
            instance.$mount('#BoxRefundProfile');
        },
        addFormLoginInHeader(){
            if(!this.is_active_tab_login_header){
                this.is_active_tab_login_header = true;
                var ComponentClass = Vue.extend(LoginPage);
                var instance = new ComponentClass({
                    store,
                    propsData:{

                    }
                });
                instance.$mount('#loginRegisterApp div')
            }
        },
        addFormRegistrInHeader(){
            if(!this.is_active_tab_register_header){
                this.is_active_tab_register_header = true;
                var ComponentClass = Vue.extend(RegisterPage);
                var instance = new ComponentClass({
                    store,
                    propsData:{

                    }
                });
                instance.$mount('#loginRegisterApp div')
            }
        },
        formFlightIndex(){
            this.statusExchangeFlightRoute = false;
        },
        deleteFilter() {
            this.value = this.mainValuePriceFilterFlight;
            document.querySelectorAll(".custom-control-input").forEach(function (item, index) {
                if (item.checked) {
                    item.click();
                }
            });
        },
        exchangeFlightRoute(){
            var from = this.from_city_flight;
            var to = this.to_city_flight;
            this.fromCityFlightCode =  to.countryCode;
            this.toCityFlightCode = from.countryCode;
            this.statusExchangeFlightRoute = true;
            this.from_city_flight = to;
            this.to_city_flight = from;
        },
        sortwatch(){
            $('#listFlight  .sorting-middle-holder .sort-by li a').removeClass('active');
            $('#sortwatchListFlight').addClass('active');
            if ($('#sortwatchListFlight').hasClass('sortPrice')) {
                this.sortwatchSelect = 'lower';
            } else {
                this.sortwatchSelect = 'higher';
            }
            $('#sortwatchListFlight').toggleClass('sortPrice');
            let boxDetailFlights=document.querySelectorAll(".boxDetailFlight");
            let watchs=[];
            let sortwatch=[];
            var sortwatchDefault=[];
            boxDetailFlights.forEach(function (item, index) {
                watchs[index]=item.getAttribute('watch');
                sortwatchDefault[index]=item.getAttribute('watch');
            });
            if(this.statusSortwatchDefault == true){
                this.statusSortwatchDefault=false;
                this.sortwatchDefault=sortwatchDefault;
            }
            if(this.sortwatchSelect == 'lower'){
                sortwatch = watchs.sort(function(a, b){return a-b});
            }else if(this.sortwatchSelect == 'higher'){
                sortwatch = watchs.sort(function(a, b){return b-a});
            }else if(this.sortwatchSelect == 'default'){
                sortwatch = this.sortwatchDefault;
            }else {
                sortwatch = this.sortwatchDefault;
            }
            sortwatch.forEach(function (item, index) {
                document.querySelector("[watch='"+ item +"']").style.order = index +1;
            });
        },
        sortprice(){
            $('#listFlight  .sorting-middle-holder .sort-by li a').removeClass('active');
            $('#sortpriceListFlight').addClass('active');
            if ($('#sortpriceListFlight').hasClass('sortPrice')) {
                this.sortpriceSelect = 'lower';
            } else {
                this.sortpriceSelect = 'higher';
            }
            $('#sortpriceListFlight').toggleClass('sortPrice');
            let boxDetailFlights=document.querySelectorAll(".boxDetailFlight");
            let prics=[];
            let sortPrice=[];
            var sortPriceDefault=[];
            boxDetailFlights.forEach(function (item, index) {
                prics[index]=item.getAttribute('price');
                sortPriceDefault[index]=item.getAttribute('price');
            });
            if(this.statusSortPriceDefault == true){
                this.statusSortPriceDefault=false;
                this.sortPriceDefault=sortPriceDefault;
            }
            if(this.sortpriceSelect == 'lower'){
                sortPrice = prics.sort(function(a, b){return a-b});
            }else if(this.sortpriceSelect == 'higher'){
                sortPrice = prics.sort(function(a, b){return b-a});
            }else if(this.sortpriceSelect == 'default'){
                sortPrice = this.sortPriceDefault;
            }else {
                sortPrice = this.sortPriceDefault;
            }
            sortPrice.forEach(function (item, index) {
                document.querySelector("[price='"+ item +"']").style.order = index +1;
            });

        },
        FilterListFlight(value , array =[]) {
            let status=false;
            if( _.isEmpty(array)){
                return true;
            }
            array.forEach(function (valuearray , keyarray) {
                if(valuearray == value ){
                    status = true;
                }
            });
            return status;
        },
        FilterListFlightPrice(value , array =[]){
            let status=false;
            if(value >=  array[0] && value <=  array[1]){
                status=true;
            }
            return status;
        },
        isMobile(){
            return screen.width < 992
        },
        searchCity(location){
            if (this.index.search[location].city.length >= 3 && this.index.search[location].loading === false) {
                this.index.search[location].loading = true;
                axios.post('/Api/searchCity', {
                    city: this.index.search[location].city
                })
                    .then(({data}) => {
                        if (data.count > 0) {
                            this.index.search[location].res = data;
                            this.index.search[location].showPanel = true;
                        }
                        this.index.search[location].loading = false;
                    })
                    .catch(({errors}) => {
                        console.log(errors)
                        this.index.search[location].loading = false;
                    });
            }
        },
        switchFocus(ref){
            this.$refs[ref].focus();
        },
        // clickInSite(){
        //         //     if (this.index.search.from.showPanel) this.index.search.from.showPanel = false;
        //         //     if (this.index.search.to.showPanel) this.index.search.to.showPanel = false;
        //         //     if (!this.listflight.form.click) this.listflight.form.passenger =  false;
        //         //     if (!this.listinsurance.form.click) this.listinsurance.form.passenger =  false;
        //         //     if (this.listflight.form.click)  this.listflight.form.click =  false;
        //         //     if (this.listinsurance.form.click)  this.listinsurance.form.click =  false;
        //         //     if (!this.titleBoxLoginRegisterApp) this.BoxLoginRegisterApp =  false;
        //         //     if (this.titleBoxLoginRegisterApp)  this.titleBoxLoginRegisterApp =  false;
        //         // },
        showEle(ref){
            this.$refs[ref].classList.toggle('d-block');
            let dom = _.parents(this.$refs[ref]).children;
            Array.from(dom).forEach((elem, index) => {
                if(!elem.classList.contains('d-block'))  elem.classList.add("d-none")
            });
        },
        PPassenger(a){
            if(this.numberpassenger < 9) this.numberpassenger ++ ;
        },
        pPerson(a){
            if(this.InsuranceNumberPerson < 9) this.InsuranceNumberPerson ++ ;
            var ComponentClass = Vue.extend(BirthDate);
            var instance = new ComponentClass({
                propsData:{
                    count : this.InsuranceNumberPerson,
                }
            });
            instance.$mount(); // pass nothing
            console.log(this.$refs);
            this.$refs.otherBirthDates.appendChild(instance.$el);
        },
        zPassenger(a){
            if(this.numberpassenger > 0) this.numberpassenger --;
        },
        mPerson(a){
            if(this.InsuranceNumberPerson > 0)
                document.getElementById('birthDate'+this.InsuranceNumberPerson).remove();
            this.InsuranceNumberPerson --;
        },
        passengerZiro(type){
            if( this[type] > 0)
            {
                if(type == 'person'){
                    if(this.InsuranceNumberPerson > 1) {
                        this.listinsurance.form.errorPassenger = '';
                        this.mPerson();
                        this[type] --
                    }else{
                        this.listinsurance.form.errorPassenger = 'تعداد شخص نمی‌تواند کمتر از 1 باشد.'
                    }
                }
                if(type == 'adults'){
                    if(this.numberpassenger > 1)
                    {
                        if(this[type] > 1)
                        {
                            if(this.baby < this.adults)
                            {
                                if(((this.adults-1)*2) >= (this.baby+this.children))
                                {
                                    this.listflight.form.errorePassnger ='';
                                    this.zPassenger();
                                    this[type] --
                                }else {
                                    this.listflight.form.errorePassnger ='به ازای هر بزرگسال، ۲ کودک، یا یک کودک و یک نوزاد مجاز است.';
                                }
                            }else {
                                this.listflight.form.errorePassnger ='به ازای هر بزرگسال، ۲ کودک، یا یک کودک و یک نوزاد مجاز است.';
                            }
                        }else {
                            this.listflight.form.errorePassnger ='تعداد بزرگسالان نمی‌تواند کمتر از 1 باشد.';
                        }
                    }else {
                        this.listflight.form.errorePassnger ='تعداد بزرگسالان نمی‌تواند کمتر از 1 باشد.';
                    }
                }
                if(type == 'children'){
                    if(this.numberpassenger >= 0 ) {
                        this.listflight.form.errorePassnger ='';
                        this.zPassenger();
                        this[type] --
                    }
                }
                if(type == 'baby'){
                    if(this.numberpassenger >= 0 ) {
                        this.listflight.form.errorePassnger ='';
                        this.zPassenger();
                        this[type] --
                    }
                }
            }
        },
        passengerPlus(type){
            if( this[type] < 9)
            {
                if(type == 'adults'){
                    if(this.numberpassenger < 9 )
                    {
                        this.listflight.form.errorePassnger ='';
                        this.PPassenger();
                        this[type] ++
                    }else {
                        this.listflight.form.errorePassnger ='حداکثر تعداد مسافران برای پروازهای داخلی 9 نفر است.';
                    }
                }
                if(type == 'person'){
                    if(this.InsuranceNumberPerson < 9 )
                    {
                        this.listinsurance.form.errorPassenger ='';
                        this.pPerson();
                        this[type] ++;
                    }else {
                        this.listinsurance.form.errorPassenger ='حداکثر تعداد مسافران برای بیمه 9 نفر است.';
                    }
                }
                if(type == 'children'){
                    if(this.numberpassenger < 9) {
                        if((this.baby + this.children) < (this.adults*2)){
                            this.listflight.form.errorePassnger ='';
                            this.PPassenger();
                            this[type] ++
                        }else {
                            this.listflight.form.errorePassnger ='به ازای هر بزرگسال، ۲ کودک، یا یک کودک و یک نوزاد مجاز است.';
                        }
                    }else {
                        this.listflight.form.errorePassnger ='حداکثر تعداد مسافران برای پروازهای داخلی 9 نفر است.';
                    }
                }
                if(type == 'baby'){
                    if(this.numberpassenger < 9 ) {
                        if(this.baby < this.adults){
                            if((this.baby+this.children) < (this.adults*2)){
                                this.listflight.form.errorePassnger ='';
                                this.PPassenger();
                                this[type] ++
                            }else {
                                this.listflight.form.errorePassnger ='به ازای هر بزرگسال، ۲ کودک، یا یک کودک و یک نوزاد مجاز است.';
                            }
                        }else {
                            this.listflight.form.errorePassnger ='تعداد نوزادها نمی‌تواند بیشتر از تعداد بزرگسالان باشد.';
                        }
                    }else {
                        this.listflight.form.errorePassnger ='حداکثر تعداد مسافران برای پروازهای داخلی 9 نفر است.';
                    }
                }

            }else {
                this.listflight.form.errorePassnger ='حداکثر تعداد مسافران برای پروازهای داخلی 9 نفر است.';
            }
        }
    },
});
