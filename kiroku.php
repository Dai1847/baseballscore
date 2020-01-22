<html>
<head>
<meta charset="UTF-8">
<link rel="styleseet" href="kiroku01.css" type="text.css">
<title>成績記録</title>
<h1 style="color:white; background-color:#00FF99;">打撃成績記録ページ</h1>
</head>
<body>
<form action="kiroku.php" enctype="multipart/form-data" method="post">
<?php
session_start();
try{
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

$sql = "CREATE TABLE IF NOT EXISTS medianew"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "fname TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , "
	. "extension TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ," 
	. "raw_data LONGBLOB NOT NULL "
	.");";

	$stmt = $pdo->query($sql);
	if(isset($_FILES['upfile']['error']) && is_int($_FILES['upfile']['error']) && $_FILES["upfile"]["name"] !== ""){
	        switch ($_FILES['upfile']['error']) {
                case UPLOAD_ERR_OK: // OK
                    break;
                case UPLOAD_ERR_NO_FILE:   // 未選択
                    throw new RuntimeException('ファイルが選択されていません', 400);
                case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過
                    throw new RuntimeException('ファイルサイズが大きすぎます', 400);
                default:
                    throw new RuntimeException('その他のエラーが発生しました', 500);
            }

            //画像・動画をバイナリデータにする．
            $raw_data = file_get_contents($_FILES['upfile']['tmp_name']);

            //拡張子を見る
            $tmp = pathinfo($_FILES["upfile"]["name"]);
            $extension = $tmp["extension"];
            if($extension === "jpg" || $extension === "jpeg" || $extension === "JPG" || $extension === "JPEG"){
                $extension = "jpeg";
            }
            elseif($extension === "png" || $extension === "PNG"){
                $extension = "png";
            }
            elseif($extension === "gif" || $extension === "GIF"){
                $extension = "gif";
            }
            elseif($extension === "mp4" || $extension === "MP4"){
                $extension = "mp4";
            }
            else{
                echo "非対応ファイルです．<br/>";
                echo ("<a href=\"kiroku.php\">戻る</a><br/>");
                exit(1);
            }

            //DBに格納するファイルネーム設定
            //サーバー側の一時的なファイルネームと取得時刻を結合した文字列にsha256をかける．
            $date = getdate();
            $fname = $_FILES["upfile"]["tmp_name"].$date["year"].$date["mon"].$date["mday"].$date["hours"].$date["minutes"].$date["seconds"];
            $fname = hash("sha256", $fname);

            //画像・動画をDBに格納．
            $sql = "INSERT INTO medianew(fname, extension, raw_data) VALUES (:fname, :extension, :raw_data);";
            $stmt = $pdo->prepare($sql);
            $stmt -> bindValue(":fname",$fname, PDO::PARAM_STR);
            $stmt -> bindValue(":extension",$extension, PDO::PARAM_STR);
            $stmt -> bindValue(":raw_data",$raw_data, PDO::PARAM_STR);
            $stmt -> execute();

        }

    }
    catch(PDOException $e){
        echo("<p>500 Inertnal Server Error</p>");
        exit($e->getMessage());
    }

?>
<h2 style="color:#00FF99;">試合</h2>
<input type="text" name="gname" >
<tr>
<h2 style="color:#00FF99;">打撃結果</h2>
<td>
<p>一打席<input type="text" name="itidaseki"></p>
<p>二打席<input type="text" name="nidaseki"></p>
<p>三打席<input type="text" name="sandaseki"></p>
<p>四打席<input type="text" name="yondaseki"></p>
</td>
</tr>
<h2 style="color:#00FF99;">動画、画像アップロード</h2>
<input type="file" name="upfile">
</div>
</div>
<br>
 ※画像はjpeg方式，png方式，gif方式に対応しています．動画はmp4方式のみ対応しています．<br>
<p><input type="submit" value="アップロード"></p>
<?php
$sql="SELECT * FROM medianew ORDER BY id";
$stmt = $pdo -> prepare($sql);
$stmt -> execute();

?>
<h2 style="color:#00FF99;">メモ</h2>
<textarea name="comment" rows="5" cols="40"></textarea>
<p><input id="submit_button" type="submit" name="enter" value="登録"></p>
<p><input id="submit_button" type="submit" name="back" value="戻る"></p>
</form>
</body>
</html>
<?php
$sql = "CREATE TABLE IF NOT EXISTS gdata"
	."("
	."id INT AUTO_INCREMENT PRIMARY KEY,"
	."u_id INT,"
	."gname TEXT,"
	."comment TEXT,"
	."itidaseki TEXT,"
	."nidaseki TEXT,"
	."sandaseki TEXT,"
	."yondaseki TEXT"
	.");";
	$stmt = $pdo->query($sql);

if(!empty($_POST["gname"])&& !empty($_POST["comment"]) && !empty($_POST["itidaseki"])){
	$gname = $_POST["gname"];
	$comment = $_POST["comment"];
	$itidaseki =$_POST["itidaseki"];
	$nidaseki =$_POST["nidaseki"];
	$sandaseki =$_POST["sandaseki"];
	$yondaseki =$_POST["yondaseki"];
	$u_id = $_SESSION["ID"];
$sql = $pdo -> prepare("INSERT INTO gdata (gname, comment,itidaseki,nidaseki,sandaseki,yondaseki,u_id) VALUES (:gname, :comment, :itidaseki, :nidaseki,:sandaseki,:yondaseki,:u_id)");
	$sql -> bindParam(':gname', $gname, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	$sql -> bindParam(':itidaseki',$itidaseki, PDO::PARAM_STR);
	$sql -> bindParam(':nidaseki',$nidaseki, PDO::PARAM_STR);
	$sql -> bindParam(':sandaseki',$sandaseki, PDO::PARAM_STR);
	$sql -> bindParam(':yondaseki',$yondaseki, PDO::PARAM_STR);
	$sql -> bindParam(':u_id',$u_id,PDO::PARAM_INT);

	$sql -> execute();
	
}
else if(!empty($_POST["back"])){
	header("Location: mainpage.php");
}
?>