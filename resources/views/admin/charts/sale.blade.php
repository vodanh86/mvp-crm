<canvas id="saleChart" width="400" height="400"></canvas>
<?php
use App\Models\AuthUser;

$label = array();
$countAll = array();
foreach ($count as $sale) {
    $user = AuthUser::find($sale["sale_id"]);
    if ($user) {
        $label[] = $user->name;
    } else {
        $label[] = "None";
    }
    $countAll[] = $sale["total"];
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
            backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(255, 99, 132, 0.2)',
            'rgba(255, 99, 132, 0.2)',
            'rgba(255, 99, 132, 0.2)',
            'rgba(255, 99, 132, 0.2)',
            'rgba(255, 99, 132, 0.2)'
            ],
            borderColor: [
            'rgba(255,99,132,1)',
            'rgba(255,99,132,1)',
            'rgba(255,99,132,1)',
            'rgba(255,99,132,1)',
            'rgba(255,99,132,1)',
            'rgba(255,99,132,1)'
            ],
            borderWidth: 2
        },
        {
            label: '# of Votes 2',
            data: [15, 19, 3, 5, 2, 3],
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