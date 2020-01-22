<html>
<head>
<meta charset="UTF-8">
<title>成績確認</title>
<h1 style="color:white; background-color:#00FF99;">打撃成績確認ページ</h1>
</head>
<body>
<form>
<h2 style="color:#00FF99;">試合結果</h2>
<h3 style="color:#00FF99;">打撃成績</h3>
<?php
session_start();
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

$sql = 'SELECT gdata.u_id,gdata.id,gdata.gname,gdata.itidaseki,gdata.nidaseki,gdata.sandaseki,gdata.yondaseki,gdata.comment FROM gdata JOIN userDeta ON userDeta.id = gdata.u_id AND userDeta.id = ?';
	$stmt = $pdo->prepare($sql);
	$stmt -> execute(array($_SESSION["ID"]));
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row["id"].',';
		echo $row['gname'].',';
		echo $row['itidaseki'].',';
		echo $row['nidaseki'].",";
		echo $row['sandaseki'].",";
		echo $row['yondaseki'].",";
		echo $row["comment"]."<br>";
		echo "<hr>";
	}
?>
<br>
<h3 style="color:#00FF99;">フォーム画像、動画</h3>
<?php

$sql="SELECT * FROM medianew ORDER BY id";
$stmt = $pdo -> prepare($sql);
$stmt -> execute();
  while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
        echo ($row["id"]."<br/>");
        //動画と画像で場合分け
        $target = $row["fname"];
        if($row["extension"] == "mp4"){
            echo ("<video src=\"import_media.php?target=$target\" width=\"426\" height=\"240\" controls></video>");
        }
        elseif($row["extension"] == "jpeg" || $row["extension"] == "png" || $row["extension"] == "gif"){
            echo ("<img src='import_media.php?target=$target'>");
        }
        echo ("<br/><br/>");
    }

?>
</form>
操作指定番号：<form action="check.php" method="post">
<input type="text" name="delno" >
<p><input type="submit" name="back" value="戻る"><input type="submit" name="delete" value="削除"></p>
</form>
</body>
</html>
<?php
if(!empty($_POST["back"])){
	header("Location: mainpage.php");
}
else if(!empty($_POST["delno"])){//削除
$id = $_POST["delno"];
	$sql = 'delete from gamedata where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();

	$sql = 'delete from medianew where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
 
}
?>