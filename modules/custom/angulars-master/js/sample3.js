/**
 * @file
 *  Related JavaScript.
 */

/**
 * Declare the app.
 */
var s3_app = angular.module('s3_app', []);

/**
 * Directive with restriction "E" works on custom elements.
 */
s3_app.directive('s3directive', function() {
  return {
    restrict: 'E',
    template: '<span><b>Result:</b> Directive with "E" restriction implemented on &lt;s3directive&gt; element.</span>'
  };
});

/**
 * Directive with restriction "A" works on custom attributes.
 */
s3_app.directive('s3directivea', function() {
  return {
    restrict: 'A',
    template: '<span><b>Result:</b> Directive with "A" restriction implemented on &lt;span s3directivea&gt; element.</span>'
  };
});

/**
 * Directive with restriction "C" works on classes.
 */
s3_app.directive('s3directiveb', function() {
  return {
    restrict: 'C',
    template: '<span><b>Result:</b> Directive with "C" restriction implemented on &lt;span class="s3directivec"&gt; element.</span>'
  };
});


/**
 * We need to bootstrap the app manually to the container by id, since we have
 *  more tha one app on the same page.
 */
angular.element(document).ready(function() {
  angular.bootstrap(document.getElementById("s3_container"),['s3_app']);
});