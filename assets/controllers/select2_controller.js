import { Controller } from '@hotwired/stimulus';

import $ from 'jquery';
import '../js/common/select2';

export default class extends Controller {
   
   connect() {
      const options={
         theme: "bootstrap-5",
         language: global.locale,
      }
      $(this.element).select2(options);
   }

   


}