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
    <form action="/user/reg" method="post">
        @csrf
        用户名：<input type="text" name="name"><br>
        email：<input type="email" name="email"><br>
        密码：<input type="password" name="pass1"><br>
        确认密码：<input type="password" name="pass2"><br>
        <input type="submit" value="注册">
    </form>
</body>
</html>
