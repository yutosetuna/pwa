?php

var_dump($_POST);
require_once('db_connect.php');

$pdo = get_pdo();
if (
    isset($_POST['gakuseki_number'])
    && isset($_POST['name'])
) {
    $statement = $pdo->prepare(
        "INSERT INTO gakusei (gakuseki_number, name) VALUES (:gakuseki_number, :name);"
    );
    $statement->execute([
        ':gakuseki_number' => $_POST['gakuseki_number'],
        ':name' => $_POST['name']
    ]);
}

$data = $pdo->prepare('SELECT * FROM gakusei');
$data->execute();
$gakusei = $data->fetchAll();

?>
<html>
    <body>
        <ul>
        <?php foreach ($gakusei as $row): ?>
            <li>
                <?php echo htmlspecialchars($row['gakuseki_number']); ?>
                <?php echo htmlspecialchars($row['name']); ?>
            </li>
        <?php endforeach; ?>
        </ul>
        <form action="insert.php" method="post">
            <button id="add" type="button">
                項目を追加する
            </button>
            <div id="rows">
                <input type="text" name="gakuseki_number" value="">
                <input type="text" name="name" value="">
            </div>
            <input type="submit" name="submit" value="データ追加">
        </form>
        <script>
            // 項目を動的に追加する
            function addRow() {
                let div = document.querySelector('div#rows');
                let gakuseki_number = document.createElement('input');
                gakuseki_number.type = "text";
                gakuseki_number.name = "gakuseki_number";
                gakuseki_number.value = "";
                let name = document.createElement('input');
                name.type = "text";
                name.name = "gakuseki_number";
                name.value = "";
                div.appendChild(gakuseki_number);
                div.appendChild(name);
            }

            let addButton = document.querySelector('button#add');
            addButton.addEventListener('click', function() {
                addRow();
            });
        </script>
    </body>
</html>
