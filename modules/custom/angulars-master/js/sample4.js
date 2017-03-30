/**
 * @file
 *  Related JavaScript.
 */

/**
 * Declare the app.
 */
var s4_app = angular.module('s4_app', []);

/**
 * A directive to bind event to element, creating a behavior.
 */
s4_app.directive('click', function() {
  return function(scope, element) {
    element.bind('click', function() {
      alert('Click event has fired!');
    });
  }
});


/**
 * We need to bootstrap the app manually to the container by id, since we have
 *  more tha one app on the same page.
 */
angular.element(document).ready(function() {
  angular.bootstrap(document.getElementById("s4_container"),['s4_app']);
});