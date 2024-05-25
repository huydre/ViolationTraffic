<?php

  session_start();
  if (!isset($_SESSION['username'])) {
      header("Location: login.php");
      exit;
  }

  require_once 'db.php';
  $db_username = 'root';
  $db_password = '';
  $servername = 'localhost';
  $port = '3308';
  $dbname = 'traffic_violation_db';

  // Kết nối cơ sở dữ liệu
  $conn = new mysqli($servername, $db_username, $db_password, $dbname, $port);

  // Kiểm tra kết nối
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  // Thực hiện truy vấn
  $query1 = "SELECT * FROM traffic_reports WHERE 1";
  $traffic_reports_result = mysqli_query($conn, $query1);
  $query2 = "SELECT * FROM vehicles WHERE 1";
  $vehicles_result = mysqli_query($conn, $query2);
  $query3 = "SELECT * FROM driving_licenses WHERE 1";
  $license_result = mysqli_query($conn, $query3);

  // Kiểm tra truy vấn
  if (!$traffic_reports_result) {
      die("Query failed: " . mysqli_error($conn));
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Tra cứu vi phạm giao thông</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <?php include 'header.php'; ?>

  <?php include 'sidebar.php'; ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Thống kê</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
          <li class="breadcrumb-item active">Thống kê</li>
        </ol>
      </nav>
    </div>

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="card-body">
                  <h5 class="card-title">Số phương tiện giao thông</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-car-front-fill"></i>
                    </div>
                    <div class="ps-3">
                      <h6>
                        <?php
                          $row = mysqli_num_rows($vehicles_result);
                          echo $row;
                        ?>
                      </h6>
                      <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card license_plate-card">
                <div class="card-body">
                  <h5 class="card-title">Tổng phí chưa nộp phạt</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                      <h6>
                        <?php
                          $total = 0;
                          while ($row = mysqli_fetch_assoc($traffic_reports_result)) {
                            $total += $row['fine'];
                          }
                          // định dạng tiền vnd
                          echo number_format($total, 0, ',', '.') , ' VND';
                        ?>
                      </h6>
                      <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card license_plate-card">
                <div class="card-body">
                  <h5 class="card-title">Số lượng bằng lái</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6>
                        <?php
                          $row = mysqli_num_rows($license_result);
                          echo $row;
                        ?>
                      </h6>
                      <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span>

                    </div>
                  </div>

                </div>
              </div>

            </div><!-- End Customers Card -->

            <!-- Reports -->
            <div class="col-12">
              <div class="card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Thống kê vi phạm giao thông <span>| Tháng nay</span></h5>

                  <!-- Line Chart -->
                  <div id="reportsChart"></div>

                  <?php
                  $query1 = "SELECT report_date, SUM(fine) AS total_fine, COUNT(*) AS total_reports FROM traffic_reports GROUP BY report_date";
                  $traffic_reports_result = mysqli_query($conn, $query1);

                  $violation_data = [];
                  while ($row = mysqli_fetch_assoc($traffic_reports_result)) {
                    $violation_data[] = [
                      'report_date' => $row['report_date'],
                      'total_fine' => $row['total_fine'],
                      'total_reports' => $row['total_reports']
                    ];
                  }
                  ?>

                  <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      new ApexCharts(document.querySelector("#reportsChart"), {
                        series: [{
                          name: 'Tổng tiền phạt',
                          data: <?php echo json_encode(array_column($violation_data, 'total_fine')); ?>,
                        }, {
                          name: 'Số vi phạm',
                          data: <?php echo json_encode(array_column($violation_data, 'total_reports')); ?>,
                        }],
                        chart: {
                          height: 500,
                          type: 'area',
                          toolbar: {
                            show: false
                          },
                        },
                        markers: {
                          size: 4
                        },
                        colors: ['#4154f1', '#ff0000'],
                        fill: {
                          type: "gradient",
                          gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.3,
                            opacityTo: 0.4,
                            stops: [0, 90, 100]
                          }
                        },
                        dataLabels: {
                          enabled: false
                        },
                        stroke: {
                          curve: 'smooth',
                          width: 2
                        },
                        xaxis: {
                          type: 'datetime',
                          categories: <?php echo json_encode(array_column($violation_data, 'report_date')); ?>,
                        },
                        tooltip: {
                          x: {
                            format: 'dd/MM/yy'
                          },
                        }
                      }).render();
                    });
                  </script>

                </div>

              </div>
            </div><!-- End Reports -->

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

          <!-- Recent Activity -->
          <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>
            
            <!-- Hoat dong gan day -->
            <div class="card-body">
              <h5 class="card-title">Hoạt động gần đây <span>| Tháng này</span></h5>

              <div class="activity">

              <div class="activity-item d-flex">
              <div class="activite-label">1 ngày trước</div>
              <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
              <div class="activity-content">
              Tổ chức <a href="#" class="fw-bold text-dark">kiểm tra nồng độ cồn</a> ở Hà Nội
              </div>
              </div><!-- End activity item-->

              <div class="activity-item d-flex">
              <div class="activite-label">2 ngày trước</div>
              <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
              <div class="activity-content">
              Tổ chức <a href="#" class="fw-bold text-dark">kiểm tra tốc độ</a> ở Hà Nội
              </div>
              </div><!-- End activity item-->

              <div class="activity-item d-flex">
              <div class="activite-label">3 ngày trước</div>
              <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
              <div class="activity-content">
              Tổ chức <a href="#" class="fw-bold text-dark">kiểm tra giấy tờ xe</a> ở Hà Nội
              </div>
              </div><!-- End activity item-->

              <div class="activity-item d-flex">
              <div class="activite-label">4 ngày trước</div>
              <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
              <div class="activity-content">
              Tổ chức <a href="#" class="fw-bold text-dark">tuyên truyền an toàn giao thông</a> ở Hà Nội
              </div>
              </div><!-- End activity item-->

              <div class="activity-item d-flex">
              <div class="activite-label">5 ngày trước</div>
              <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
              <div class="activity-content">
              Tổ chức <a href="#" class="fw-bold text-dark">xử phạt không đội mũ bảo hiểm</a> ở Hà Nội
              </div>
              </div><!-- End activity item-->

              <div class="activity-item d-flex">
              <div class="activite-label">6 ngày trước</div>
              <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
              <div class="activity-content">
              Tổ chức <a href="#" class="fw-bold text-dark">tập huấn lái xe an toàn</a> ở Hà Nội
              </div>
              </div><!-- End activity item-->

              <div class="activity-item d-flex">
              <div class="activite-label">1 tuần trước</div>
              <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
              <div class="activity-content">
              Tổ chức <a href="#" class="fw-bold text-dark">kiểm tra nồng độ cồn</a> ở Hà Nội
              </div>
              </div><!-- End activity item-->

              <div class="activity-item d-flex">
              <div class="activite-label">2 tuần trước</div>
              <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
              <div class="activity-content">
              Tổ chức <a href="#" class="fw-bold text-dark">kiểm tra tốc độ</a> ở Hà Nội
              </div>
              </div><!-- End activity item-->

              <div class="activity-item d-flex">
              <div class="activite-label">3 tuần trước</div>
              <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
              <div class="activity-content">
              Tổ chức <a href="#" class="fw-bold text-dark">kiểm tra giấy tờ xe</a> ở Hà Nội
              </div>
              </div><!-- End activity item-->

              <div class="activity-item d-flex">
              <div class="activite-label">4 tuần trước</div>
              <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
              <div class="activity-content">
              Tổ chức <a href="#" class="fw-bold text-dark">tuyên truyền an toàn giao thông</a> ở Hà Nội
              </div>
              </div><!-- End activity item-->

              </div><!-- End activity -->


              </div><!-- End activity -->


            </div>
          </div>

        </div><!-- End Right side columns -->

      </div>
    </section>

  </main><!-- End #main -->

  <?php include 'footer.php'; ?>
  

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>