// window._ = require('lodash');
import './myFunction';



try {
    // window.Popper = require('popper.js').default;
    // window.$ = window.jQuery = require('jquery');
    // require('bootstrap');
} catch (e) {
}


window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
window.Vue = require('vue');

Vue.directive('init', {
    bind: function(el, binding, vnode) {
        vnode.context[binding.arg] = binding.value;
    }
});
// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
