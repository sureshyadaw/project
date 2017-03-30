/**
 * @file
 *  Related JavaScript.
 */

// Declare an app.
var s1_app = angular.module('s1_app', []);

/**
 * Declare the controller that adds the default value to scope var.
 */
s1_app.controller('s1_ctrl', function s1_ctrl($scope) {
  $scope.s1 = {message:'Alex Hall'};
});

/**
 * We need to bootstrap the app manually to the container by id, since we have
 *  more tha one app on the same page.
 */
angular.element(document).ready(function() {
  angular.bootstrap(document.getElementById("s1_container"),['s1_app']);
});