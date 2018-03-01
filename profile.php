<?php 
    require 'db.php';
    session_start();
    if ( $_SESSION['logged_in'] != 1 ) {
        $_SESSION['message'] = "Bitte logge Dich ein";
        header("location: error.php");    
    }
    else {
        $id = $_SESSION['id'];
        $first_name = $_SESSION['first_name'];
        $last_name = $_SESSION['last_name'];
        $email = $_SESSION['email'];
        $active = $_SESSION['active'];
    }
        
    $user_table = $id . '_' . $first_name . '_' . $last_name;
    $thisMonth = date("ym");
    $monthInt = date("n");
    $showedMonth = $thisMonth;
    $showedMonthInt = $monthInt;
    if(isset($_POST['item']) && isset($_POST['amount'])){
        $weekday = array();
        $weekday[0] = "So";
        $weekday[1] = "Mo";
        $weekday[2] = "Di";
        $weekday[3] = "Mi";
        $weekday[4] = "Do";
        $weekday[5] = "Fr";
        $weekday[6] = "Sa";
        $date = date("j.n. ") . $weekday[date("w")];
        $dayClass = date("ymd");
        $type = $mysqli->escape_string($_POST['type']);
        $item = $mysqli->escape_string($_POST['item']);
        $amount = $mysqli->escape_string($_POST['amount']);
        $month = $thisMonth;
        $insertrecord = "INSERT INTO " . $user_table . " (date, dayClass, type, item, amount, month) VALUES ('$date', '$dayClass', '$type', '$item', '$amount', '$month')";
        $mysqli->query($insertrecord) or die("Could not insert message"); 
    }
    $monthName = array();
    $monthName[1] = "Januar";
    $monthName[2] = "Februar";
    $monthName[3] = "März";
    $monthName[4] = "April";
    $monthName[5] = "Mai";
    $monthName[6] = "Juni";
    $monthName[7] = "Juli";
    $monthName[8] = "August";
    $monthName[9] = "September";
    $monthName[10] = "Oktober";
    $monthName[11] = "November";
    $monthName[12] = "Dezember";
    if(isset($_POST['goToLastMonth'])){
        if($mysqli->escape_string($_POST['changedFromMonthInt']) == 1){
            $showedMonthInt = 12;
            $year = (($mysqli->escape_string($_POST['changedFromMonth']) - 1) / 100);
            $showedMonth = ($year - 1) . 12;
        } else {
            $showedMonth = ($mysqli->escape_string($_POST['changedFromMonth']) - 1);
            $showedMonthInt = ($mysqli->escape_string($_POST['changedFromMonthInt']) - 1);
        }
    }
    if(isset($_POST['goToNextMonth'])){
        if($mysqli->escape_string($_POST['changedFromMonthInt']) == 12){
            $showedMonthInt = 1;
            $showedMonth = (($mysqli->escape_string($_POST['changedFromMonth']) + 88) / 10) . 1;
            echo $showedMonth;
        } else {
            $showedMonth = ($mysqli->escape_string($_POST['changedFromMonth']) + 1);
            $showedMonthInt = ($mysqli->escape_string($_POST['changedFromMonthInt']) + 1);
        }
    }
    
    if(isset($_POST['budgetInput'])){
        $budgetInput = $mysqli->escape_string($_POST['budgetInput']);
        $saveBudget = "UPDATE `users` SET budget = '$budgetInput' WHERE id = '$id';";
        $budgetResult = $mysqli->query($saveBudget);
    }
    $budgetQuery = "SELECT budget FROM `users` WHERE id = " . $id;
    $budgetResult = $mysqli->query($budgetQuery);
    if ($budgetResult->num_rows > 0 ){
        $rows = array();
        while ($row = $budgetResult->fetch_assoc()) {
            $rows[] = $row;
        }
    } else {
       $budget = 'Set budget';
    }
    $budgetArray = $rows[0];
    $budget = $budgetArray['budget'];
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <title>Haushalt</title>
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:300,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">    
</head>
<body>
    <div class="content">
        <div class="header">
            <a href="logout.php"><button class="logout-button">Logout</button></a>
            <h3>Haushalt</h3>
        </div>
        <div id="menu">
            <form action="profile.php" method="post" name="form" id="user-input">
                <select name="type">
                    <option value="Lebensmittel">Lebensmittel</option>
                    <option value="Hausrat">Hausrat</option>
                    <option value="Frühstück">Frühstück</option>
                    <option value="Mittagessen">Mittagessen</option>
                    <option value="Abendessen">Abendessen</option>
                    <option value="Snack">Snack</option>
                    <option value="Restaurant">Restaurant</option>
                    <option value="Feiern">Feiern</option>
                    <option value="Nahverkehr">Nahverkehr</option>
                    <option value="Fernverkehr">Fernverkehr</option>
                    <option value="Anschaffung">Anschaffung</option>
                    <option value="Kultur">Kultur</option>
                    <option value="Dienstleistung">Dienstleistung</option>
                </select>
                <input id="item" name="item" type="text" placeholder="Position (optional)">
                <input required id="amount" name="amount" type="number" step="0.01" placeholder="€">
                <input type="submit" class="button" value=">">            
            </form>
        </div>
        <div class="time-select">
                <form action="profile.php" method="post" name="month" id="month-select">
                    <button name="goToLastMonth">&larr;</button>
                    <input type="text" readonly id="showed-month" value="<?php echo $monthName[$showedMonthInt]; ?>">
                    <input type="hidden" class="showed-month-int" name="changedFromMonthInt" value="<?php echo $showedMonthInt; ?>">
                    <input type="hidden" class="showed-month-int" name="changedFromMonth" value="<?php echo $showedMonth; ?>">
                    <button name="goToNextMonth">&rarr;</button>
                </form>
                <!--  <div class="filter">
                    <span>Filter</span>
                    <form action="filter.php" method="post" name="filter" id="filter">
                        <select name="filter-select">
                            <option value="Lebensmittel">Lebensmittel</option>
                            <option value="Hausrat">Hausrat</option>
                            <option value="Frühstück">Frühstück</option>
                            <option value="Mittagessen">Mittagessen</option>
                            <option value="Abendessen">Abendessen</option>
                            <option value="Snack">Snack</option>
                            <option value="Restaurant">Restaurant</option>
                            <option value="Feiern">Feiern</option>
                            <option value="Nahverkehr">Nahverkehr</option>
                            <option value="Fernverkehr">Fernverkehr</option>
                            <option value="Anschaffung">Anschaffung</option>
                            <option value="Kultur">Kultur</option>
                        </select>
                        <input type="submit" class="button" value=">">
                    </form>
                </div> --> 
        </div>        
        <div id="table-container">
        </div>
    </div>
    <script type="text/javascript">
        function getRecords(){
            var records = 
                <?php
                    $query = "SELECT * FROM " . $user_table . " WHERE month = " . $showedMonth;
                    $result = $mysqli->query($query);
                    if ($result->num_rows > 0 ){
                        $rows = array();
                        while ($row = $result->fetch_assoc()) {
                            $rows[] = $row;
                        }
                        $length = count($rows);
                        echo '[';
                        for ($i = 0; $i < $length; $i++) {
                            echo json_encode($rows[$i]) . ', ';
                        }
                        echo ']';
                    } else {
                       echo 'false';
                    }
            ?>;
            return records;
        }
        window.addEventListener('load', displayRecords(getRecords(), <?php echo $showedMonth; ?>), false);
        function displayRecords(databaseOutput, month) {
            var records = databaseOutput;
            if (records == false) {
                return;
            }
                else {
                var lastMonth = 0;
                thisMonth = month;
                var allToShow = new Array;

                document.getElementById('table-container').innerHTML = '';
                for (i = (records.length - 1); i >= 0; i--) {
                    var id = records[i].id;
                    var day = records[i].date;
                    var dayClass = records[i].dayClass;
                    var type = records[i].type;
                    var item = records[i].item;
                    if (item) {
                        item = ' (' + item + ')';
                    } else {
                        item = '';
                    }
                    var amount = records[i].amount;
                    var currentMonth = dayClass.substr(0, dayClass.length-2);

                        if (document.getElementById('latest-date') && document.getElementById('latest-date').innerHTML != day && !(document.getElementById('latest-sum')).classList.contains(currentMonth))  {
                            var lastDate = document.getElementById('latest-date').innerHTML;
                            var cells = document.getElementById('latest-sum').getElementsByTagName('td');
                            lastSum = cells[3].innerHTML;
                            document.getElementById('latest-date').outerHTML = '<td>' + lastDate + '</td>';
                            document.getElementById('latest-sum').outerHTML =   '<tr class="' + lastMonth + ' sum">' +
                                                                                    '<td></td>' +
                                                                                    '<td>Gesamt ' + lastDate + '</td>' +
                                                                                    '<td></td>' +
                                                                                    '<td>' + lastSum + '</td>' +
                                                                                '</tr>'
                            document.getElementById('table-body').innerHTML +=  '<tr class="' + currentMonth + '">' +
                                                                                    '<td id="latest-date">' + day + '</td>' +
                                                                                    '<td>' + type + item + '</td>' +
                                                                                    '<td class="day-sum ' + dayClass +  '">' + amount + '</td>' +
                                                                                '</tr>';
                        }
                        else if (document.getElementById('latest-date') && document.getElementById('latest-date').innerHTML != day && (document.getElementById('latest-sum')).classList.contains(currentMonth)) {
                            var lastDate = document.getElementById('latest-date').innerHTML;
                            var cells = document.getElementById('latest-sum').getElementsByTagName('td');
                            lastSum = cells[3].innerHTML;
                            document.getElementById('latest-date').outerHTML = '<td>' + lastDate + '</td>';
                            document.getElementById('latest-sum').outerHTML =   '<tr class="sum ' + currentMonth + '">' +
                                                                                    '<td></td>' +
                                                                                    '<td>Gesamt ' + lastDate + '</td>' +
                                                                                    '<td></td>' +
                                                                                    '<td>' + lastSum + '</td>' +
                                                                                '</tr>'
                            document.getElementById('table-body').innerHTML +=  '<tr class="' + currentMonth + '">' +
                                                                                    '<td id="latest-date">' + day + '</td>' +
                                                                                    '<td>' + type + item + '</td>' +
                                                                                    '<td class="day-sum ' + dayClass +  '">' + amount + '</td>' +
                                                                                '</tr>';
                        }
                        else if ((document.getElementById('latest-date')) && (document.getElementById('latest-date').innerHTML == day)) {
                            document.getElementById('latest-sum').outerHTML = '';
                            document.getElementById('table-body').innerHTML +=  '<tr class="' + currentMonth + '">' +
                                                                                    '<td></td>' +
                                                                                    '<td>' + type + item + '</td>' +
                                                                                    '<td class="day-sum ' + dayClass +  '">' + amount + '</td>' +
                                                                                '</tr>';
                        }
                        else {
                            document.getElementById('menu').innerHTML += '<div class="sum-box">' +
                                                                            '<table>' + 
                                                                                '<tr>' +
                                                                                    '<td>Budget:</td>' + 
                                                                                    '<td><form action="profile.php" method="post" name="budget-form" id="budget-form"><input id="budget" type="number" name="budgetInput" class="sum-box-amount" value=' + <?php echo $budget; ?> + '></input></form><td>' + 
                                                                                '</tr>' +
                                                                                '<tr>' +
                                                                                    '<td>Summe:</td>' +
                                                                                    '<td id="sum-month" class="sum-box-amount"></td>' + 
                                                                                '</tr>' +
                                                                                '<tr>' + 
                                                                                    '<td>Rest Budget:</td>' +
                                                                                    '<td id="rest-budget" class="sum-box-amount"></td>' +
                                                                                '</tr>' +
                                                                            '</table>' +
                                                                        '</div>'

                            document.getElementById('table-container').innerHTML =  '<table class="table">' +
                                                                                        '<tbody id="table-body">' +
                                                                                        '<tr id="row-headline">' +
                                                                                            '<th>Datum</th>' +
                                                                                            '<th>Position</th>' +
                                                                                            '<th>Betrag</th>' +
                                                                                        '</tr>' +
                                                                                        '<tr class="' + currentMonth + '">' +
                                                                                            '<td id="latest-date">' + day + '</td>' +
                                                                                            '<td>' + type + item + '</td>' +
                                                                                            '<td class="day-sum ' + dayClass + '">' + amount + '</td>' +
                                                                                        '</tr>' +
                                                                                        '</tbody>' +
                                                                                    '</table>';
                        };

                        function calcSum(i) {
                            var dayClass = records[i].dayClass;
                            var allToAdd = document.getElementsByClassName(dayClass);
                            var allNums = [];
                            for (var i = 0; i < allToAdd.length; i++) {
                                allNums[i] = parseFloat(allToAdd[i].innerHTML);
                            }
                            var sumDay = allNums.reduce(function(all, item){
                                    return all+item;
                                });
                            return sumDay;
                        };
                        var sumDay = calcSum(i).toFixed(2);
                        document.getElementById('table-body').innerHTML +=      '<tr class="' + currentMonth + ' sum" id="latest-sum">' +
                                                                                    '<td></td>' +
                                                                                    '<td>Gesamt ' + day + '</td>' +
                                                                                    '<td></td>' +
                                                                                    '<td>' + sumDay + '</td>' +
                                                                                '</tr>';

                    lastMonth = currentMonth;
                    }
                    allToShow = document.getElementsByClassName(thisMonth);
                    for (i = 0; i < allToShow.length; i++){
                        allToShow[i].classList += ' active';
                    }
                    var sumMonth = calcSumMonth();
                    document.getElementById('sum-month').innerHTML += sumMonth;
                    var restBudget = calcRestBudget();
                    var budget = document.getElementById('budget').value;
                    var restBudget = budget - sumMonth;
                    restBudget = restBudget.toFixed(2);
                    document.getElementById('rest-budget').innerHTML = restBudget;
                }
        };
        function getTodayClass(){
            var d = new Date();
            var year = (d.getYear() - 100).toString();
            var month = (d.getMonth() + 1).toString();
            if (month.length == 1) {
                month = '0' + month;
            };
            var day = d.getDate().toString();
            if (day.length == 1) {
                day = '0' + day;
            };
            return (year + month + day);
        }

        function getThisMonth(){
            var d = new Date();
            var year = (d.getYear() - 100).toString();
            var month = (d.getMonth() + 1).toString();
            if (month.length == 1) {
                month = '0' + month;
            };
            return (year + month);
        }

        function calcSum() {
            var todayClass = getTodayClass();
            var allToAdd = document.getElementsByClassName(todayClass);
            var allNums = [];
            for (var i = 0; i < allToAdd.length; i++) {
                allNums[i] = parseFloat(allToAdd[i].innerHTML);
            }
            var sumDay = allNums.reduce(function(all, item){
                    return all+item;
                });
            return sumDay.toFixed(2);
        }

        function calcSumMonth() {
            var allActive = document.getElementsByClassName('sum active');
            var allSums = [];
            for (i = 0; i < allActive.length; i++){
                allSums[i] = parseFloat(allActive[i].childNodes[3].innerHTML);
            }
            var sumThisMonth = allSums.reduce(function(all, item){
                return all+item;
            });
            return sumThisMonth.toFixed(2);
        }

        function calcRestBudget() {
            var budget = document.getElementById('budget').value;
            var sumMonth = document.getElementById('sum-month').innerHTML;
            var restBudget = budget - sumMonth;
            restBudget = restBudget.toFixed(2);
            document.getElementById('rest-budget').innerHTML = restBudget;
        }
    </script>
</body>
</html>