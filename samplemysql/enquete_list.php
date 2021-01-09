<?php

require_once('db_connect.php');
$pdo = get_pdo();
$enquetes = $pdo->query('SELECT * FROM アンケート一覧')
    ->fetchAll();
?>
<html>
    <body>
        <ul>
            <?php foreach ($enquetes as $enquete) : ?>
            <li>
            <a href="./enquete_detail.php?id=<?php echo htmlspecialchars($enquete['ID']); ?>">
                アンケートID: <?php echo htmlspecialchars($enquete['ID']); ?>
                <?php echo htmlspecialchars($enquete['タイトル']); ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </body>
</html>