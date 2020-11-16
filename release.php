<?php
//フレンド一覧
session_start();

header('charset=utf8');
$user_id = $_SESSION['user_id'];

if (!$conn = mysqli_connect("localhost", "root", "ecc", "appkaihatu")) {
    //データベースに接続できない時のメッセージ
    exit("データベースに接続できません");
}

//クエリの文字コードを設定
mysqli_set_charset($conn, 'utf8');

//SELECT文 フレンドの人を一覧表示する
$sql0 = "SELECT friendid FROM friend
        WHERE user_id = $user_id ";

//　queryを使用する -----SQLを実行----
$result0 = mysqli_query($conn, $sql0);

//結果行を全件取得する
$resultset0 = mysqli_fetch_all($result0);

//森　修正　メモリの解放(queryを使用したので、その結果の変数を開放する)
mysqli_free_result($result0);

//フレンドがいるときに表示
if (isset($resultset0)) {
    foreach ($resultset0 as $value) {

        //SELECT文 フレンドの名前を取る
        $sql1 = "SELECT user_name FROM user WHERE user_id = $value[0]";

        $result1 = mysqli_query($conn, $sql1);

        //結果行を全件取得する
        $resultset1 = mysqli_fetch_assoc($result1);

        var_dump($resultset1);

        //森　修正　メモリの解放(queryを使用したので、その結果の変数を開放する)
        mysqli_free_result($result1);
    }

    //セッションに名前を入れておく
    $_SESSION['friend_name'] = $resultset1['user_name'];
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
    <form action="detail.php" method="POST">
        <h1>フレンド一覧</h1>

        <?php
        if (isset($resultset0) && isset($resultset1)) {
            foreach ($resultset0 as $value) {
                foreach ($resultset1 as $test) {
                    echo "フレンド名:<button type='submit' name='sub' value='{$value[0]}'>{$test}</button>";
                }
            }
        }
        ?>

    </form>
    <?php
    if (isset($message)) {
        print "<font color=''>" . $message . "</font>";
    }
    ?>


    <button type="button"><a href="menu.html">戻る</a></button>

</body>

</html>