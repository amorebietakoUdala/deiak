import '../../css/consultation/edit.scss';

import $ from 'jquery';
const routes = require('../../../public/js/fos_js_routes.json');
import Routing from '../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
import getQueryString from '../common/utils.js';
import 'bootstrap-datepicker';
import 'bootstrap-datepicker/js/locales/bootstrap-datepicker.es';
import 'bootstrap-datepicker/js/locales/bootstrap-datepicker.eu';
import 'eonasdan-bootstrap-datetimepicker';
import 'pc-bootstrap4-datetimepicker';


$(function () {
   /* Initialization */
   $('#consultation_form_startDate').datetimepicker({
      locale: global.locale + '-' + global.locale,
      format: 'YYYY-MM-DD HH:mm:ss',
   }).attr('type', 'text'); // Honekin chromen ez da testua agertzen
   $('#consultation_form_endDate').datetimepicker({
      locale: global.locale + '-' + global.locale,
      format: 'YYYY-MM-DD HH:mm:ss',
   }).attr('type', 'text'); // Honekin chromen ez da testua agertzen
   /* End Initialization */

   /* DOM */
   var btnCancel = $("#cancel");
   /* End DOM */

   /* Events */
   btnCancel.on('click', function () {
      console.log('Back to Consultation List');
      Routing.setRoutingData(routes);

      var queryString = getQueryString();
      if (queryString !== "") {
         $queryString = '?' + queryString;
      }
      window.location.href = Routing.generate('consultation_list', {
         '_locale': global.locale
      }) + queryString;
   });
   /* End Events */
});