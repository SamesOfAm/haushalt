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

	$con = mysql_connect("localhost", "root", "Cientosiete107,") or die ("Failed");
	$db = mysql_select_db('my_database') or die ("No database");
	
	if($con) {
		echo 'Successfully connected to the database';
	} else {
		die('Error');
	}

	if ($db) {
		echo '  Successfully found the database';
	} else {
		die('Database not found');
	}
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
            <a href="#" onclick="addTrainMorning" type="submit" class="button">Zug Morgens</a>
            <a href="#" onclick="addTrainLate" type="submit" class="button">Zug Tag</a>
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
    <!-- <script src="js/jquery-3.2.1.slim.min.js"></script> -->
    <script src="js/script.js"></script>
</body>
</html>