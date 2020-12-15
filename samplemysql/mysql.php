
<?php

try {
    // データベースの接続先,ID,パスワード,文字コードなどを設定する
    // localhost=自分自身(このPHPプログラムが動作しているサーバ自身)
    // つまり、
    // 「MySQLデータベースに接続してください。
    // 　そのデータベースはlocalhost(サーバ自身)で動いています。
    // 　開くデータベースの名前はphychology_test、
    // 　データの文字コードはutf8mb4、
    // 　接続に使うID/パスワードは17e1337, bV2oL0です」
    // ということを以下の4行でコンピュータに指示している
    $pdo = new PDO(
        'mysql:dbname=phychology_test;host=localhost;charset=utf8mb4',
        '17e1337',
        'bV2oL0'
    );
    // 接続時の追加設定(仕様書に書くまで気にしなくてもいい)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    // データベースにお願いしたいことをprepareメソッドで指示
    // 今回は
    // 「gakuseiテーブルから全てのデータを取得して」
    // という命令を伝える
    $statement = $pdo->prepare('SELECT * FROM gakusei;');
    // 先に伝えた命令を実行するように指示
    $statement->execute();
    // 命令した結果得られたものを全部取得(fetchAll)して
    // その中身をすべてデバッグ用に表示するように(var_dump)指示
    var_dump($statement->fetchAll());
} catch (PDOException $e) {
    var_dump($e);
}