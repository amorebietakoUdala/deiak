import './css/app.scss';

import './bootstrap';

import $ from 'jquery';
import 'bootstrap';
import 'popper.js';

import '@fortawesome/fontawesome-free/js/all.js';

global.app_base = '/deiak';
global.locale = $('html').attr("lang");

$(function () {
    window.$ = $
});