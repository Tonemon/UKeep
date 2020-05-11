<!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-<?php echo $theme_color; ?> sidebar sidebar-dark accordion toggled" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/admin/">
        <div class="sidebar-brand-icon">
          <img src="../vendor/img/favicon.png" style="width: 30px; height: 30px;" />
        </div>
        <div class="sidebar-brand-text mx-3">UKeep Admin</div>
      </a>

      <!-- Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="/admin/">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Administration</span></a>
      </li>

      <hr class="sidebar-divider">
      <div class="sidebar-heading">General</div>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNew" aria-expanded="true" aria-controls="collapseNew">
          <i class="fas fa-fw fa-plus-square"></i>
          <span>New...</span>
        </a>
        <div id="collapseNew" class="collapse" aria-labelledby="headingItems" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header text-<?php echo $theme_color; ?>">Creation Menu</h6>
            <a class="collapse-item" href="#" data-toggle="modal" data-target="#newUserModal"><i class="fas fa-fw fa-user-plus"></i> Create new Account</a>
            <a class="collapse-item" href="#" data-toggle="modal" data-target="#newCodeModal"><i class="fas fa-fw fa-id-card-alt"></i> Create Registration Code</a>
          </div>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="true" aria-controls="collapseUsers">
          <i class="far fa-fw fa-list-alt"></i>
          <span>User Management</span>
        </a>
        <div id="collapseUsers" class="collapse" aria-labelledby="headingItems" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header text-<?php echo $theme_color; ?>">User Management</h6>
            <a class="collapse-item" href="users?view=all"><i class="fas fa-fw fa-users"></i> All Users</a>
            <a class="collapse-item" href="users?view=account_requests"><i class="fas fa-fw fa-user-plus"></i> Account Requests</a>
            <a class="collapse-item" href="users?view=premium_requests"><i class="fas fa-fw fa-crown"></i> Premium Requests</a>
            <a class="collapse-item" href="users?view=removed"><i class="fas fa-fw fa-user-times"></i> Removed users</a>
          </div>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="alerts">
          <i class="fas fa-fw fa-server"></i>
          <span>Alert Center</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="support">
          <i class="fas fa-fw fa-life-ring"></i>
          <span>Support</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="codes">
          <i class="fas fa-fw fa-project-diagram"></i>
          <span>Codes</span></a>
      </li>

      <hr class="sidebar-divider">
      <div class="sidebar-heading">Other</div>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMy" aria-expanded="true" aria-controls="collapseMy">
          <i class="fas fa-fw fa-user-circle"></i>
          <span>My Pages</span>
        </a>
        <div id="collapseMy" class="collapse" aria-labelledby="headingItems" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header text-<?php echo $theme_color; ?>">My Pages</h6>
            <a class="collapse-item" href="/dashboard/profile"><i class="fas fa-fw fa-user"></i> My Profile</a>
            <a class="collapse-item" href="/dashboard/settings"><i class="fas fa-fw fa-cogs"></i> My Settings</a>
          </div>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
          <i class="fas fa-fw fa-sign-out-alt"></i>
          <span>Logout</span></a>
      </li>

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>

    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Admin Dashboard link -->
            <li class="nav-item mx-1">
              <a class="nav-link" href="/dashboard/">
                <i class="fas fa-home fa-fw"></i>
              </a>
            </li>

            <!-- Nav Item - Alerts -->
            <?php
              $nav_alertssql = "SELECT count(id) FROM UKeepMAIN.security WHERE status='PENDING'";
              $nav_countalerts = mysql_query($nav_alertssql) or die(mysql_error());
              $nav_alerts = mysql_fetch_array($nav_countalerts);
              $nav_alerts_total = $nav_alerts[0];
            ?>
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-server fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter"><?php echo $nav_alerts_total; ?></span>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header bg-<?php echo $theme_color; ?>">
                  <i class="fas fa-server fa-fw"></i> Alerts Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <div class="mr-3">
                      <div class="icon-circle bg-warning">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                      </div>
                    </div>
                  </div>
                  <div class="font-weight-bold">
                    <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <div class="mr-3">
                      <div class="icon-circle bg-warning">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>
                    <div class="small text-gray-500">Jae Chun · 1d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <div class="mr-3">
                      <div class="icon-circle bg-success">
                        <i class="fas fa-check text-white"></i>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>
                    <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                      <div class="icon-circle bg-success">
                        <i class="fas fa-check text-white"></i>
                      </div>
                    </div>
                  <div>
                    <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</div>
                    <div class="small text-gray-500">Chicken the Dog · 2w</div>
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $user_name; ?></span>
                <img class="img-profile rounded-circle" src="../usericons/<?php echo $user_code; ?>.png">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="/dashboard/profile">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> My Profile
                </a>
                <a class="dropdown-item" href="/dashboard/settings">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> My Settings
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->