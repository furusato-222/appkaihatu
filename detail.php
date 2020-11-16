<?php
//フレンドの詳しい状態
session_start();

header('charset=utf8');
//sessionからユーザーIDとフレンドの名前を変数に入れる
$user_id = $_SESSION['user_id'];
$friendname =  $_SESSION['friend_name'];

//release.phpで決定ボタンを押したとき
if (isset($_POST['sub'])) {
  //valueの値を変数に入れる
  $friendid = htmlspecialchars($_POST['sub'], ENT_QUOTES, 'UTF-8');

  if (!$conn = mysqli_connect("localhost", "root", "ecc", "test")) {
    //データベースに接続できない時のメッセージ
    exit("データベースに接続できません");
  }

  //クエリの文字コードを設定
  mysqli_set_charset($conn, 'utf8');

  //SELECT文の追加　calendarテーブルから目標の名前と時間を取ってくる 
  $sql = "SELECT target_name,target_time FROM calendar WHERE user_id = $friendid ";

  //　queryを使用する -----SQLを実行----
  $result = mysqli_query($conn, $sql);

  //結果行を全件取得する
  $resultset = mysqli_fetch_all($result);

  //森　修正　メモリの解放(queryを使用したので、その結果の変数を開放する)
  mysqli_free_result($result);

  //SELECT文の追加 word_infoを取ってくる
  $sql2 = "SELECT * FROM word_info WHERE user_id = $friendid ";

  //　queryを使用する -----SQLを実行----
  $result2 = mysqli_query($conn, $sql2);

  //結果行を全件取得する
  $resultset2 = mysqli_fetch_all($result2);

  //森　修正　メモリの解放(queryを使用したので、その結果の変数を開放する)
  mysqli_free_result($result2);


  //データベース接続を閉じる
  mysqli_close($conn);
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>フレンド</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
  <br>
  <h2><?php echo $friendname ?></h2>
  <?php
  if (isset($message)) {
    print "<font color=''>" . $message . "</font>";
  }
  ?>

  <table border="">
    <thead>
      <tr>
        <th>目標</th>
        <th>目標に向けての時間</th>
      </tr>
    </thead>

    <tbody>
      <?php            //データベース検索の結果セットが存在すればここに表示
      if (isset($resultset)) {
        foreach ($resultset as $value) {
          echo "<tr><td>{$value[0]}</td>";
          echo "<td>{$value[1]}</td></tr>";
        }
      }
      ?>
    </tbody>

  </table>
  <br>

  <table border="">
    <thead>
      <tr>
        <th>間違えた単語数</th>
        <th>間違えた回数</th>
        <th>克服した数</th>
      </tr>
    </thead>

    <tbody>
      <?php            //データベース検索の結果セットが存在すればここに表示
      if (isset($resultset2)) {
        foreach ($resultset2 as $value2) {
          echo "<td>{$value2[1]}</td>";
          echo "<td>{$value2[2]}</td>";
          echo "<td>{$value2[3]}</td></tr>";
        }
      }
      ?>
    </tbody>

  </table>
  <br>

  <button type="button"><a href="release.php">戻る</a></button>

</body>

</html>