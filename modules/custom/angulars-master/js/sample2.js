/**
 * @file
 *  Related JavaScript.
 */

/**
 * Declare the app.
 */
var s2_app = angular.module('s2_app', []);

/**
 * Declare the controller that adds the default value to scope var.
 */
s2_app.controller('s2_ctrl', function s2_ctrl($scope) {
  $scope.s2 = {message:'Initial text'};
});

/**
 * Declare the custom filter that reverses the string.
 */
s2_app.filter('s2_reverse', function() {
  return function (input) {
    return input.split("").reverse().join("");
  }
});

/**
 * We need to bootstrap the app manually to the container by id, since we have
 *  more tha one app on the same page.
 */
angular.element(document).ready(function() {
  angular.bootstrap(document.getElementById("s2_container"),['s2_app']);
});