<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="Generator" content="EditPlus®">
    <meta name="Author" content="">
    <meta name="Keywords" content="">
    <meta name="Description" content="">
    <title>注册</title>
</head>
<body>
<h2>用户登录</h2>
<form action="/user/login" method="post">
    @csrf
    用户名：<input type="text" name="name" placeholder="用户名/Email"><br>
    密码：<input type="password" name="pass"><br>
    <input type="submit" value="登录">
</form>
</body>
</html>
