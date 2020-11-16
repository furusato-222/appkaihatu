<?php
//カレンダー処理

session_start();

header('charset=utf8');
//ユーザーidを取得
$user_id = $_SESSION['user_id'];

//決定を押したとき
if (isset($_POST['sub'])) {
    //フォームリクエストの内容を取得
    $target =  htmlspecialchars($_POST['target'], ENT_QUOTES, 'UTF-8');
    $date =  htmlspecialchars($_POST['date'], ENT_QUOTES, 'UTF-8');
    $time = htmlspecialchars($_POST['time'], ENT_QUOTES, 'UTF-8');
    $study = htmlspecialchars($_POST['study'], ENT_QUOTES, 'UTF-8');

    //データベースサーバに接続
    if (!$conn = mysqli_connect('localhost', 'root', 'ecc', 'appkaihatu')) {
        //データベースに接続できない時のメッセージ
        exit("データベースに接続できません");
    }

    mysqli_set_charset($conn, 'utf8');

    //INSERT文の作成　calendarテーブルに追加
    $sql = "INSERT INTO calendar(target_name,target_date,target_time,study_how,user_id) VALUES(?,?,?,?,?)";

    //実行する準備
    $stmt = mysqli_prepare($conn, $sql);

    //SQLステートメントと値をバインドする
    mysqli_stmt_bind_param($stmt, 'ssiii', $target, $date, $time, $study, $user_id);

    //ステートメントを実行
    mysqli_stmt_execute($stmt);

    //データベースの変更確認 登録できたかどうかのメッセージを変数に格納
    if (mysqli_stmt_affected_rows($stmt)) {
        $message = "登録完了";
    } else {
        $message = "登録できません";
    }

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

    <form action="calendar.php" method="POST">

        <div>
            目標
            <input type="text" name="target">
        </div>
        <div>
            日付
            <input type="date" name="date">
        </div>
        <div>
            時間
            <input type="text" name="time">
        </div>

        <div>
            勉強の仕方
            <input type="radio" name="study" value="1">時間
            <input type="radio" name="study" value="2">ページ数
            <input type="radio" name="study" value="3">問題数
        </div>

        <button type="submit" name="sub">決定</button>
        <?php
        if (isset($message)) {
            print "<font color=''>" . $message . "</font><br>";
        }
        if (isset($message2)) {
            print "<font color=''>" . $message2 . "</font>";
        }
        ?>
    </form>

    <br>
    <button type="button"><a href="menu.html">戻る</a></button>

</body>

</html>