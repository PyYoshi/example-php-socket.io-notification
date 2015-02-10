<!DOCTYPE html>
<html>
<head>
    <?php echo $this->tag->getTitle() ?>
    <link rel="stylesheet" href="/css/bootstrap3/bootstrap.min.css"/>
    <link rel="stylesheet" href="/css/index.css"/>
</head>
<body>
<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">Example</a>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Login</h3>
                </div>
                <div class="panel-body">
                    <form action="/" method="POST">
                        {% if form.hasMessagesFor('username') %}
                            <div class="alert alert-danger" role="alert">
                                {{ form.messages('username') }}
                            </div>
                        {% endif %}
                        <div class="input-group">
                            {{ form.render('username', ['class':'form-control', 'placeholder':'Username', 'minlength':'4', 'maxlength':'12', 'required':'required']) }}
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">Go!</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/js/jquery/jquery.min.js"></script>
<script type="text/javascript" src="/js/bootstrap3/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/angular/angular.min.js"></script>
<script type="text/javascript" src="/js/angular/ui-bootstrap-0.12.0.min.js"></script>
</body>
</html>