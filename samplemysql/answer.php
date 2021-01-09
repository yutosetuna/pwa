<?php
require_once('db_connect.php');
$pdo = get_pdo();
$situmonn_id = (int)$_GET['id'];

$statement = $pdo->prepare(
    'SELECT *
    FROM　situmonnichirann
    INNER JOIN answer
    ON situmonnichirann.ID = answer.質問ID
    WHERE situmonnichirann.ID = :situmonnichirann_id
    ');

if (
    isset($_POST["解答1"])
) {
  // アンケート一覧に挿入したレコードのIDを取得
  $statement = $pdo->query('SELECT LAST_INSERT_ID() AS ID FROM situmonnichirann LIMIT 1;');
  $situmonn_id = $statement->fetch()['ID'];
  var_dump($situmonn_id);

  $statement = $pdo->prepare(
    "INSERT INTO answer (解答内容, 質問)
    VALUES
    (:answer1, :situmonn1),
    (:answer2, :situmonn2),
    (:answer3, :situmonn3),
    (:answer4, :situmonn4);"
    );
    $statement->execute([
        ':answer1' => $_POST["解答1"],
        ':answer2' => $_POST['解答2'],
        ':answer3' => $_POST['解答3'],
        ':answer4' => $_POST['解答4'],
        ':situmonn1' => $situmonn_id,
        ':situmonn2' => $situmonn_id,
        ':situmonn3' => $situmonn_id,
        ':situmonn4' => $situmonn_id,
    ]);
}   
$statement->execute([':situmonn_id' => $situmonn_id]);
$answer_data = $statement->fetchAll();

?>
<html>
<body>
<form action="answer.php" method="post">
    <ul>
        <?php foreach ($answer_data as $row): ?>
            <li>
                質問ID: <?php echo htmlspecialchars($row['ID']); ?>
                <?php echo nl2br(htmlspecialchars($row['解答内容'])); ?>
         <p>
         <input type="text" name="answer1" size=40 >
        </P>
        <p>
         <input type="submit" value="送信">
        </P>
            </li>
        <?php endforeach; ?>
    </ul>
        </form>
</body>
</html>