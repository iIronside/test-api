<?php
require '../../../bootstrap.php';

$statement = <<<EOS

    CREATE TABLE IF NOT EXISTS users (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        photo VARCHAR(500) DEFAULT NULL,
        user_key VARCHAR(500) NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=INNODB;


    INSERT INTO users
        (id, name, email, photo, user_key)
    VALUES
        (1, 'Krasimir', 'Hristozov@gmail.com', null, 'jbbvhfbvf5455'),
        (2, 'Maria', 'Hristozova@gmail.com', null, 'jbvhfbvfb4'),
        (3, 'Masha', 'Hristozova@gmail.com', null, 's4fd5fgf44'),
        (4, 'Jane', 'Smith@gmail.com', null, 'ff44fgf444'),
        (5, 'John', 'Smith@gmail.com', null, 'gfv444fg'),
        (6, 'Richard', 'Smith@gmail.com', null, 'ff4445645'),
        (7, 'Donna', 'Smith@gmail.com', null, 'f5g4f442'),
        (8, 'Josh', 'Harrelson@gmail.com', null, 'fg978355'),
        (9, 'Anna', 'Harrelson@gmail.com', null, 'mjfnbcv4c24421');
EOS;

try {
    $createTable = $dbConnection->exec($statement);
    echo "Success!\n";
} catch (PDOException $e) {
    exit($e->getMessage());
}