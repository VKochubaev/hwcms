<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Система управления сайтом</title>
	<base href="{$doc_base}"/>
    <link href="/cms/side/back/css/style.css" rel="stylesheet">
    <link href="/cms/side/back/css/style-responsive.css" rel="stylesheet">
    <script src="/cms/side/back/js/jquery.min.js"></script>
	<script src="/cms/side/back/js/bootstrap.min.js"></script>
    <script src="/cms/side/back/js/respond.min.js"></script>
</head>

<body class="login-body">
     <div class="login-logo">
     	<img src="/cms/side/back/images/logo-login.png"/>
     </div>

     <div class="container log-row">
     	<form class="form-signin" method="post">
        	<div class="login-wrap">
            	{messages}
            	<input name="hw_admin_name" type="text" class="form-control" placeholder="Имя пользователя" autocomplete="off" autofocus>
            	<input name="hw_admin_passw" type="password" class="form-control" placeholder="Пароль" autocomplete="off">
            	<button class="btn btn-success btn-block" id="button" type="submit">ВОЙТИ</button>
        	</div>
     	</form>
     </div>
</body>
</html>