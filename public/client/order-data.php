<?php
function generateUUID() {
    return sprintf(
        '%04x-%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        
        
    );
}
$order=generateUUID();
echo $order;
?>