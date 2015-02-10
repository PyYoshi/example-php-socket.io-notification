<!DOCTYPE html>
<html ng-app="exampleApp" ng-controller="indexCtrl">
<head>
    <?php echo $this->tag->getTitle() ?>
    <link rel="stylesheet" href="/css/bootstrap3/bootstrap.min.css"/>
    <link rel="stylesheet" href="/css/index.css"/>
</head>
<body>
<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Example</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/session/logout" target="_self">Logout</a></li>
            </ul>
        </div>

    </div>
</nav>

<script type="text/javascript">
    var SOCKETIO_CONNECT_PATH = "{{ socketIoPath }}";
    var UserInfo = {username: "{{ username }}", userId: "{{ userId }}" };
</script>

<div class="container" ng-view="">
    <noscript>
        <p class="text-error">JavaScript disabled.</p>
        <p class="text-error">You must enable JavaScript of Web Browser.</p>
    </noscript>
</div>

<script type="text/javascript" src="/js/jquery/jquery.min.js"></script>
<script type="text/javascript" src="/js/bootstrap3/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/angular/angular.min.js"></script>
<script type="text/javascript" src="/js/angular/angular-resource.min.js"></script>
<script type="text/javascript" src="/js/angular/angular-route.min.js"></script>
<script type="text/javascript" src="/js/angular/ui-bootstrap-0.12.0.min.js"></script>
<script type="text/javascript" src="http://127.0.0.1:3000/socket.io/socket.io.js"></script>
<script type="text/javascript" src="/js/index.js"></script>
</body>
</html>