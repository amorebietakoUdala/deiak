/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
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