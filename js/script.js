document.getElementById('user-input').addEventListener('submit', addItem);

window.onload = function() { 
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            localStorage.setItem('records', this.responseText);
        } else {
            console.log('No document found');
        };
    };
    xhttp.open("GET", "/doc/records.json", true);
    xhttp.send();
    if (localStorage.getItem('records')) {
        var data = JSON.parse(localStorage.getItem('records'));
        for (i = 0; i < data.records.length; i++) {
            var day = data.records[i].date;
            var dayClass = data.records[i].dayClass;
            var item = data.records[i].item;
            var amount = data.records[i].amount;
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
                                                                    '<td>' + item + '</td>' +
                                                                    '<td class="' + dayClass + '">' + amount + '</td>' +
                                                                '</tr>';
            }
            else if ((document.getElementById('latest-date')) && (document.getElementById('latest-date').innerHTML == day)) {
                document.getElementById('latest-sum').outerHTML = '';
                document.getElementById('table').innerHTML +=   '<tr>' +
                                                                    '<td></td>' +
                                                                    '<td>' + item + '</td>' +
                                                                    '<td class="' + dayClass + '">' + amount + '</td>' +
                                                                '</tr>';
            }
            else {
                document.getElementById('table').innerHTML +=   '<tr>' +
                                                                    '<td id="latest-date">' + day + '</td>' +
                                                                    '<td>' + item + '</td>' +
                                                                    '<td class="' + dayClass + '">' + amount + '</td>' +
                                                                '</tr>';
            };

            function calcSumPast(i) {
                var dayClass = data.records[i].dayClass;
                var allToAdd = document.getElementsByClassName(dayClass);
                var allNums = [];
                for (var i = 0; i < allToAdd.length; i++) {
                    allNums[i] = parseInt(allToAdd[i].innerHTML);
                }
                var sumDay = allNums.reduce(function(all, item){
                        return all+item;
                    });
                return sumDay;
            };
            var sumDay = calcSumPast(i);
            document.getElementById('table').innerHTML +=   '<tr class="sum" id="latest-sum">' +
                                                                '<td></td>' +
                                                                '<td>Gesamt ' + day + '</td>' +
                                                                '<td></td>' +
                                                                '<td>' + sumDay + '</td>' +
                                                            '</tr>';
        };
    } else {
        console.log('No document found 2');
    };          
};

function getTodayClass(){
    var d = new Date();
    return ((d.getYear() - 100) + '-' + (d.getMonth() + 1) + '-' + d.getDate());
}

function calcSum() {
    var todayClass = getTodayClass();
    var allToAdd = document.getElementsByClassName(todayClass);
    var allNums = [];
    for (var i = 0; i < allToAdd.length; i++) {
        allNums[i] = parseInt(allToAdd[i].innerHTML);
    }
    var sumDay = allNums.reduce(function(all, item){
            return all+item;
        });
    return sumDay;
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

function addItem(e) {
    var today = getTodaysDate();
    var item = document.getElementById('item').value;
    var amount = document.getElementById('amount').value;

    if (document.getElementById('latest-date') && document.getElementById('latest-date').innerHTML != today) {
        var lastDate = document.getElementById('latest-date').innerHTML;
        var cells = document.getElementById('latest-sum').getElementsByTagName('td');
        var lastSum = cells[3].innerHTML;
        var todayClass = getTodayClass();
        
        
        // push to object
        var data = JSON.parse(localStorage.getItem('records'));
        var formData = new FormData();
        var startPoint = data.records.length;
        data.records[startPoint] = new Object;
        data.records[startPoint].date = today;    
        data.records[startPoint].dayClass = todayClass;
        data.records[startPoint].item = item;
        data.records[startPoint].amount = amount;
        localStorage.setItem('records', JSON.stringify(data));
        
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
                                                            '<td class="' + todayClass + '">' + amount + '</td>' +
                                                        '</tr>';
        } 
    else if ((document.getElementById('latest-date')) && (document.getElementById('latest-date').innerHTML == today)) {
        var cells = document.getElementById('latest-sum').getElementsByTagName('td');
        var lastSum = cells[3].innerHTML;
        var todayClass = getTodayClass();
        
        // push to object
        var data = JSON.parse(localStorage.getItem('records'));
        var startPoint = data.records.length;
        data.records[startPoint] = new Object;
        data.records[startPoint].date = today;      
        data.records[startPoint].dayClass = todayClass;
        data.records[startPoint].item = item;
        data.records[startPoint].amount = amount;
        localStorage.setItem('records', JSON.stringify(data));
        
        document.getElementById('latest-sum').outerHTML = '';
        document.getElementById('table').innerHTML +=   '<tr>' +
                                                            '<td></td>' +
                                                            '<td>' + item + '</td>' +
                                                            '<td class="' + todayClass + '">' + amount + '</td>' +
                                                        '</tr>';
        }
    else {
        var today = getTodaysDate();
        var todayClass = getTodayClass();
                
        // create and push to object
        var data = new Object;
        data.records = new Array;
        data.records[0] = new Object;
        data.records[0].date = today;
        data.records[0].dayClass = todayClass;
        data.records[0].item = item;
        data.records[0].amount = amount;
        localStorage.setItem('records', JSON.stringify(data));
        
        document.getElementById('table').innerHTML +=   '<tr>' +
                                                            '<td id="latest-date">' + today + '</td>' +
                                                            '<td>' + item + '</td>' +
                                                            '<td class="' + todayClass + '">' + amount + '</td>' +
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