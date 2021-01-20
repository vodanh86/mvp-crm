<canvas id="allChart" width="400" height="400"></canvas>
<h3>Báo cáo trạng thái theo toà nhà</h3>
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