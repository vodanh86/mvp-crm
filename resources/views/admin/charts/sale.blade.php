<canvas id="saleChart" width="400" height="400"></canvas>
<?php
use App\Models\AuthUser;

$label = array();
$countAll = array();
$dictCount = array();
$countNew = array();
foreach ($countSaleNew as $sale) {
    $dictCount[$sale["sale_id"]] = $sale["total"];
}
foreach ($count as $sale) {
    if ($sale["sale_id"]){
        $user = AuthUser::find($sale["sale_id"]);
        if ($user) {
            $label[] = $user->name;
        } else {
            $label[] = "None";
        }
        $countAll[] = $sale["total"];
        if (array_key_exists($sale["sale_id"], $dictCount)){
            $countNew[] = $dictCount[$sale["sale_id"]];
        } else {
            $countNew[] = 0;
        }
    }
}
?>
<script>
$(function () {
    var ctx = document.getElementById("saleChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?=json_encode($label)?>,
            datasets: [{
                label: 'Số lượng người theo sale',
                data: <?= json_encode($countAll)?>,
                backgroundColor: <?php 
                    $background = array();
                    $border = array();
                    foreach($label as $l){
                        $background[] = 'rgba(255, 99, 132, 0.2)';
                        $border[] = 'rgba(255,99,132,1)';
                    }
                    echo(json_encode($background));
                ?>,
                borderColor: <?= json_encode($border) ?>,
                borderWidth: 2
            },
            {
                label: 'chưa liên hệ',
                data: <?= json_encode($countNew) ?>,
                backgroundColor: [
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 2
            }
        ]
    },
    options: {
        scales: {
        yAxes: [{
            stacked: true,
            ticks: {
            beginAtZero: true
            }
        }],
        xAxes: [{
            stacked: true,
            ticks: {
            beginAtZero: true
            }
        }]

        }
    }
    });
});
</script>