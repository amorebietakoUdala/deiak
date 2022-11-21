import '../../css/consultation/edit.scss';

import $ from 'jquery';
const routes = require('../../../public/js/fos_js_routes.json');
import Routing from '../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
import getQueryString from '../common/utils.js';
import { TempusDominus } from '@eonasdan/tempus-dominus';
import customDateFormat from '@eonasdan/tempus-dominus/dist/plugins/customDateFormat';


$(function() {
    var current_locale = $('html').attr("lang");
    $('.js-datepicker').each((i,v) => {
        extend(customDateFormat);
        new TempusDominus(v,{
            display: {
              buttons: {
                close: true,
                clear: true,
              },
              components: {
                useTwentyfourHour: true,
                decades: false,
                year: true,
                month: true,
                date: true,
                clock: false,
              },
            },
            debug: true,
            localization: {
              locale: current_locale+'-'+current_locale.toUpperCase(),
              dayViewHeaderFormat: { month: 'long', year: 'numeric' },
              format: 'yyyy-MM-dd HH:mm',
            },
        });
    });

    /* DOM */
    var btnCancel = $("#cancel");
    /* End DOM */

    /* Events */
    btnCancel.on('click', function() {
        Routing.setRoutingData(routes);

        var queryString = getQueryString();
        if (queryString !== "") {
            $queryString = '?' + queryString;
        }
        window.location.href = global.app_base + Routing.generate('consultation_list', {
            '_locale': global.locale
        }) + queryString;
    });
    /* End Events */
});