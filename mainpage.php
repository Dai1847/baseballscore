<?php
session_start();

?>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="mypage1.css" type="text/css">
<title>メインページ</title>
<nav>
<ul>
<li class="current"><a href="login_form.php">Home</a></li>
<li><a href="kiroku.php">記録</a></li>
<li><a href="check.php">確認</a></li>
<li><a href="profile.php">プロフィール</a></li>
</ul>
</nav>
</head>
<body>
<br>
ようこそ！<?php echo $_SESSION["EMAIL"];?>さん!
<p>このアプリケーションは野球の試合結果を記録するアプリです。</p>
試合結果を記録していくことで自分の練習のヒントになるかも<br>
</body>
</html>