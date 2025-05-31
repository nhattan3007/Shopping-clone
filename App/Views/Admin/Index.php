<?php
include __DIR__ . "/../../../layout/AdminHeader.php";
include __DIR__ . "/../../../Layout/Slidebar.php";
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Primary Card</div>
                <p class="ms-2">#0d6efd</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">Warning Card</div>
                <p class="ms-2">#ffc107</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Success Card</div>
                <p class="ms-2">#198754</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">Danger Card</div>
                <p class="ms-2">#dc3545</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Area Chart Example
                </div>
                <div class="card-body"><canvas id="MyAreaChart" width="100%" height="40"></canvas></div>
                <script>
                    const labelsWeeks = <?php echo json_encode($labels); ?>;
                    const dataWeeks = <?php echo json_encode($revenues); ?>;

                    const cxt = document.getElementById('MyAreaChart').getContext('2d');
                    const MyAreaChart = new Chart(cxt, {
                        type: 'bar',
                        data: {
                            labels: labelsWeeks,
                            datasets: [{
                                label: 'Doanh thu theo tuần (VNĐ)',
                                data: dataWeeks,
                                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1,
                                borderRadius: 5
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return context.dataset.label + ': ' + context.formattedValue.toLocaleString('vi-VN') + ' VNĐ';
                                        }
                                    }
                                }
                            }
                        }
                    });
                </script>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Bar Chart Example
                </div>
                <div class="card-body"><canvas id="MyBarChart" width="100%" height="40"></canvas></div>
                <script>
                    const labelsMonth = <?php echo json_encode($monthsFormatted); ?>;
                    const dataMonth = <?php echo json_encode($counts); ?>;

                    const ctx = document.getElementById('MyBarChart').getContext('2d');
                    const myBarChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labelsMonth,
                            datasets: [{
                                label: 'Số đơn hàng tháng này',
                                data: dataMonth,
                                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1,
                                borderRadius: 5
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    precision: 0
                                }
                            }
                        }
                    });
                </script>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            DataTable Example
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Office</th>
                        <th>Age</th>
                        <th>Start date</th>
                        <th>Salary</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<?php
include __DIR__ . "/../../../Layout/AdminFooter.php"; ?>