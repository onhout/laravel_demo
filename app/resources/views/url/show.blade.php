<x-app-layout>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="mx-auto">
                <p class="text-4xl my-3">{{request()->getSchemeAndHttpHost().'/'.$url->shortened_url}}</p>

                @if($url->chart_arrays())
                    <div class="grid grid-cols-3  grid-flow-col gap-4">
                        <div class="row-span-3">
                            <canvas id="pie-chart" width="200" height="200"></canvas>
                        </div>
                        <div class="col-span-2">
                            <canvas id="bar-chart" width="800" height="200"></canvas>
                        </div>
                        <div class="row-span-2 col-span-2">
                            <canvas id="bar-chart-visitor" width="800" height="200"></canvas>
                        </div>
                    </div>
                    <div>
                        <canvas id="line-chart" width="800" height="200"></canvas>
                    </div>
                @else
                    <p class="text-2xl">No Clicks Yet</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    @if($url->chart_arrays())
    new Chart(document.getElementById("bar-chart"), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_keys($url->chart_arrays()['platform'])) ?>,
            datasets: [
                {
                    label: "Platforms",
                    backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
                    data: <?php echo json_encode($url->chart_arrays()['platform']) ?>
                }
            ]
        }
    });

    new Chart(document.getElementById("bar-chart-visitor"), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_keys($url->chart_arrays()['visitor'])) ?>,
            datasets: [
                {
                    label: "Platforms",
                    backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
                    data: <?php echo json_encode($url->chart_arrays()['visitor']) ?>
                }
            ]
        }
    });

    new Chart(document.getElementById("line-chart"), {
        type: 'line',
        data: {
            labels: <?php echo json_encode(array_keys($url->chart_arrays()['clicks'])) ?>,
            datasets: [{
                data: <?php echo json_encode($url->chart_arrays()['clicks']) ?>,
                label: "Visitors",
                borderColor: "#3e95cd",
                fill: false
            }]
        }
    });

    new Chart(document.getElementById("pie-chart"), {
        type: 'pie',
        data: {
            labels: <?php echo json_encode(array_keys($url->chart_arrays()['browser'])) ?>,
            datasets: [{
                label: "Population (millions)",
                backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
                data: <?php echo json_encode(array_values($url->chart_arrays()['browser'])) ?>,
            }]
        }
    });
    @endif
</script>
