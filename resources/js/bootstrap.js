import $ from 'jquery';
window.$ = window.jQuery = $;

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;


/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });

// AlpineJS
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Select2
import select2 from 'select2';
select2();
import 'select2/dist/css/select2.min.css';

// ApexCharts
import ApexCharts from 'apexcharts';
window.ApexCharts = ApexCharts;

import Swal from 'sweetalert2';
window.Swal = Swal;

import Inputmask from "inputmask/dist/jquery.inputmask";
window.Inputmask = Inputmask;

import Sortable from 'sortablejs/modular/sortable.complete.esm.js';
window.Sortable = Sortable;

import 'blueimp-file-upload/js/jquery.fileupload';
import 'bootstrap-datepicker/dist/js/bootstrap-datepicker.min';
import 'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css';
import 'sweetalert2/dist/sweetalert2.min.css';

import DataTable from 'datatables.net-bs5';
window.DataTable = DataTable;
import 'datatables.net-buttons/js/buttons.html5.mjs';
import 'datatables.net-buttons-bs5';
import 'datatables.net-select-bs5';

import 'daterangepicker/daterangepicker';
import 'daterangepicker/daterangepicker.css';
import 'daterangepicker/moment.min';
