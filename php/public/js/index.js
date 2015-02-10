var exampleApp = angular.module('exampleApp', ['ui.bootstrap', 'ngResource', 'ngRoute']);

exampleApp.config(function ($routeProvider, $locationProvider, $httpProvider) {
    $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';

    $locationProvider.html5Mode({
        enabled: true,
        requireBase: false
    });

    return $routeProvider.when('/dashboard', {
        templateUrl: '/template/dashboard.html',
        controller: 'dashboardCtrl'
    }).when('/dashboard/1', {
        templateUrl: '/template/dashboard.html',
        controller: 'dashboardCtrl'
    }).when('/dashboard/2', {
        templateUrl: '/template/dashboard.html',
        controller: 'dashboardCtrl'
    }).otherwise({
        redirectTo: '/dashboard'
    });
});

// Socket.IO用ディレクティブ
exampleApp.factory('socket', ['$rootScope', function ($rootScope) {
    var socket = io.connect(SOCKETIO_CONNECT_PATH);
    return {
        on: function (eventName, callback) {
            socket.on(eventName, function () {
                var args = arguments;
                $rootScope.$apply(function () {
                    callback.apply(socket, args);
                });
            });
        },
        emit: function (eventName, data, callback) {
            socket.emit(eventName, data, function () {
                var args = arguments;
                $rootScope.$apply(function () {
                    if (callback) {
                        callback.apply(socket, args);
                    }
                });
            })
        }
    };
}]);

exampleApp.factory('chatAjaxApi', ['$http', 'socket', function ($http, socket) {
    return {
        sendMessage: function (message) {
            return $http.post(
                '/dashboard/chat',
                {
                    message: message
                }
            )
        }
    }
}]);

exampleApp.controller('indexCtrl', ['$scope', function ($scope) {

}]);

exampleApp.controller('dashboardCtrl', ['$scope', 'socket', 'chatAjaxApi', function ($scope, socket, chatAjaxApi) {
    // ユーザ情報をスコープへ
    $scope.mUserInfo = UserInfo;

    // チャット用オブジェクト
    $scope.mChatObject = {
        type: 0, // チャットタイプ, 1: websockets, 2: ajax
        message: '', // チャット本文
        isDisabled: true // チャットボタン無効化用値
    };

    // タイムライン配列
    $scope.mTimeline = [];

    // チャット送信タイプとメッセージの長さチェック
    var validateChatForm = function () {
        if(($scope.mChatObject.type == 1 || $scope.mChatObject.type == 2) && $scope.mChatObject.message.length > 0) {
            $scope.mChatObject.isDisabled = false;
        } else {
            $scope.mChatObject.isDisabled = true;
        }
    };

    $scope.$watch('mChatObject.type', function (newVal, oldVal) {
        // ボタンテキストの変更
        var label = null;
        if(newVal == 1) {
            label = 'Chat: Websockets';
        } else if(newVal == 2) {
            label = 'Chat: Ajax';
        } else {
            label = 'Action';
        }
        var targets = angular.element('#chat-button-label');
        if (targets.length > 0) {
            targets[0].textContent = label;
        }

        // チャットフォームバリデーション
        validateChatForm();
    });
    $scope.$watch('mChatObject.message', function (newVal, oldVal) {
        // チャットフォームバリデーション
        validateChatForm();
    });

    // チャットタイプ変更用クリックイベント関数
    $scope.onClickSetChatType = function ($event, type) {
        $scope.mChatObject.type = type;
    };

    // チャット送信用クリックイベント関数
    $scope.onClickSendChat = function ($event) {
        if ($scope.mChatObject.message.length > 0) {
            if ($scope.mChatObject.type == 1) {
                socket.emit('chat', $scope.mChatObject.message);
                $scope.mChatObject.message = '';
            } else if ($scope.mChatObject.type == 2) {
                chatAjaxApi.sendMessage($scope.mChatObject.message).success(function (data) {
                    //console.log(data);
                    $scope.mChatObject.message = '';
                }).error(function (data, status) {
                    //console.log(data);
                    //console.log(status);
                });
            } else {
                // 何もしない
                $scope.mChatObject.message = '';
            }
        }
    };

    socket.on('chat', function (messageObject) {
        console.group();
        console.log('chat:');
        console.log(messageObject);
        messageObject['style'] = {color: getRandomColor()};
        $scope.mTimeline.push(messageObject);
        console.groupEnd();
    });

    socket.on('join', function (data) {
        console.group();
        console.log('join:');
        console.log(data);
        $scope.mTimeline.push({
            username: 'Room Join',
            message: data.username
        });
        console.groupEnd();
    });

    socket.on('leave', function (data) {
        console.group();
        console.log('leave:');
        console.log(data);
        $scope.mTimeline.push({
            username: 'Room Leave',
            message: data.username
        });
        console.groupEnd();
    });

    socket.on('debug', function (data) {
        console.group();
        console.log('debug:');
        console.log(data);
        console.groupEnd();
    });

    socket.on('debug2', function (data) {
        console.group();
        console.log('debug2:');
        console.log(data);
        console.groupEnd();
    });
}]);

// http://www.kirupa.com/html5/random_colors_js.htm
function getRandomColor() {
    var r = Math.floor(Math.random()*256);
    var g = Math.floor(Math.random()*256);
    var b = Math.floor(Math.random()*256);
    var hexR = r.toString(16);
    var hexG = g.toString(16);
    var hexB = b.toString(16);
    if (hexR.length == 1) {
        hexR = "0" + hexR;
    }
    if (hexG.length == 1) {
        hexG = "0" + hexG;
    }
    if (hexB.length == 1) {
        hexB = "0" + hexB;
    }
    var hexColor = "#" + hexR + hexG + hexB;
    return hexColor.toUpperCase();
}