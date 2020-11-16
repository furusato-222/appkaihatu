<?php
//新規登録の処理

if (isset($_POST['sub'])) {
    //フォームリクエストの内容を取得
    $username = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $password =  htmlspecialchars($_POST['pass'], ENT_QUOTES, 'UTF-8');

    //mysqlのtestに接続
    if (!$conn = mysqli_connect("localhost", "root", "ecc", "appkaihatu")) {
        //データベースに接続できない時のメッセージ
        exit("データベースに接続できません");
    }

    mysqli_set_charset($conn, 'utf8');

    //INSERT文の作成 userテーブルに名前とパスワードを追加
    $sql = "INSERT INTO user(user_name,password) VALUES(?,?)";

    //SQLを実行する準備
    $stmt = mysqli_prepare($conn, $sql);

    //SQLステートメントと値をバインドする
    mysqli_stmt_bind_param($stmt, 'ss', $username, $password);

    //ステートメントを実行
    mysqli_stmt_execute($stmt);

    //ステートメントを閉じる
    mysqli_stmt_close($stmt);

    //INSERT文の作成 単語の他人に見せるテーブルを作成する(user_idだけ入れて他はNULLの状態)
    $sql2 = "INSERT INTO word_info(user_id) SELECT user_id FROM user 
            WHERE user.user_name IN (?) AND user.password IN (?)";

    //SQLステートメントを実行する準備
    $stmt = mysqli_prepare($conn, $sql2);

    //SQLステートメントと値をバインドする
    mysqli_stmt_bind_param($stmt, 'ss', $username, $password);

    //ステートメントを実行
    mysqli_stmt_execute($stmt);

    //ステートメントを閉じる
    mysqli_stmt_close($stmt);

    //INSERT文の作成 wordテーブルを作成(user_idだけ入れて他はNULLの状態)
    $sql3 = "INSERT INTO word(user_id) SELECT user_id FROM user 
    WHERE user.user_name IN (?) AND user.password IN (?)";

    //SQLステートメントを実行する準備
    $stmt = mysqli_prepare($conn, $sql3);

    //SQLステートメントと値をバインドする
    mysqli_stmt_bind_param($stmt, 'ss', $username, $password);

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test</title>
</head>

<body>

    <form action="useradd.php" method="POST">

        <div>
            名前:
            <input type="text" name="name">
        </div>
        <div>
            パスワード:
            <input type="password" name="pass">
        </div>

        <button type="submit" name="sub">決定</button>
    </form>

    <button type="button"><a href="login.php">戻る</a></button>

</body>

</html>