/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

'use strict';
angular.module('landing', ['ngStorage'])
    .controller('landingController', [
        '$scope',
        '$location',
        '$localStorage',
        function ($scope, $location, $localStorage) {
            $scope.selectLanguage = function () {
                $localStorage.lang = $scope.modelLanguage;
                window.location = 'Index.php/' + $scope.modelLanguage + '/index';
            };
        }
    ]);
