import { Controller } from '@hotwired/stimulus';

import '@eonasdan/tempus-dominus/dist/css/tempus-dominus.css';
import { TempusDominus, extend } from '@eonasdan/tempus-dominus';
import customDateFormat from '@eonasdan/tempus-dominus/dist/plugins/customDateFormat';

export default class extends Controller {

   connect() {
      extend(customDateFormat);
      new TempusDominus(this.element,{
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
           locale: global.locale+'-'+global.locale.toUpperCase(),
           dayViewHeaderFormat: { month: 'long', year: 'numeric' },
           format: 'yyyy-MM-dd HH:mm',
         },
     });
   }


}