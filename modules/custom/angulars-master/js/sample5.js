/**
 * @file
 *  Related JavaScript.
 */

/**
 * Declare the app.
 */
var s5_app = angular.module('s5_app', []);

/**
 * Declare the controller.
 */
s5_app.controller('s5_ctrl', function s5_ctrl($scope) {

});

/**
 * A directive to bind event to element, creating a behavior.
 */
s5_app.directive('s5', function() {
  return {
    restrict: 'C',
    scope: {
      // Initext attribute mapped to initext scope variable.
      iniText: '=',
    },
    link: function($scope, $elem, $attrs) {
      // Set default value.
      if (typeof($scope.iniText) != 'undefined' || !$scope.iniText) {
        $scope.s5model = 'Initial text';
      }
      else {
        $scope.s5model = $scope.iniText;
      }
    },
    template: '<input type="text" ng-model="s5model" /> {{s5model}}',
  }
});


/**
 * We need to bootstrap the app manually to the container by id, since we have
 *  more tha one app on the same page.
 */
angular.element(document).ready(function() {
  angular.bootstrap(document.getElementById("s5_container"),['s5_app']);
});