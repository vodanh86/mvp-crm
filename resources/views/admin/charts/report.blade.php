
<h3>Báo cáo lịch hẹn cho từng sale</h3>
<form action="" method="GET" style="width: 100%">
    <div class="row">
        <label class="col-lg-1">Chọn sale:</label>
        <select class="col-lg-3" name="sale_id">
            @foreach ($sales as $id => $sale)
                <option value="{{ $id }}" {{ $id == $sale_id ? 'selected' : '' }} >
                    {{ $sale }}
                </option>
            @endforeach
        </select>
        <label class="col-lg-2"></label>
        <label class="col-lg-2">Chọn thời gian:</label>
        <select class="col-lg-1" name="time">
                <option value="3" {{ $time == 3 ? 'selected' : '' }}>
                    3 ngày
                </option>
                <option value="7" {{ $time == 7 ? 'selected' : '' }} >
                    7 ngày
                </option>
                <option value="30" {{ $time == 30 ? 'selected' : '' }}>
                    1 tháng
                </option>
        </select>
        <div class="col-lg-1">
        <input type="submit" value="Báo cáo">
        </div>
    </div>
</form>
<canvas id="allChart" width="400" height="100"></canvas>
<?php 
$label = array();
$countAll = array();
$countAllSetup = array();
$countAllShow = array();
$countAllDone = array();

$countTmp = array();
$countTmpSetup = array();
$countTmpShow = array();
$countTmpDone = array();


$end   = (new DateTime())->modify('+ 1 day');
$begin = (new DateTime())->modify('-'.$time.' day');

foreach ($count as $app) {
    $countTmp[$app["app_date"]] = $app["total"];
}
foreach ($countShow as $app) {
    $countTmpShow[$app["app_date"]] = $app["total"];
}
foreach ($countSetup as $app) {
    $countTmpSetup[$app["app_date"]] = $app["total"];
}
foreach ($countDone as $app) {
    $countTmpDone[$app["app_date"]] = $app["total"];
}

for($i = $begin; $i <= $end; $i->modify('+1 day')){
    $label[] = $i->format("Y-m-d");
    if (array_key_exists($i->format("Y-m-d"), $countTmp)){
        $countAll[] = $countTmp[$i->format("Y-m-d")]; 
    } else {
        $countAll[] = 0;
    }
    if (array_key_exists($i->format("Y-m-d"), $countTmpShow)){
        $countAllShow[] = $countTmpShow[$i->format("Y-m-d")]; 
    } else {
        $countAllShow[] = 0;
    }
    if (array_key_exists($i->format("Y-m-d"), $countTmpSetup)){
        $countAllSetup[] = $countTmpSetup[$i->format("Y-m-d")]; 
    } else {
        $countAllSetup[] = 0;
    }
    if (array_key_exists($i->format("Y-m-d"), $countTmpDone)){
        $countAllDone[] = $countTmpDone[$i->format("Y-m-d")]; 
    } else {
        $countAllDone[] = 0;
    }
}
?>
<script>
$(function () {
    var ctx = document.getElementById("allChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
				labels: <?= json_encode($label)?>,
                datasets: [{
					label: 'Số appointment',
                    lineTension: 0,  
					backgroundColor: "rgb(54, 162, 235)",
					borderColor: "rgb(54, 162, 235)",
					data: <?= json_encode($countAll)?>,
					fill: false,
				}, {
					label: 'Số show',
					fill: false,
                    lineTension: 0,  
					backgroundColor: "rgb(75, 192, 192)",
					borderColor: "rgb(75, 192, 192)",
					data: <?= json_encode($countAllShow)?>,
				}, {
					label: 'Số setup',
					fill: false,
                    lineTension: 0,  
					backgroundColor: "rgb(255, 159, 64)",
					borderColor: "rgb(255, 159, 64)",
					data: <?= json_encode($countAllSetup)?>,
				}, {
					label: 'Số done',
					fill: false,
                    lineTension: 0,  
					backgroundColor: "rgb(153, 102, 255)",
					borderColor: "rgb(153, 102, 255)",
					data: <?= json_encode($countAllDone)?>,
				}]
			},
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
});
</script>