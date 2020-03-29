<?php include 'essentials.php'; ?> <!-- Place to store user variables -->

<!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-<?php echo $theme_color; ?> sidebar sidebar-dark accordion toggled" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../dashboard/">
        <div class="sidebar-brand-icon">
          <img src="../vendor/img/favicon.png" style="width: 30px; height: 30px;" />
        </div>
        <div class="sidebar-brand-text mx-3">UKeep Dash</div>
      </a>


      <!-- Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="../dashboard/">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <hr class="sidebar-divider">
      <div class="sidebar-heading">Interface</div>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNewItems" aria-expanded="true" aria-controls="collapseNewItems">
          <i class="fas fa-fw fa-plus-square"></i>
          <span>New Item</span>
        </a>
        <div id="collapseNewItems" class="collapse" aria-labelledby="headingItems" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header text-<?php echo $theme_color; ?>">Create New...</h6>
            <a class="collapse-item" href="#" data-toggle="modal" data-target="#newNoteModal"><i class="fas fa-fw fa-sticky-note"></i> Note</a>
            <a class="collapse-item" href="#" data-toggle="modal" data-target="#newTaskModal"><i class="fas fa-fw fa-calendar-check"></i> Task</a>
            <a class="collapse-item" href="#" data-toggle="modal" data-target="#newLabelModal"><i class="fas fa-fw fa-folder"></i> Label</a>
          </div>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseItems" aria-expanded="true" aria-controls="collapseItems">
          <i class="fas fa-fw fa-book"></i>
          <span>View Items</span>
        </a>
        <div id="collapseItems" class="collapse" aria-labelledby="headingItems" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header text-<?php echo $theme_color; ?>">View Items:</h6>
            <a class="collapse-item" href="items?view=all"><i class="fas fa-fw fa-clipboard"></i> All Items</a>
            <a class="collapse-item" href="items?view=notes"><i class="fas fa-fw fa-sticky-note"></i> Notes only</a>
            <a class="collapse-item" href="items?view=tasks"><i class="fas fa-fw fa-calendar-check"></i> Tasks only</a>
            <a class="collapse-item" href="items?view=labels"><i class="fas fa-fw fa-folder"></i> My Labels</a>
          </div>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="teams">
          <i class="fas fa-fw fa-users"></i>
          <span>Teams</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="search">
          <i class="fas fa-fw fa-search"></i>
          <span>Search</span></a>
      </li>

      <hr class="sidebar-divider">
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

          <!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" style="width: 30rem">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search">
              <div class="input-group-append">
                <script type="text/javascript">
                  $('.dropdown-menu','dropdown').click(function(e) {
                      e.stopPropagation();
                  });
                </script>
                <div class="dropdown dropdown-lg">
                  <a href="#" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true">
                    <i class="fas fa-filter fa-sm"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right" style="width: 450px">
                    <div class="dropdown-header text-<?php echo $theme_color; ?>"><b>Advanced Search Features</b></div>
                    <div class="dropdown-divider"></div>
                    <div class="dropdown-header form-horizontal">
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-12">
                            <label for="filter">Show preselected option:</label>
                            <select class="form-control" name="show">
                                <option value="" selected>...</option>
                                <option value="all">All Tasks</option>
                                <option value="week">This week</option>
                                <option value="passed">Passed Deadlines</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <label>Or use more specific search options (leave above empty!):</label><br><br>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-4">
                          <label for="filter">Priority</label>
                            <select class="form-control" name="priority">
                                <option value="" selected>...</option>
                                <option value="high">High Priority</option>
                                <option value="medium">Medium Priority</option>
                                <option value="low">Low Priority</option>
                                <option value="none">None</option>
                            </select>
                          </div>
                          <div class="col-sm-4">
                            <label for="filter">Label</label>
                            <select class="form-control" name="label">
                              <option value="" selected>...</option>
                              <?php include '../_inc/dbconn.php';
                                $sql3 = "SELECT * FROM UKeepDAT.label_$user_code";
                                $result3 = mysql_query($sql3) or die(mysql_error());
                                  
                                while($rws3 = mysql_fetch_array($result3)){
                                  // displaying labels
                                  echo "<option value='".$rws3[1]."'>".$rws3[1]." (".strtolower($rws3[2]).")</option>";
                                } 
                              ?>
                            </select>
                          </div>
                          <div class="col-sm-4">
                            <label for="filter">Status</label>
                              <select class="form-control" name="status">
                                  <option value="" selected>...</option>
                                  <option value="active">Active</option>
                                  <option value="archived">Archived</option>
                              </select>
                          </div>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary" name="advanced_search"><i class="fas fa-search"></i> Advanced Search</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="input-group-append">
                <button class="btn btn-<?php echo $theme_color; ?>" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only on mobile or extra small) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-<?php echo $theme_color; ?>" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">3+</span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header bg-<?php echo $theme_color; ?>">
                  Alerts Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 12, 2019</div>
                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-success">
                      <i class="fas fa-donate text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 7, 2019</div>
                    $290.29 has been deposited into your account!
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 2, 2019</div>
                    Spending Alert: We've noticed unusually high spending for your account.
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
              </div>
            </li>

            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">7</span>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header bg-<?php echo $theme_color; ?>">
                  Message Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div class="font-weight-bold">
                    <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/AU4VPcFN4LE/60x60" alt="">
                    <div class="status-indicator"></div>
                  </div>
                  <div>
                    <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>
                    <div class="small text-gray-500">Jae Chun · 1d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/CS2uCrpNzJY/60x60" alt="">
                    <div class="status-indicator bg-warning"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>
                    <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="">
                    <div class="status-indicator bg-success"></div>
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
                <a class="dropdown-item" href="profile">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile
                </a>
                <a class="dropdown-item" href="settings">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> Settings
                </a>
                <a class="dropdown-item" href="support">
                  <i class="fas fa-life-ring fa-sm fa-fw mr-2 text-gray-400"></i> Support
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