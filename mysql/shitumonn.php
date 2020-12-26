<?php

var_dump($_POST);
require_once('db_connect.php');

$pdo = get_pdo();
if (
    isset($_POST['質問1'])

) {
    $statement = $pdo->prepare(
        "INSERT INTO 質問一覧 (質問1,) VALUES (:質問1,);"
    );
    $statement->execute([
        ':質問1' => $_POST['質問1'],
        
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
                <?php echo htmlspecialchars($row['質問1']); ?>
            </li>
        <?php endforeach; ?>
        </ul>
        <form action="sandbox.digiroid.org" method="post">
            <input type="search" name="質問1" value="">
            <input type="submit" name="submit" value="追加">
        </form>
    </body>
</html>