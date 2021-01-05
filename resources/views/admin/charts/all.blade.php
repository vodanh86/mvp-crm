<canvas id="allChart" width="400" height="400"></canvas>
<?php 
$label = array();
$countAll = array();
foreach($count as $block){
    if (array_key_exists($block["block_no"], $blocks)){
        $label[] = $blocks[$block["block_no"]];
    } else {
        $label[] = "Không xác định";
    }
    $countAll[] = $block["total"];
} 
?>
<script>
$(function () {
    var ctx = document.getElementById("allChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($label) ?>,
            datasets: [{
                label: 'Số lượng người mỗi toà nhà',
                data: <?= json_encode($countAll)?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
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