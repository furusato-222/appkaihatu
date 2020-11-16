<?php
//単語間違えた時の処理

//sessionをスタート
session_start();

header('charset=utf8');
//useridを変数に入れる
$user_id = $_SESSION['user_id'];

//checkboxをチェックして決定ボタンを押した時
if (isset($_POST['sub']) && isset($_POST['ok'])) {
    //フォームリクエストの内容を取得
    $missword = htmlspecialchars($_POST['missword'], ENT_QUOTES, 'UTF-8');

    if (!$conn = mysqli_connect("localhost", "root", "ecc", "appkaihatu")) {
        //データベースに接続できない時のメッセージ
        exit("データベースに接続できません");
    }

    mysqli_set_charset($conn, 'utf8');

    //INSERT文の作成 misswordテーブルにuseridとミス単語のidを追加
    $sql = "INSERT INTO missword(user_id,missword_id) VALUES(?,?)";

    //SQLステートメントを実行する準備
    $stmt = mysqli_prepare($conn, $sql);

    //SQLステートメントと値をバインドする
    mysqli_stmt_bind_param($stmt, 'ii', $user_id, $missword);

    //ステートメントを実行
    mysqli_stmt_execute($stmt);

    //ステートメントを閉じる
    mysqli_stmt_close($stmt);

    //checkboxの内容
    $quiz = htmlspecialchars($_POST['quiz'], ENT_QUOTES, 'UTF-8');
    $word = htmlspecialchars($_POST['word'], ENT_QUOTES, 'UTF-8');
    $over = htmlspecialchars($_POST['over'], ENT_QUOTES, 'UTF-8');

    //UPDATE文の作成 ミス単語の回数などの増加
    $sql = "UPDATE word_info SET missword_total = missword_total + ?, missnum_total = missnum_total + ? , 
                       overcome_total = overcome_total + ? WHERE user_id = ?";

    //SQLステートメントを実行する準備
    $stmt = mysqli_prepare($conn, $sql);

    //SQLステートメントと値をバインドする      
    mysqli_stmt_bind_param($stmt, 'iiii', $quiz, $word, $over, $user_id);

    //ステートメントを実行
    mysqli_stmt_execute($stmt);


    //データベースの変更確認 登録できたかどうかのメッセージを変数に格納
    if (mysqli_stmt_affected_rows($stmt)) {
        $message = "更新完了";
    } else {
        $message = "更新できません";
    }

    //ステートメントを閉じる
    mysqli_stmt_close($stmt);

    //データベース接続を閉じる
    mysqli_close($conn);
} else {
    //エラーメッセージ
    $message = "idかcheckboxを押していません";
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
    <form action="missword.php" method="POST">
        <h1>missword</h1>

        <div>
            <input type="text" name="missword" maxlength="8" oninput="value　= value.replace(/[^0-9]+/i,'');">
        </div>

        <div>
            <input type="checkbox" name="ok">追加するかどうか
        </div>

        <div>
            合否判定
            <input type="radio" name="quiz" value="1">正解
            <input type="radio" name="quiz" value="2">間違い
        </div>

        <div>
            同じ単語か？
            <input type="radio" name="word" value="1">はい
            <input type="radio" name="word" value="2">いいえ
        </div>

        <div>
            克服したのか？
            <input type="radio" name="over" value="1">はい
            <input type="radio" name="over" value="2">いいえ
        </div>

        <button type="submit" name="sub">登録</button>
        <button type="button"><a href="menu.html">戻る</a></button>
    </form>
    <?php
    if (isset($message)) {
        print "<font color=''>" . $message . "</font>";
    }
    ?>
</body>

</html>