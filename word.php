<?php
//単語追加

//sessionをスタート
session_start();

header('charset=utf8');
//useridを変数に入れる
$user_id = $_SESSION['user_id'];

if (isset($_POST['sub']) && isset($_POST['wordid'])) {
    $wordid = htmlspecialchars($_POST['wordid'], ENT_QUOTES, 'UTF-8');
    $level =  htmlspecialchars($_POST['level'], ENT_QUOTES, 'UTF-8');

    if (!$conn = mysqli_connect("localhost", "root", "ecc", "test")) {
        //データベースに接続できない時のメッセージ
        exit("データベースに接続できません");
    }

    mysqli_set_charset($conn, 'utf8');

    //UPDATE文の作成 最後にやったwordidを取得しておく
    $sql = "UPDATE word SET lastword_id = ? WHERE user_id = ?";

    //SQLステートメントを実行する準備
    $stmt = mysqli_prepare($conn, $sql);

    //SQLステートメントと値をバインドする
    mysqli_stmt_bind_param($stmt, 'ii', $wordid, $user_id);

    //ステートメントを実行
    mysqli_stmt_execute($stmt);

    //ステートメントを閉じる
    mysqli_stmt_close($stmt);

    //languageに値があるとき
    if (isset($_POST['lang'])) {
        $language =  htmlspecialchars($_POST['lang'], ENT_QUOTES, 'UTF-8');

        //UPDATE文の作成 languageを変更
        $sql = "UPDATE word SET language = ? WHERE user_id = ?";

        //SQLステートメントを実行する準備
        $stmt = mysqli_prepare($conn, $sql);

        //SQLステートメントと値をバインドする
        mysqli_stmt_bind_param($stmt, 'ii', $language, $user_id);

        //ステートメントを実行
        mysqli_stmt_execute($stmt);

        //ステートメントを閉じる
        mysqli_stmt_close($stmt);
    }

    //levelに値があるとき
    if (isset($_POST['level'])) {
        $level =  htmlspecialchars($_POST['level'], ENT_QUOTES, 'UTF-8');

        //UPDATE文の作成 難しさを変更
        $sql = "UPDATE word SET level_id = ? WHERE user_id = ?";

        //SQLステートメントを実行する準備
        $stmt = mysqli_prepare($conn, $sql);

        //SQLステートメントと値をバインドする
        mysqli_stmt_bind_param($stmt, 'ii', $level, $user_id);

        //ステートメントを実行
        mysqli_stmt_execute($stmt);

        //ステートメントを閉じる
        mysqli_stmt_close($stmt);
    }

    //データベース接続を閉じる
    mysqli_close($conn);
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>単語帳</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <br>
    <form action="word.php" method="POST">
        <h1>word</h1>

        <div>
            <input type="text" name="wordid" maxlength="8" oninput="value　= value.replace(/[^0-9]+/i,'');">
        </div>

        <div>
            <input type="radio" name="lang" value="1" checked>日本語
            <input type="radio" name="lang" value="2">英語
        </div>

        <div>
            <input type="radio" name="level" value="30" checked>3級
            <input type="radio" name="level" value="25">準2級
            <input type="radio" name="level" value="20">2級
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