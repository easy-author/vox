var voxControllers = angular.module('voxControllers', []);

voxControllers.controller('PostListCtrl', ['$scope', '$http',
    function ($scope, $http) {

        $scope.posts = [];

        $http.get('/admin/post/list').success(function(data) {
            $scope.posts = data;
        });

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

voxControllers.controller('PostEditCtrl', ['$scope', '$http',
    function ($scope, $http) {

        var post_id = document.getElementById('post_id').value;
        $scope.post = {};
        $scope.wordCount = 0;

        $http.get('/admin/post/get/' + post_id).success(function(data) {
            $scope.post = data;
        });

        /**
         * Counts Words in Post Content
         */
        $scope.countWords = function() {
            s = $scope.post.content;
            s = s.replace(/(^\s*)|(\s*$)/gi,"");//exclude  start and end white-space
            s = s.replace(/[ ]{2,}/gi," ");//2 or more space to 1
            s = s.replace(/\n /,"\n"); // exclude newline with a start spacing

            $scope.wordCount = s.split(' ').length;
        };

        /**
         * Saves Post
         */
        $scope.savePost = function() {
            console.log('saving post ' + post_id);
        };


    }]);