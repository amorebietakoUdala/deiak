import '../../css/topic/list.scss';

import '../common/table-list';
//import 'bootstrap-datepicker';
//import 'bootstrap-datepicker/js/locales/bootstrap-datepicker.es';
//import 'bootstrap-datepicker/js/locales/bootstrap-datepicker.eu';
//import 'eonasdan-bootstrap-datetimepicker';
//import 'pc-bootstrap4-datetimepicker';

import {
   createConfirmationAlert
} from '../common/alert';
const routes = require('../../../public/js/fos_js_routes.json');
import Routing from '../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

$(function () {

   $('#taula').bootstrapTable({
      cache: false,
      showExport: true,
      exportTypes: ['excel'],
      exportDataType: 'all',
      exportOptions: {
         fileName: "users",
         ignoreColumn: ['options']
      },
      showColumns: false,
      pagination: true,
      search: true,
      striped: true,
      sortStable: true,
      pageSize: 10,
      pageList: [10, 25, 50, 100],
      sortable: true,
      locale: $('html').attr('lang') + '-' + $('html').attr('lang').toUpperCase(),
   });
   var $table = $('#taula');
   var $button = $('#button');
   $(function () {
      $('#toolbar').find('select').change(function () {
         $table.bootstrapTable('destroy').bootstrapTable({
            exportDataType: $(this).val(),
         });
      });
   });

   $(document).on('click', '.js-delete', function (e) {
      e.preventDefault();
      var url = e.currentTarget.dataset.url;
      createConfirmationAlert(url);
   });
});