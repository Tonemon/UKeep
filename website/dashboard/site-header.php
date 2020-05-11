<!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-<?php echo $theme_color; ?> sidebar sidebar-dark accordion toggled right-click-support-sidebar" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../dashboard/">
        <div class="sidebar-brand-icon">
          <img src="../vendor/img/favicon.png" style="width: 30px; height: 30px;" />
        </div>
        <div class="sidebar-brand-text mx-3">UKeep Dash</div>
      </a>
      <?php
        $side_sql = "SELECT side_suite, side_notes_tasks, side_notes, side_tasks, side_labels, side_trash, side_teams, side_contacts, side_support,  side_guide, side_profile, side_settings FROM UKeepMAIN.preferences WHERE account_usercode='$user_code'";
        $side_result = mysql_query($side_sql) or die(mysql_error());
        $side = mysql_fetch_array($side_result);
        
        $c_side_suite = $side[0];
        $c_side_notes_tasks = $side[1];
        $c_side_notes = $side[2];
        $c_side_tasks = $side[3];
        $c_side_labels = $side[4];
        $c_side_trash = $side[5];
        $c_side_teams = $side[6];
        $c_side_contacts = $side[7];
        $c_side_support = $side[8];
        $c_side_guide = $side[9];
        $c_side_profile = $side[10];
        $c_side_settings = $side[11];
      ?>


      <!-- Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="../dashboard/">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <hr class="sidebar-divider">
      <div class="sidebar-heading">General</div>

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

      <?php if ($c_side_suite == "1"){ ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSuite" aria-expanded="true" aria-controls="collapseSuite">
          <i class="far fa-fw fa-list-alt"></i>
          <span>UKeep Suite</span>
        </a>
        <div id="collapseSuite" class="collapse" aria-labelledby="headingItems" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header text-<?php echo $theme_color; ?>">Goto...</h6>
            <a class="collapse-item" href="items?view=all"><i class="fas fa-fw fa-book"></i> All Items</a>
            <a class="collapse-item" href="items?view=notes&advanced_search"><i class="fas fa-fw fa-sticky-note"></i> All Notes</a>
            <a class="collapse-item" href="items?view=tasks&advanced_search"><i class="fas fa-fw fa-calendar-check"></i> All Tasks</a>
            <a class="collapse-item" href="trash"><i class="fas fa-fw fa-trash-alt"></i> Trash</a>
            <div class="dropdown-divider"></div>
            <a class="collapse-item" href="labels"><i class="fas fa-fw fa-folder"></i> Labels</a>
          </div>
        </div>
      </li>

      <?php } if ($c_side_notes_tasks == "1"){ ?>
      <li class="nav-item">
        <a class="nav-link" href="items?view=all">
          <i class="fas fa-fw fa-book"></i>
          <span>All Items</span></a>
      </li>

      <?php } if ($c_side_notes == "1"){ ?>
      <li class="nav-item">
        <a class="nav-link" href="items?view=notes&advanced_search">
          <i class="fas fa-fw fa-sticky-note"></i>
          <span>Notes</span></a>
      </li>

      <?php } if ($c_side_tasks == "1"){ ?>
      <li class="nav-item">
        <a class="nav-link" href="items?view=tasks&advanced_search">
          <i class="fas fa-fw fa-calendar-check"></i>
          <span>Tasks</span></a>
      </li>

      <?php } if ($c_side_labels == "1"){ ?>
      <li class="nav-item">
        <a class="nav-link" href="labels">
          <i class="fas fa-fw fa-folder"></i>
          <span>Labels</span></a>
      </li>

      <?php } if ($c_side_trash == "1"){ ?>
      <li class="nav-item">
        <a class="nav-link" href="trash">
          <i class="fas fa-fw fa-trash-alt"></i>
          <span>Trash</span></a>
      </li>
      
      <?php } if ($c_side_teams == "1" OR $c_side_contacts == "1" OR $c_side_support == "1") { ?>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">Features</div>
      
      <?php } if ($c_side_teams == "1") { ?>
      <li class="nav-item">
        <a class="nav-link" href="teams">
          <i class="fas fa-fw fa-users"></i>
          <span>Teams</span></a>
      </li>

      <?php } if ($c_side_contacts == "1") { ?>
      <li class="nav-item">
        <a class="nav-link" href="contacts">
          <i class="fas fa-fw fa-user-friends"></i>
          <span>Contacts</span></a>
      </li>

      <?php } if ($c_side_support == "1") { ?>
      <li class="nav-item">
        <a class="nav-link" href="support">
          <i class="fas fa-fw fa-life-ring"></i>
          <span>Support</span></a>
      </li>
      <?php } ?>

      <hr class="sidebar-divider">
      <div class="sidebar-heading">Other</div>

      <?php if ($c_side_guide == "1") { ?>
      <li class="nav-item">
        <a class="nav-link" href="guide">
          <i class="fas fa-fw fa-life-ring"></i>
          <span>Guide</span></a>
      </li>

      <?php } if ($c_side_profile == "1") { ?>
      <li class="nav-item">
        <a class="nav-link" href="profile">
          <i class="fas fa-fw fa-user"></i>
          <span>Profile</span></a>
      </li>

      <?php } if ($c_side_settings == "1") { ?>
      <li class="nav-item">
        <a class="nav-link" href="settings">
          <i class="fas fa-fw fa-cogs"></i>
          <span>Settings</span></a>
      </li>
      <?php } ?>

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

    <!-- Right click support -->
    <div class="dropdown-menu dropdown-menu-sm" id="context-menu-sidebar">
      <div class="dropdown-header text-<?php echo $theme_color; ?>">Perform an action:</div>
      <a class="dropdown-item" href="settings?customize=main"><i class="fas fa-palette"></i> Customize Sidebar</a>
    </div>

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
          <form action="items" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" required>
              <div class="input-group-append">
                <button type="submit" class="btn btn-<?php echo $theme_color; ?>" name="normal_search">
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
                <form action="items" class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" required>
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-<?php echo $theme_color; ?>" name="normal_search">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <!-- Nav Item - Admin Dashboard link -->
            <?php
              $isadmin_sql = "SELECT account FROM UKeepMAIN.users WHERE usercode='$user_code'";
              $isadmin_result = mysql_query($isadmin_sql) or die(mysql_error());
              $isadmin = mysql_fetch_array($isadmin_result);
            
            if ($isadmin[0] == "admin") { ?>

            <li class="nav-item mx-1">
              <a class="nav-link" href="/admin/">
                <i class="fas fa-wrench fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">1</span>
              </a>
            </li>

            <?php } ?>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">3+</span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header bg-<?php echo $theme_color; ?>">
                  <i class="fas fa-envelope fa-fw"></i> Message Center
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
                <i class="fas fa-server fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">7</span>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header bg-<?php echo $theme_color; ?>">
                  <i class="fas fa-server fa-fw"></i> Alert Center
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