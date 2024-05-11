<?php
  $current_page = basename($_SERVER['PHP_SELF']);
?>

<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
    <a class="nav-link <?php echo ($current_page == 'index.php') ? '' : 'collapsed'; ?>" href="index.php">
      <i class="bi bi-grid"></i>
      <span>Thống kê</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link <?php echo ($current_page == 'tra-cuu.php') ? '' : 'collapsed'; ?>" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-menu-button-wide"></i><span>Tra cứu</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="components-alerts.html">
          <i class="bi bi-circle"></i><span>Tra cứu vi phạm qua biển số</span>
        </a>
      </li>
      <li>
        <a href="components-accordion.html">
          <i class="bi bi-circle"></i><span>Tra cứu vi phạm qua số biên bản</span>
        </a>
      </li>
    </ul>
  </li>

  <li class="nav-item" >
    <a href="traffic_reports_management.php" class="nav-link <?php echo ($current_page == 'traffic_reports_management.php') ? '' : 'collapsed'; ?>">
      <i class="bi bi-grid"></i>
      <span>Quản lý lỗi vi phạm</span>
    </a>
  </li>
  <li class="nav-item">
    <a href="vehicle-management.php" class="nav-link <?php echo ($current_page == 'vehicle-management.php') ? '' : 'collapsed'; ?>">
      <i class="bi bi-grid"></i>
      <span>Quản lý phương tiện</span>
    </a>
  </li>
  <li class="nav-item">
    <a href="driving-licenses-management.php" class="nav-link <?php echo ($current_page == 'driving-licenses-management.php') ? '' : 'collapsed'; ?>">
      <i class="bi bi-grid"></i>
      <span>Quản lý bằng lái</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link collapsed">
      <i class="bi bi-grid"></i>
      <span>Nộp phạt</span>
    </a>
  </li>

</ul>

</aside>