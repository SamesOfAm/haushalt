window.addEventListener('load', displayRecords(getRecords()), false);

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

function getTodaysDate(){
    var d = new Date();
    var weekday = new Array(7);
    weekday[0] = "So";
    weekday[1] = "Mo";
    weekday[2] = "Di";
    weekday[3] = "Mi";
    weekday[4] = "Do";
    weekday[5] = "Fr";
    weekday[6] = "Sa";
    return (d.getDate() + '.' + (d.getMonth() + 1) + '. ' + weekday[d.getDay()]);
}

function displayRecords(databaseOutput) {
    var records = databaseOutput;
    document.getElementById('table-container').innerHTML = '';
    for (i = (records.length - 1); i > 0; i--) {
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
        var d = new Date();
        var months = new Array();
        months[0] = "Januar";
        months[1] = "Februar";
        months[2] = "März";
        months[3] = "April";
        months[4] = "Mai";
        months[5] = "Juni";
        months[6] = "Juli";
        months[7] = "August";
        months[8] = "September";
        months[9] = "Oktober";
        months[10] = "November";
        months[11] = "Dezember";
        var month = months[d.getMonth()];
        
            if (document.getElementById('latest-date') && document.getElementById('latest-date').innerHTML != day) {
                var lastDate = document.getElementById('latest-date').innerHTML;
                var cells = document.getElementById('latest-sum').getElementsByTagName('td');
                lastSum = cells[3].innerHTML;
                document.getElementById('latest-date').outerHTML = '<td>' + lastDate + '</td>';
                document.getElementById('latest-sum').outerHTML =   '<tr class="sum">' +
                                                                        '<td></td>' +
                                                                        '<td>Gesamt ' + lastDate + '</td>' +
                                                                        '<td></td>' +
                                                                        '<td>' + lastSum + '</td>' +
                                                                    '</tr>'
                document.getElementById('table-body').innerHTML +=   '<tr>' +
                                                                    '<td id="latest-date">' + day + '</td>' +
                                                                    '<td>' + type + item + '</td>' +
                                                                    '<td class="' + dayClass + '">' + amount + '</td>' +
                                                                '</tr>';
            }
            else if ((document.getElementById('latest-date')) && (document.getElementById('latest-date').innerHTML == day)) {
                document.getElementById('latest-sum').outerHTML = '';
                document.getElementById('table-body').innerHTML +=   '<tr>' +
                                                                    '<td></td>' +
                                                                    '<td>' + type + item + '</td>' +
                                                                    '<td class="' + dayClass + '">' + amount + '</td>' +
                                                                '</tr>';
            }
            else {
                document.getElementById('table-container').innerHTML =  '<div class="sum-box">Summe ' + month + 
                                                                        ':&nbsp;<span id="sum-month"></span></div>' +
                                                                        '<table class="table">' +
                                                                            '<tbody id="table-body">' +
                                                                            '<tr>' +
                                                                                '<th>Datum</th>' +
                                                                                '<th>Position</th>' +
                                                                                '<th>Betrag</th>' +
                                                                            '</tr>' +
                                                                            '<tr>' +
                                                                                '<td id="latest-date">' + day + '</td>' +
                                                                                '<td>' + type + item + '</td>' +
                                                                                '<td class="' + dayClass + '">' + amount + '</td>' +
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
            document.getElementById('table-body').innerHTML +=   '<tr class="sum" id="latest-sum">' +
                                                                '<td></td>' +
                                                                '<td>Gesamt ' + day + '</td>' +
                                                                '<td></td>' +
                                                                '<td>' + sumDay + '</td>' +
                                                            '</tr>';
        }
};