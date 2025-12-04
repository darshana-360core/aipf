<h5 class="text-lg font-normal leading-none text-white pe-1">Income Overview Chart</h5>
<div class="py-6 grid place-items-center px-2">
    <div id="pie-chart"></div>
</div>
@if(($data['user']['roi_income'] + $data['user']['level_income'] + $data['user']['reward'] + $data['user']['direct_income']) > 0)
<script>
    const chartConfig = {
        // series: [1200, 800, 400, 300, 1000],
        series: [{{$data['user']['roi_income']}}, {{$data['user']['level_income']}}, {{$data['user']['reward']}}, {{$data['user']['direct_income']}}],
        chart: {
            type: "pie",
            width: 280,
            height: 280,
            toolbar: {
                show: false,
            },
        },
        title: {
            show: "Income Visual Representation",
        },
        dataLabels: {
            enabled: true,
        },
        colors: ["#287a96", "#8d5604", "#009688", "#f4bc96", "#c5c8d0"],
        legend: {
            show: false,
        },
        labels: ["Ads Income", "Group Income", "Director Income", "Referral Income"], // Add the portion names here
    };

    const chart = new ApexCharts(document.querySelector("#pie-chart"), chartConfig);

    chart.render();
</script>
@else
<script>
    const chartConfig = {
        // series: [1200, 800, 400, 300, 1000],
        series: [100],
        chart: {
            type: "pie",
            width: 280,
            height: 280,
            toolbar: {
                show: false,
            },
        },
        title: {
            show: "Income Visual Representation",
        },
        dataLabels: {
            enabled: true,
        },
        colors: ["#287a96"],
        legend: {
            show: false,
        },
        labels: ["No Income"], // Add the portion names here
    };

    const chart = new ApexCharts(document.querySelector("#pie-chart"), chartConfig);

    chart.render();
</script>
@endif