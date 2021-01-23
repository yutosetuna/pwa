<?php
require_once('db_connect.php');
$pdo = get_pdo();
$enquete_id = (int)$_GET['id'];

$statement = $pdo->prepare(
    'SELECT *
    FROM アンケート一覧
    INNER JOIN situmonnichirann
    ON アンケート一覧.ID = situmonnichirann.アンケートID
    WHERE アンケート一覧.ID = :enquete_id
    ');


$statement->execute([':enquete_id' => $enquete_id]);
$enquete_data = $statement->fetchAll();
?>
<html>
<body>
<form action="enquete_post.php" method="post">
    <p>
        <label for="username">回答者の名前</label>
        <input type="text" name="username">
    </p>
    <ul>
        <?php foreach ($enquete_data as $row): ?>
            <li>
                質問ID: <?php echo htmlspecialchars($row['ID']); ?>
                <?php echo nl2br(htmlspecialchars($row['質問文'])); ?>
                <p>
                    <input type="text" name="answer-<?php echo htmlspecialchars($row['ID']); ?>" size=40 >
                </p>
        <?php endforeach; ?>
        <p>
         <input type="submit" value="送信">
        </P>
            </li>
       
    </ul>
        </form>
</body>
</html>
