import '../../css/topic/edit.scss';

import $ from 'jquery';
const routes = require('../../../public/js/fos_js_routes.json');
import Routing from '../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
import getQueryString from '../common/utils.js';

$(function() {
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
        window.location.href = global.app_base + Routing.generate('topic_list', {
            '_locale': global.locale
        }) + queryString;
    });
    /* End Events */
});