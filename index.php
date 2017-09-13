<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>Haushalt</title>
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:300,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

    
</head>
<body>
    <?php 
    $host_name = 'db698740020.db.1and1.com';
    $database = 'db698740020';
    $user_name = 'dbo698740020';
    $password = 'Cientosiete107,';

    $connect = mysql_connect($host_name, $user_name, $password, $database);
    if (mysql_errno()) {
        die('<p>Verbindung zum MySQL Server fehlgeschlagen: '.mysql_error().'</p>');
    }
	// $con = mysql_connect("localhost", "root", "Cientosiete107,") or die ("Failed");
	// $db = mysql_select_db('haushalt') or die ("No database");
    $query = mysql_query("SELECT * FROM florian");
    $rows = array();
    while ($row = mysql_fetch_assoc($query)) {
        $rows[] = $row;
    }
    $length = count($rows);
    ?>
    <div class="header">
        <h3>Haushalt</h3>
    </div>
    <div class="menu">
        <form id="user-input">
            <input required id="item" name="item" type="text" placeholder="Position">
            <input required id="amount" name="amount" type="text" placeholder="Betrag">
            <input type="submit" class="button" value=">">
        </form>
        <form class="preset-items">
            <!-- <a href="#" onclick="addTrainMorning" type="submit" class="button">Zug Morgens</a>
            <a href="#" onclick="addTrainLate" type="submit" class="button">Zug Tag</a> -->
        </form>
    </div>
    <div class="table-container">
        <table>
            <tbody id="table">
                <tr>
                    <th>Datum</th>
                    <th>Position</th>
                    <th>Betrag</th>
                </tr>
            </tbody>
        </table>
    </div>
    <div id="test"></div>
    <script type="text/javascript">
        var records = 
            <?php
                echo '[';
                for ($i = 0; $i < $length; $i++) {
                    echo json_encode($rows[$i]) . ', ';
                }
                echo ']';
            ?>;
    </script>
    <script src="js/script.js"></script>
</body>
</html>