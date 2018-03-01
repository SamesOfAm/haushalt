<?php
ob_start();
if(isset($_GET['data'])){
    echo $_GET['data'];
} else {
    echo 'Failed';
}
file_put_contents('output.html', ob_get_contents());
?>