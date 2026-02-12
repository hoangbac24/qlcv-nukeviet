<?php

define('NV_SYSTEM', true);

// Adjust path: executing from root context but file is in /Applications/MAMP/htdocs/nukeviet5/
// The file is at /Applications/MAMP/htdocs/nukeviet5/update_schema.php
// The include is at /Applications/MAMP/htdocs/nukeviet5/src/includes/mainfile.php

require_once 'src/includes/mainfile.php';

$module_data = 'qlcv'; 

// Check if columns exist before adding?
// Or just ignore errors.

$columns = ['image_checkin', 'image_checkout', 'file_report'];
$table = $db_config['prefix'] . "_" . $global_config['site_lang'] . "_" . $module_data . "_jobs";

foreach ($columns as $col) {
    $sql = "ALTER TABLE " . $table . " ADD COLUMN " . $col . " varchar(255) DEFAULT ''";
    try {
        $db->query($sql);
        echo "Added column $col.<br>";
    } catch (PDOException $e) {
        echo "Column $col might already exist or error: " . $e->getMessage() . "<br>";
    }
}

echo "Done.";
die();
