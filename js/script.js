document.getElementById('user-input').addEventListener('submit', addItem);

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

window.onload = function() {
    for (i = 0; i < records.length; i++) {
        var id = records[i].id;
        var day = records[i].date;
        var dayClass = records[i].dayClass;
        var type = records[i].type;
        var item = records[i].item;
        var amount = records[i].amount;
        
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
                document.getElementById('table').innerHTML +=   '<tr>' +
                                                                    '<td id="latest-date">' + day + '</td>' +
                                                                    '<td>' + type + '</td>' +
                                                                    '<td class="' + dayClass + '">' + amount + '</td>' +
                                                                '</tr>';
            }
            else if ((document.getElementById('latest-date')) && (document.getElementById('latest-date').innerHTML == day)) {
                document.getElementById('latest-sum').outerHTML = '';
                document.getElementById('table').innerHTML +=   '<tr>' +
                                                                    '<td></td>' +
                                                                    '<td>' + type + '</td>' +
                                                                    '<td class="' + dayClass + '">' + amount + '</td>' +
                                                                '</tr>';
            }
            else {
                document.getElementById('table').innerHTML +=   '<tr>' +
                                                                    '<td id="latest-date">' + day + '</td>' +
                                                                    '<td>' + type + '</td>' +
                                                                    '<td class="' + dayClass + '">' + amount + '</td>' +
                                                                '</tr>';
            };

            function calcSumPast(i) {
                var dayClass = records[i].dayClass;
                var allToAdd = document.getElementsByClassName(dayClass);
                var allNums = [];
                for (var i = 0; i < allToAdd.length; i++) {
                    allNums[i] = parseFloat(allToAdd[i].innerHTML);
                }
                var sumDay = allNums.reduce(function(all, item){
                        return all+item;
                    });
                return sumDay.toFixed(2);
            };
            var sumDay = calcSumPast(i);
            document.getElementById('table').innerHTML +=   '<tr class="sum" id="latest-sum">' +
                                                                '<td></td>' +
                                                                '<td>Gesamt ' + day + '</td>' +
                                                                '<td></td>' +
                                                                '<td>' + sumDay + '</td>' +
                                                            '</tr>';
        }
};

function addItem(e) {
    var today = getTodaysDate();
    var item = document.getElementById('item').value;
    var amount = document.getElementById('amount').value;
    var amountFixed = parseFloat(amount).toFixed(2);
    console.log(amountFixed);

    if (document.getElementById('latest-date') && document.getElementById('latest-date').innerHTML != today) {
        var lastDate = document.getElementById('latest-date').innerHTML;
        var cells = document.getElementById('latest-sum').getElementsByTagName('td');
        var lastSum = cells[3].innerHTML;
        var todayClass = getTodayClass();
        
        // push to database
        
        
        document.getElementById('latest-date').outerHTML = '<td>' + lastDate + '</td>';
        document.getElementById('latest-sum').outerHTML =   '<tr class="sum">' +
                                                                '<td></td>' +
                                                                '<td>Gesamt ' + lastDate + '</td>' +
                                                                '<td></td>' +
                                                                '<td>' + lastSum + '</td>' +
                                                            '</tr>'
        document.getElementById('table').innerHTML +=   '<tr>' +
                                                            '<td id="latest-date">' + today + '</td>' +
                                                            '<td>' + item + '</td>' +
                                                            '<td class="' + todayClass + '">' + amountFixed + '</td>' +
                                                        '</tr>';
        } 
    else if ((document.getElementById('latest-date')) && (document.getElementById('latest-date').innerHTML == today)) {
        var cells = document.getElementById('latest-sum').getElementsByTagName('td');
        var lastSum = cells[3].innerHTML;
        var todayClass = getTodayClass();
        
        // push to database
        
        document.getElementById('latest-sum').outerHTML = '';
        document.getElementById('table').innerHTML +=   '<tr>' +
                                                            '<td></td>' +
                                                            '<td>' + item + '</td>' +
                                                            '<td class="' + todayClass + '">' + amountFixed + '</td>' +
                                                        '</tr>';
        }
    else {
        var today = getTodaysDate();
        var todayClass = getTodayClass();
        
        // push to database
        
        document.getElementById('table').innerHTML +=   '<tr>' +
                                                            '<td id="latest-date">' + today + '</td>' +
                                                            '<td>' + item + '</td>' +
                                                            '<td class="' + todayClass + '">' + amountFixed + '</td>' +
                                                        '</tr>';
    };
    var sumDay = calcSum();
    document.getElementById('table').innerHTML +=   '<tr class="sum" id="latest-sum">' +
                                                        '<td></td>' +
                                                        '<td>Gesamt ' + today + '</td>' +
                                                        '<td></td>' +
                                                        '<td>' + sumDay + '</td>' +
                                                    '</tr>';

    document.getElementById('user-input').reset();
    document.getElementById('item').focus();
    e.preventDefault();
}