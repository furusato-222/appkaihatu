<?php
//フレンド追加
session_start();

header('charset=utf8');
$user_id = $_SESSION['user_id'];

//決定ボタンを押したとき
if (isset($_POST['sub'])) {
    $friendid = htmlspecialchars($_POST['friend'], ENT_QUOTES, 'UTF-8');

    if (!$conn = mysqli_connect("localhost", "root", "ecc", "appkaihatu")) {
        //データベースに接続できない時のメッセージ
        exit("データベースに接続できません");
    }

    mysqli_set_charset($conn, 'utf8');

    //INSERT文の作成 firendテーブルに追加する
    $sql = "INSERT INTO friend(user_id,friendid) VALUES(?,?)";

    //SQLステートメントを実行する準備
    $stmt = mysqli_prepare($conn, $sql);

    //SQLステートメントと値をバインドする
    mysqli_stmt_bind_param($stmt, 'ii', $user_id, $friendid);

    //ステートメントを実行
    mysqli_stmt_execute($stmt);

    //ステートメントを閉じる
    mysqli_stmt_close($stmt);


    //----------上記のuser_idとfriendidの位置を逆にしたSQL文を実行する---------------------------
    $sql2 = "INSERT INTO friend(user_id,friendid) VALUES(?,?)";

    //SQLステートメントを実行する準備
    $stmt = mysqli_prepare($conn, $sql2);

    //SQLステートメントと値をバインドする
    mysqli_stmt_bind_param($stmt, 'ii', $friendid, $user_id);

    //ステートメントを実行
    mysqli_stmt_execute($stmt);

    //ステートメントを閉じる
    mysqli_stmt_close($stmt);

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
    <form action="friend.php" method="POST">
        <h1>friend</h1>

        <div>
            <input type="text" name="friend">
        </div>

        <button type="submit" name="sub">登録</button>
        <?php
        if (isset($message)) {
            print "<font color=''>" . $message . "</font>";
        }
        ?>
    </form>

    <button type="button"><a href="menu.html">戻る</a></button>

</body>

</html>