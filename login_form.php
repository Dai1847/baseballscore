<html>
<head>
<meta charset="UTF-8">
<title>ログイン</title>
<h1>野球成績記録アプリ</h1>
<link rel="stylesheet" href="sample.css" type="text/css">
</head>
<body>
<div class="login">
<h1>ログインフォーム</h1>
<form action="login.php" method="post">
<p>ログイン<input type="text" name="email" placeholder="メールアドレス"></p>
<p><input type="password" name="password" placeholder="パスワード"></p>
<p class="submit"><input type="submit" name="login" value="ログイン"></p>
</form>
</div>
<br>
<div class="login">
<h1>新規登録</h1>
<form action="signup.php" method="post">
<p>登録<input type="text" name="email" placeholder="メールアドレス"></p>
<p><input type="password" name="password" placeholder="パスワード"></p>
<p class="submit"><input type="submit" name="signup" value="登録"></p>
</form>
</div>
</body>
</html>
