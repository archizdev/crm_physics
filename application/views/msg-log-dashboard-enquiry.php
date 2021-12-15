<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<style>
#chartdiv {
  width: 100%;
  height: 300px;
}
#chartdiv2 {
  width: 100%;
  height: 300px;
}
#chartdiv1 {
  width: 100%;
  height: 500px;
}
  .highcharts-figure, .highcharts-data-table table {
    min-width: 100%; 
    max-width: 800px;
    margin: 1em auto;
}
#chartdiv6 {
  width: 100%;
  height: 500px;
}
.highcharts-data-table table {
	font-family: Verdana, sans-serif;
	border-collapse: collapse;
	border: 1px solid #EBEBEB;
	margin: 10px auto;
	text-align: center;
	width: 100%;
	max-width: 500px;
}
.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}
.highcharts-data-table th {
	font-weight: 600;
    padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
    padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}
.highcharts-data-table tr:hover {
    background: #f1f7ff;
}
</style>
<?php  if(user_access(60)){  ?>
<center>
<h3>Enquiry Dashboard</h3></center>
<div class="row">
    <div class="col-md-4">
        <label>Select Graph Type</label>
        <select name="graphType" class="form-control" id="all_users" >
            <option value="1">Email</option>
            <option value="2">SMS</option>
            <option value="3">Whatsapp</option>
        </select>
    </div>
</div>
<div id="Mehdi_ajax"></div>
<hr>
<br>
<center><h3>Userwise Graph's</h3></center>
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
<style>
#chartdiv {
  width: 100%;
  height: 500px;
}
</style>
<script>
$(document).ready(function(){
    $.ajax({
      url : "<?=base_url('dashboard/userWiseSupportData1')?>",
      type: "post",
      dataType : "json",
      processData: false,
      contentType: false,
      success : function(response)
      {
            am4core.ready(function() {
// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end
var chart = am4core.create("chartdiv231", am4charts.XYChart);
chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

chart.data = response;
// alert(response);
chart.colors.step = 2;
chart.padding(30, 30, 10, 30);
chart.legend = new am4charts.Legend();

var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "category";
categoryAxis.renderer.grid.template.location = 0;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.min = 0;
valueAxis.max = 100;
valueAxis.strictMinMax = true;
valueAxis.calculateTotals = true;
valueAxis.renderer.minWidth = 50;
var series1 = chart.series.push(new am4charts.ColumnSeries());
series1.columns.template.width = am4core.percent(80);
series1.columns.template.tooltipText =
  "{name}: {valueY.totalPercent.formatNumber('#.00')}%";
series1.name = "Email";
series1.dataFields.categoryX = "category";
series1.dataFields.valueY = "value1";
series1.dataFields.valueYShow = "totalPercent";
series1.dataItems.template.locations.categoryX = 0.5;
series1.stacked = true;
series1.tooltip.pointerOrientation = "vertical";

var bullet1 = series1.bullets.push(new am4charts.LabelBullet());
bullet1.interactionsEnabled = false;
bullet1.label.text = "{valueY.totalPercent.formatNumber('#.00')}%";
bullet1.label.fill = am4core.color("#ffffff");
bullet1.locationY = 0.5;

var series2 = chart.series.push(new am4charts.ColumnSeries());
series2.columns.template.width = am4core.percent(80);
series2.columns.template.tooltipText =
  "{name}: {valueY.totalPercent.formatNumber('#.00')}%";
series2.name = "SMS";
series2.dataFields.categoryX = "category";
series2.dataFields.valueY = "value2";
series2.dataFields.valueYShow = "totalPercent";
series2.dataItems.template.locations.categoryX = 0.5;
series2.stacked = true;
series2.tooltip.pointerOrientation = "vertical";

var bullet2 = series2.bullets.push(new am4charts.LabelBullet());
bullet2.interactionsEnabled = false;
bullet2.label.text = "{valueY.totalPercent.formatNumber('#.00')}%";
bullet2.locationY = 0.5;
bullet2.label.fill = am4core.color("#ffffff");

var series3 = chart.series.push(new am4charts.ColumnSeries());
series3.columns.template.width = am4core.percent(80);
series3.columns.template.tooltipText =
  "{name}: {valueY.totalPercent.formatNumber('#.00')}%";
series3.name = "Whatsapp";
series3.dataFields.categoryX = "category";
series3.dataFields.valueY = "value3";
series3.dataFields.valueYShow = "totalPercent";
series3.dataItems.template.locations.categoryX = 0.5;
series3.stacked = true;
series3.tooltip.pointerOrientation = "vertical";

var bullet3 = series3.bullets.push(new am4charts.LabelBullet());
bullet3.interactionsEnabled = false;
bullet3.label.text = "{valueY.totalPercent.formatNumber('#.00')}%";
bullet3.locationY = 0.5;
bullet3.label.fill = am4core.color("#ffffff");
chart.scrollbarX = new am4core.Scrollbar();
});
 }
});
    
});
</script>
<div id="chartdiv231"></div>
<style>
#chartdiv231 { width: 100%;  height: 500px; }
</style>
<script type="text/javascript">
$("#all_users").change(function(){  
    var data =document.getElementById("all_users").value // 1st
    $.ajax({
    type:"POST",
    url: '<?=base_url('dashboard/getuserWiseSupportData')?>',
    data: "id=" + data,
    success: function(result){
        $("#ticketData").empty();
        $("#Mehdi_ajax").html(result);
    }
    });
});
var data =document.getElementById("all_users").value // 1st
    $.ajax({
    type:"POST",
    url: '<?=base_url('dashboard/getuserWiseSupportData')?>',
    data: "id=" + data,
    success: function(result){
        $("#ticketData").empty();
        $("#Mehdi_ajax").html(result);
    }
    });
