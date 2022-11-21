function getQueryString() {
   let uri = document.location.href.split('?');
   if (uri.length > 1) {
      var queryString = uri[1];
   } else {
      var queryString = '';
   }
   return queryString;
}

function changeLocaleTo(locale) {
   var uri = document.location.href;
   if (locale === 'eu') {
      var url = uri.replace('/es/', '/' + locale + '/');
   } else {
      var url = uri.replace('/eu/', '/' + locale + '/');
   }
   window.location.href = url;
}

export {
   getQueryString,
   changeLocaleTo
};
export default getQueryString;