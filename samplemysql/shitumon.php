<?php

var_dump($_POST);
require_once('db_connect.php');

$pdo = get_pdo();
if (
    isset($_POST['タイトル'])

) {
    $statement = $pdo->prepare(
        "INSERT INTO アンケート一覧 (タイトル) VALUES (:title);"
    );
    $statement->execute([
        ':title' => $_POST['タイトル'],
    ]);
}

if (
    isset($_POST["質問1"])
) {
  // アンケート一覧に挿入したレコードのIDを取得
  $statement = $pdo->query('SELECT LAST_INSERT_ID() AS ID FROM アンケート一覧 LIMIT 1;');
  $enquete_id = $statement->fetch()['ID'];
  var_dump($enquete_id);

  $statement = $pdo->prepare(
    "INSERT INTO situmonnichirann (質問文, アンケートID)
    VALUES
    (:question1, :enquete1),
    (:question2, :enquete2),
    (:question3, :enquete3),
    (:question4, :enquete4);"
    );
    $statement->execute([
        ':question1' => $_POST["質問1"],
        ':question2' => $_POST['質問2'],
        ':question3' => $_POST['質問3'],
        ':question4' => $_POST['質問4'],
        ':enquete1' => $enquete_id,
        ':enquete2' => $enquete_id,
        ':enquete3' => $enquete_id,
        ':enquete4' => $enquete_id,
    ]);
}

$data = $pdo->prepare(
  'SELECT *
  FROM situmonnichirann
  INNER JOIN アンケート一覧
  ON situmonnichirann.アンケートID = アンケート一覧.ID
'
);
$data->execute();
$gakusei = $data->fetchAll();

?>
<html>
    <body>
        <ul>
        <?php foreach ($gakusei as $row): ?>
            <li>
                <?php echo nl2br(htmlspecialchars($row['タイトル'])); ?>
                <?php echo nl2br(htmlspecialchars($row['質問文'])); ?>
            </li>
        <?php endforeach; ?>
        </ul>
        <form action="shitumon.php" method="POST">
        <p>タイトル
　　　　<input type="search" name="タイトル" value=""><br>
        </p>
          質問1
        <textarea name="質問1"></textarea>
        </p>
        <p>
          質問2
            <input type="search" name="質問2" value=""><br>
        </p>
        <p>
          質問3
            <input type="search" name="質問3" value=""><br>
        </p>
        <p>
          質問4
            <input type="search" name="質問4" value="">
        </p>
            <input type="submit" name="submit" value="追加">
        </form>
    </body>
</html>