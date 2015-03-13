var voxApp = angular.module('voxApp', [
    'ngRoute',
    'voxControllers'
]);

voxApp.config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});
