
"use strict";
var year;
loadBarChart();
var spanText = document.getElementById('dyear');
spanText.textContent = 2016;

document.getElementById('bar-year').addEventListener('change', function(e) {
    year = e.target.value;
    loadBarChart(year);
    spanText.textContent = year;
});




function loadBarChart(year = 2016)
{
    axios.get('core/control.php', {
            params: {
              year:  year,
            }
          })
          .then(response => {
            barChartData.datasets[0].data = response.data.Executive
            barChartData.datasets[1].data = response.data.Regular

            //push 0 into the array to make the  chart show well
            barChartData.datasets[0].data.push(0) 
            barChartData.datasets[1].data.push(0)

            //sum the contents of the array
            var execSum = barChartData.datasets[0].data.reduce(sumNum);
            var regSum  = barChartData.datasets[1].data.reduce(sumNum);

            //load them
            document.getElementById('exec').textContent = execSum;
            document.getElementById('reg').textContent  = regSum;

            //process price
            if(execSum > regSum){
                //if users booked executive more than regular reduce exec price by 5%
                var exceprice = (5/100) * 10000
                document.getElementById('ex-price').textContent =  10000 - exceprice
                document.getElementById('rg-price').textContent =  5000

            }else if(regSum > execSum){
                //if users booked regular more than executive leave prices at the same level
                document.getElementById('ex-price').textContent =  10000
                document.getElementById('rg-price').textContent =  5000
            }



            //boot up the chart
            draw1();
            })
          .catch(function (error) {
            alert(error);
    });
} 

    
var barChartData = {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
            label: "Executive",
            backgroundColor: "#4FC1E9",
            hoverBackgroundColor: "#4FC1E9",
            data: []
        }, {
            label: "Regular",
            backgroundColor: "#ffb65f",
            hoverBackgroundColor: "#FFb65f",
            data: []
        }]
};
function draw1() {
    var selector2 = '#bar-chart';

    $(selector2).attr('width', $(selector2).parent().width());
    var myBar = new Chart($("#bar-chart"), {
        type: 'bar',
        data: barChartData
    });
}
function sumNum(total, num){
    num = parseInt(num);
    total = parseInt(total)
    return parseInt(total + num);
}

//  ========================barchart ends=======================

// ================Line chart for revenue=============================
document.getElementById('line-year').addEventListener('change', function(e) {
    var lineYear = e.target.value;
    loadLineChart(lineYear);
});

loadLineChart();


function loadLineChart(year = 2016)
{
    axios.get('core/control.php', {
            params: {
              lineYear:  year,
            }
          })
          .then(response => {
                lineChartData.datasets[1].data = response.data.revenue
                lineChartData.datasets[0].data = response.data.salary

                lineChartData.datasets[1].data.push(0)
                lineChartData.datasets[0].data.push(0)
                
                var month = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

                for(var i = 0; i <= 11; i++){

                    if(parseInt(response.data.revenue[i]) > parseInt(response.data.salary[i])){
                        document.getElementById(month[i]).textContent = 'No Need to layoff staffs'
                    }else{
                        document.getElementById(month[i]).textContent = 'You Need to layoff some staffs'
                    }
                }
                //boot up the chart
                drawLine();
            })
          .catch(function (error) {
            alert(error);
    });
}
//start line chart
var lineChartData = {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [
    {
        fill: false,
        pointBackgroundColor: "rgba(79, 193, 233, 1)",
        pointBorderColor: "#FFF",
        borderJoinStyle: 'miter',
        pointBorderWidth: "1",
        label: "Expenses",
        data: [],
        backgroundColor: "#c62828"
    },
    {
        fill: false,
        pointBackgroundColor: "#FFFF00",
        pointBorderColor: "#000",
        borderJoinStyle: 'miter',
        pointBorderWidth: "1",
        pointStrokeColor: "#76FF03",
        label: "Revenue",
        data: [],
        backgroundColor: "#76FF03"
    }
    ]
};

function drawLine() {

    var selector1 = '#line-chart';

    $(selector1).attr('width', $(selector1).parent().width());
    var myLine = new Chart($("#line-chart"), {
        type: 'line',
        data: lineChartData,
        options: {
            title: {
                display: true,
                text: 'Line Chart for Revenue of selected year'
            }
        }
    });
}
//======================================end line chart===========================================
loadPieChart();

function loadPieChart()
{
    axios.get('core/control.php', {
            params: {
              loadPie:  1,
            }
          })
          .then(response => {

               var dta = response.data;
               
               var staffZone = document.getElementById('staff-dec');
               var name, decision;

                for(var i = 0; i < dta.length; i++){
                    pieData.labels.push(dta[i].name)
                    pieData.datasets[0].data.push(dta[i].ish)

                    if(dta[i].ish > 2){                        
                        name     = dta[i].name;
                        decision = 'Reduce Salary';

                    }else if (dta[i].ish > 0 && dta[i].ish <= 2){
                        name     = dta[i].name;
                        decision = 'Serve Query or Warning';
                    }

                    var newHtml = `<p>${name}:   <span><strong>${decision}</strong></span></p>`;
                    staffZone.insertAdjacentHTML('beforeend', newHtml);
                }


                draw4();

            })
          .catch(function (error) {

            alert(error);
    });
}


var pieData = {
        labels: [],
        datasets: [{
            data: [],
            backgroundColor: [
                "#428BCA",
                "#22d69d",
                "#4FC1E9",
                "#4FC1F9"
            ],
            hoverBackgroundColor: [
                "#428BCA",
                "#22d69d",
                "#4FC1E9",
                "#4FC1F9"
            ]
        }]
    };

function draw4() {

    var selector5 = '#pie-chart';

    $(selector5).attr('width', $(selector5).parent().width());
    var myPie = new Chart($("#pie-chart"), {
        type: 'pie',
        data: pieData
    });
}
// =========================End Pie Chart================================


// ================Line chart for revenue=============================
document.getElementById('line2-year').addEventListener('change', function(e) {
    var lineYear2 = e.target.value;
    loadLineChart2(lineYear2);
});

loadLineChart2();


function loadLineChart2(year = 2016)
{
    axios.get('core/control.php', {
            params: {
              getDam:  year,
            }
          })
          .then(response => {
                
                lineChartData2.datasets[0].data = response.data
                
                var months = [   "jan", "feb", "mar", "apr",
                                "may", "jun", "jul", "aug",
                                "sep", "oct", "nov", "dec"
                            ];
                for(var i = 0; i <= 11; i++){
                    var valz = parseInt(response.data[i]);
                    //reduce 20% of the damage cost
                    var perce = (20/100) * valz;
                    document.getElementById(months[i]).textContent = `for this month allocate ${valz - perce}

                    for maintenance`;
                    
                }
                drawLine2();
            })
          .catch(function (error) {
            alert(error);
    });
}
//start line chart
var lineChartData2 = {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [
        {
            fill: false,
            pointBackgroundColor: "#FFFF00",
            pointBorderColor: "#000",
            borderJoinStyle: 'miter',
            pointBorderWidth: "1",
            pointStrokeColor: "#76FF03",
            label: "Damages",
            data: [],
            backgroundColor: "#76FF03"
        }
    ]
};

function drawLine2() {

    var selectord = '#line-chart2';

    $(selectord).attr('width', $(selectord).parent().width());
    var myLine = new Chart($("#line-chart2"), {
        type: 'line',
        data: lineChartData2,
        options: {
            title: {
                display: true,
                text: 'Trend of Maintenance through the year'
            }
        }
    });
}
//======================================end line chart===========================================