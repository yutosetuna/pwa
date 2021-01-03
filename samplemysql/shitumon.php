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

$data = $pdo->prepare('SELECT * FROM アンケート一覧');
$data->execute();
$gakusei = $data->fetchAll();

$pdo = get_pdo();
if (
    isset($_POST["質問文"])

) {
    $statement = $pdo->prepare(
        "INSERT INTO 質問一覧 (質問文) VALUES (:question1), (:question2), (:question3), (:question4);"
    );
    $statement->execute([
        ':question1' => $_POST["質問文"],
        ':question2' => $_POST['質問2'],
        ':question3' => $_POST['質問3'],
        ':question4' => $_POST['質問4'],
    ]);
}

$data = $pdo->prepare('SELECT * FROM 質問一覧');
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
