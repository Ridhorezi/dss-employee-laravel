<x-app-layout>

    @slot('content')
        <div class="container-fluid py-2">
            <div class="row">
                <div class="card col-12 p-4">
                    <h4 class="mb-2">Top 3 Employees</h4>
                    <div class="row">
                        @foreach ($topEmployees as $employee)
                            <div class="col-md-4">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $employee->name }}</h5>
                                        <p class="card-text">Score: {{ $employee->value }}</p>
                                        <!-- Add more information about the employee as needed -->
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="row mt-4">
                            <div class="col-lg-4 col-md-6 mt-4 mb-4">
                                <div class="card z-index-2 ">
                                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                                        <div class="bg-gradient-info shadow-primary border-radius-lg py-3 pe-1">
                                            <div class="chart">
                                                <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="mb-0 ">Website Views</h6>
                                        <p class="text-sm ">Last Campaign Performance</p>
                                        <hr class="dark horizontal">
                                        <div class="d-flex ">
                                            <i class="material-icons text-sm my-auto me-1">schedule</i>
                                            <p class="mb-0 text-sm"> campaign sent 2 days ago </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 mt-4 mb-4">
                                <div class="card z-index-2  ">
                                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                                        <div class="bg-gradient-warning shadow-success border-radius-lg py-3 pe-1">
                                            <div class="chart">
                                                <canvas id="chart-line" class="chart-canvas" height="170"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="mb-0 "> Daily Sales </h6>
                                        <p class="text-sm "> (<span class="font-weight-bolder">+15%</span>) increase in
                                            today
                                            sales. </p>
                                        <hr class="dark horizontal">
                                        <div class="d-flex ">
                                            <i class="material-icons text-sm my-auto me-1">schedule</i>
                                            <p class="mb-0 text-sm"> updated 4 min ago </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 mt-4 mb-3">
                                <div class="card z-index-2 ">
                                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                                        <div class="bg-gradient-primary shadow-dark border-radius-lg py-3 pe-1">
                                            <div class="chart">
                                                <canvas id="chart-line-tasks" class="chart-canvas" height="170"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h6 class="mb-0 ">Completed Tasks</h6>
                                        <p class="text-sm ">Last Campaign Performance</p>
                                        <hr class="dark horizontal">
                                        <div class="d-flex ">
                                            <i class="material-icons text-sm my-auto me-1">schedule</i>
                                            <p class="mb-0 text-sm">just updated</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    @endslot

</x-app-layout>
