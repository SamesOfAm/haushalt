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
    var budget = document.getElementById('budget').innerHTML;
    var sumMonth = document.getElementById('sum-month').innerHTML;
    var restBudget = budget - sumMonth;
    restBudget = restBudget.toFixed(2);
    document.getElementById('rest-budget').innerHTML = restBudget;
}

document['getElementsByRegex'] = function(pattern){
   var arrElements = [];  
   var re = new RegExp(pattern); 

   function findRecursively(aNode) { 
      if (!aNode) 
          return;
      if (aNode.id !== undefined && aNode.id.search(re) != -1)
          arrElements.push(aNode); 
      for (var idx in aNode.childNodes)
          findRecursively(aNode.childNodes[idx]);
   };

   findRecursively(document); 
   return arrElements;
};


function displayRecords(databaseOutput, month) {
    var showedMonth = document.getElementById('showed-month').innerHTML;
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
                    document.getElementById('menu').innerHTML += '<div class="sum-box">Budget:' + 
                                                                            '<span id="budget" class="sum-box-amount">900</span><br>' + 
                                                                            'Summe: <span id="sum-month" class="sum-box-amount">' + '</span><br>' + 
                                                                            'Rest Budget: <span id="rest-budget" class="sum-box-amount"></span></div>'
                    
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
            var budget = document.getElementById('budget').innerHTML;
            var restBudget = budget - sumMonth;
            restBudget = restBudget.toFixed(2);
            document.getElementById('rest-budget').innerHTML = restBudget;
        }
};

$.fn.extend({
    editable: function() {
        var that = this,
            $edittextbox = $('<input type="number"></input>').css('min-width', that.width()),
            submitChanges = function() {
                that.html($edittextbox.val());
                that.show();
                that.trigger('editsubmit', [that.html()]);
                $(document).unbind('click', submitChanges);
                $edittextbox.detach();
            },
            tempVal;
        $edittextbox.click(function(event) {
            event.stopPropagation();
        });

        that.dblclick(function(e) {
            tempVal = that.html();
            $edittextbox.val(tempVal).insertBefore(that).bind('keypress', function(e) {
                if ($(this).val() !== '') {
                    var code = (e.keyCode ? e.keyCode : e.which);
                    if (code == 13) {
                        submitChanges();
                    }
                }
            });
            that.hide();
            $(document).click(submitChanges);
        });
        return that;
    }
});

$('#budget').editable().on('editsubmit', function (event, val) {
    var budget = document.getElementById('budget').innerHTML;
    var sumMonth = document.getElementById('sum-month').innerHTML;
    var restBudget = budget - sumMonth;
    restBudget = restBudget.toFixed(2);
    document.getElementById('rest-budget').innerHTML = restBudget;
});