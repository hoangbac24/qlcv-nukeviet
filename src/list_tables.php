<?php
define('NV_SYSTEM', true);
require 'includes/mainfile.php';

$sql = "SHOW TABLES";
$result = $db->query($sql);
while($row = $result->fetch(PDO::FETCH_NUM)) {
    echo $row[0] . "\n";
}
