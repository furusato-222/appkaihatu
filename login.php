<?php
//ログイン処理

session_start();
//ヘッダの設定、文字コードをutf-8に指定
header('charset=utf-8');

//メッセージに空文字を入れる
$message = " ";

//セッションの初期化
session_unset();

//新規登録に移動
if (isset($_POST['sinki'])) {
  header('Location: useradd.php');
}

if (isset($_POST['login'])) {
  //フォームリクエストの内容を取得
  $username = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
  $password = htmlspecialchars($_POST['pass'], ENT_QUOTES, 'UTF-8');

  //データベースサーバに接続
  if (!$conn = mysqli_connect("localhost", "root", "ecc", "test")) {
    exit("データベースに接続できません。");
  }

  mysqli_set_charset($conn, 'utf8');

  //SELECT文の作成 userテーブルに名前とパスワードが一致する者を取ってくる
  $sql = "SELECT * FROM user
             where user_name = '$username' and password = '$password'";

  //SQLを実行
  $result = mysqli_query($conn, $sql);
  $set = mysqli_fetch_assoc($result);

  //$setに値がないならアカウントとパスワードの照会をしない
  if ($set != null) {

    if ($username == $set['user_name'] && $password == $set['password']) {
      //セッションにidと名前を保存
      $_SESSION['user_id'] = $set['user_id'];
      $_SESSION['user_name'] = $set['user_name'];

      //メニューに飛ばす
      header('Location: menu.html');
    } else {
      $message = "idもしくは、passが一致しません。";
    }
  }

  //アカウントとパスワードが空白かそれ以外か
  if ($password == "" || $username == "") {
    $message = "IDもしくはPASSが空欄です。";
  } else {
    $message = 'idもしくは、passが一致しません';
  }

  mysqli_free_result($result);

  //データベース接続を閉じる
  mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>ログイン</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
  <br>
  <form action="login.php" method="POST">
    <h1>login</h1>
    <div>
      <input type="text" name="name">
    </div>
    <div>
      <input type="password" name="pass">
    </div>

    <button type="submit" name="login">ログイン</button>
    <button type="submit" name="sinki">新規登録</button>
    <?php
    if (isset($message)) {
      print "<font color=''>" . $message . "</font>";
    }
    ?>
  </form>
</body>

</html>