</script>
<hr>
<?php } if(user_access(231)){  ?>
<center><h3>Support Dashboard</h3></center>
<div class="row">
    <div class="col-md-4">
        <label>Select Graph Type</label>
        <select name="all_users_ticket" class="form-control all_users_ticket" id="all_users_ticket" >
            <option value="11">Email</option>
            <option value="12">SMS</option>
            <option value="13">Whatsapp</option>
        </select>
    </div>
</div>
<div id="ticketData"></div>
<hr>
<br>
<center><h3>Userwise Graph's</h3></center>
<style>
#chartdiv241 {
  width: 100%;
  height: 500px;
}
</style>
<script>
          $(document).ready(function(){
    $.ajax({
      url : "<?=base_url('dashboard/userWiseSupportData1')?>",
      type: "post",
      dataType : "json",
      processData: false,
      contentType: false,
      success : function(response)
      {
            am4core.ready(function() {
am4core.useTheme(am4themes_animated);

var chart = am4core.create("chartdiv241", am4charts.XYChart);
chart.hiddenState.properties.opacity = 0;

chart.data = response;
chart.colors.step = 2;
chart.padding(30, 30, 10, 30);
chart.legend = new am4charts.Legend();

var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "category";
categoryAxis.renderer.grid.template.location = 0;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.min = 0;
valueAxis.max = 100;
valueAxis.strictMinMax = true;
valueAxis.calculateTotals = true;
valueAxis.renderer.minWidth = 50;


var series1 = chart.series.push(new am4charts.ColumnSeries());
series1.columns.template.width = am4core.percent(80);
series1.columns.template.tooltipText =
  "{name}: {valueY.totalPercent.formatNumber('#.00')}%";
series1.name = "Email";
series1.dataFields.categoryX = "category";
series1.dataFields.valueY = "value1";
series1.dataFields.valueYShow = "totalPercent";
series1.dataItems.template.locations.categoryX = 0.5;
series1.stacked = true;
series1.tooltip.pointerOrientation = "vertical";

var bullet1 = series1.bullets.push(new am4charts.LabelBullet());
bullet1.interactionsEnabled = false;
bullet1.label.text = "{valueY.totalPercent.formatNumber('#.00')}%";
bullet1.label.fill = am4core.color("#ffffff");
bullet1.locationY = 0.5;

var series2 = chart.series.push(new am4charts.ColumnSeries());
series2.columns.template.width = am4core.percent(80);
series2.columns.template.tooltipText =
  "{name}: {valueY.totalPercent.formatNumber('#.00')}%";
series2.name = "SMS";
series2.dataFields.categoryX = "category";
series2.dataFields.valueY = "value2";
series2.dataFields.valueYShow = "totalPercent";
series2.dataItems.template.locations.categoryX = 0.5;
series2.stacked = true;
series2.tooltip.pointerOrientation = "vertical";

var bullet2 = series2.bullets.push(new am4charts.LabelBullet());
bullet2.interactionsEnabled = false;
bullet2.label.text = "{valueY.totalPercent.formatNumber('#.00')}%";
bullet2.locationY = 0.5;
bullet2.label.fill = am4core.color("#ffffff");

var series3 = chart.series.push(new am4charts.ColumnSeries());
series3.columns.template.width = am4core.percent(80);
series3.columns.template.tooltipText =
  "{name}: {valueY.totalPercent.formatNumber('#.00')}%";
series3.name = "Whatsapp";
series3.dataFields.categoryX = "category";
series3.dataFields.valueY = "value3";
series3.dataFields.valueYShow = "totalPercent";
series3.dataItems.template.locations.categoryX = 0.5;
series3.stacked = true;
series3.tooltip.pointerOrientation = "vertical";

var bullet3 = series3.bullets.push(new am4charts.LabelBullet());
bullet3.interactionsEnabled = false;
bullet3.label.text = "{valueY.totalPercent.formatNumber('#.00')}%";
bullet3.locationY = 0.5;
bullet3.label.fill = am4core.color("#ffffff");
chart.scrollbarX = new am4core.Scrollbar();
});
      }
});
    
});
</script>
<div id="chartdiv241"></div>
<script type="text/javascript">
$("#all_users_ticket").change(function(){  
    var data =document.getElementById("all_users_ticket").value // 1st
    $.ajax({
    type:"POST",
    url: '<?=base_url('dashboard/getuserWiseSupportData')?>',
    data: "id=" + data,
    success: function(result){
        $("#Mehdi_ajax").empty();
        $("#ticketData").html(result);
    }
    });
});
var data =document.getElementById("all_users_ticket").value // 1st
    $.ajax({
    type:"POST",
    url: '<?=base_url('dashboard/getuserWiseSupportData')?>',
    data: "id=" + data,
    success: function(result){
        $("#Mehdi_ajax").empty();
        $("#ticketData").html(result);
    }
    });
</script>
<?php } ?>