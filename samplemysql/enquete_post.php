<?php

require_once('db_connect.php');
$pdo = get_pdo();

$username = $_POST["username"];
unset($_POST["username"]);

$statement = $pdo->prepare(
    "INSERT INTO answer (解答内容, 質問ID, 解答者名)
    VALUES
    (:answer, :question_id, :username)"
    );

foreach ($_POST as $key => $answer) {
    $id_temp = explode('-', $key);
    $question_id = $id_temp[1];

    $statement->execute([
        ':answer' => $answer,
        ':question_id' => $question_id,
        ':username' => $username,
    ]);

    $questions[] = $question_id;
}

$statement = $pdo->prepare(
    "SELECT *
    FROM situmonnichirann
    INNER JOIN answer
    ON situmonnichirann.ID = answer.質問ID
    AND answer.質問ID IN (
    " . substr(str_repeat(',?', count($questions)), 1)
    . ")"
    . "AND answer.解答者名 = ?"
    );

$questions[] = $username;
$statement->execute($questions);
$qa_lists = $statement->fetchAll();
?>

<html>
    <body>
        <h1>解答ありがとうございます</h1>
        <p>以下の内容で解答を受け付けました</p>
        <ul>
            <?php foreach ($qa_lists as $row): ?>
                <li>
                    質問ID: <?php echo htmlspecialchars($row['質問ID']); ?>
                    <?php echo nl2br(htmlspecialchars($row['質問文'])); ?>
                    <p>
                        <?php echo htmlspecialchars($row['解答内容']); ?>
                    </p>
                </li>
            <?php endforeach; ?>
        </ul>
        <a href="./enquete_list.php">アンケート一覧へ戻る</a>
    </body>
</html>
