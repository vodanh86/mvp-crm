<canvas id="saleStatusChart" width="400" height="400"></canvas>
<h3>Báo cáo trạng thái theo Sale: <?= $name ?></h3>
<?php 
$label = array();
$countAll = array();
foreach($count as $oneStatus){
    $label[] = $status[$oneStatus["status"]];
    $countAll[] = $oneStatus["total"];
} 
?>
<script>
$(function () {
    var ctx = document.getElementById("saleStatusChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?= json_encode($label) ?>,
            datasets: [{
                label: 'Số lượng người theo trạng thái',
                data: <?= json_encode($countAll)?>,
                backgroundColor: <?php 
                    $background = array();
                    $border = array();
                    foreach($label as $l){
                        $background[] = "rgba(".mt_rand(0, 255).", ".mt_rand(0, 255).", ".mt_rand(0, 255).", 0.2)";
                        $border[] = "rgba(".mt_rand(0, 255).", ".mt_rand(0, 255).", ".mt_rand(0, 255).", 0.2)";
                    }
                    echo(json_encode($background));
                ?>,
                borderColor: <?= json_encode($border) ?>,
                borderWidth: 1
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