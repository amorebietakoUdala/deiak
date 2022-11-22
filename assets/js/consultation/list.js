import '../../css/consultation/list.scss';

import '../common/table-list';
import '../common/select2';
import { TempusDominus, extend } from '@eonasdan/tempus-dominus';
import customDateFormat from '@eonasdan/tempus-dominus/dist/plugins/customDateFormat';

import {
    createConfirmationAlert,
    showAlertNoRedirection
} from '../common/alert';
const routes = require('../../../public/js/fos_js_routes.json');
import Routing from '../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

$(function() {
    var current_locale = $('html').attr("lang");
    /* DOM */
    var $button = $('#button');
    var $table = $('#taula');
    /* End DOM */

    /* Initialization */
    Routing.setRoutingData(routes);

    $('#taula').bootstrapTable({
        cache: false,
        showExport: true,
        exportTypes: ['excel'],
        exportDataType: 'all',
        exportOptions: {
            fileName: "consultations",
            ignoreColumn: ['options']
        },
        showColumns: false,
        pagination: true,
        search: true,
        striped: true,
        sortStable: true,
        detailView: true,
        detailViewIcon: true,
        detailViewByClick: false,
        detailFormatter: detailFormatter,
        pageSize: 10,
        pageList: [10, 25, 50, 100],
        sortable: true,
        locale: $('html').attr('lang') + '-' + $('html').attr('lang').toUpperCase(),
    });
    $(function() {
        $('#toolbar').find('select').change(function() {
            $table.bootstrapTable('destroy').bootstrapTable({
                exportDataType: $(this).val(),
            });
        });
    });

    function detailFormatter(index, row) {
        return row[2];
    }
    $(document).on('click', '.js-delete', function(e) {
        e.preventDefault();
        var url = e.currentTarget.dataset.url;
        createConfirmationAlert(url);
    });

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


    $('.js-topic').select2();
    $(document).on('click', '.js-details', function(e) {
        btnDetailsClick(e);
    });
    $(document).on('click', '.js-topic-remove', function(e) {
        btnTopicRemoveClick(e);
    });
    /* End Initialization */

    /* Events */
    function btnDetailsClick(e) {
        var row = e.currentTarget.dataset.row;
        $table.bootstrapTable('toggleDetailView', row);
    }

    function btnTopicRemoveClick(e) {
        e.preventDefault();
        var url = e.currentTarget.dataset.url;
        var title = e.currentTarget.dataset.confirmation;
        var html = e.currentTarget.dataset.message;
        var confirmationButtonText = e.currentTarget.dataset.confirm;
        var cancelButtonText = e.currentTarget.dataset.cancel;
        showAlertNoRedirection(title, html, confirmationButtonText, cancelButtonText, url, 'DELETE', $(e.currentTarget).parent());
    }
    /* End events */
});