import $ from 'jquery';
import 'bootstrap';
import 'popper.js';

import '../css/app.scss';
import {
    changeLocaleTo
} from './common/utils';

global.app_base = '/deiak';
global.locale = null;

$(function () {
    global.locale = $('html').attr("lang");

    /* DOM */
    var linkLocaleEs = $('#js-locale-es');
    var linkLocaleEu = $('#js-locale-eu');
    /* End DOM */

    /* Events */
    linkLocaleEu.on('click', function (e) {
        e.preventDefault();
        changeLocaleTo('eu');
    });
    linkLocaleEs.on('click', function (e) {
        e.preventDefault();
        changeLocaleTo('es');
    });
    /* End Events */

});