var voxControllers = angular.module('voxControllers', []);

voxControllers.controller('PostListCtrl', ['$scope', '$http',
    function ($scope, $http) {

        $scope.posts = [];

        //$http.get('/posts/get').success(function(data) {
        //    $scope.posts = data;
        //});

        $scope.posts = [
            { id: 1, title: "First Post on Vox", author: "Mario Rossi", author_id: 1, excerpt: "Here we are! Finally this is my first post on Vox and I am so happy that...", date: "08/01/2015" },
            { id: 2, title: "Second Post on Vox", author: "Lukas Schneider", author_id: 2, excerpt: "Well this is already my second post and so you already know that...", date: "11/01/2015" }
        ];

        /**
         * Returns Author's profile picture
         *
         * @param author_id
         * @returns {string}
         */
        $scope.getAuthorPicture = function(author_id) {
            return 'http://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50';
        };


    }]);

voxControllers.controller('PostCtrl', ['$scope', '$routeParams',
    function($scope, $routeParams) {

        $scope.phoneId = $routeParams.phoneId;

    }]);
