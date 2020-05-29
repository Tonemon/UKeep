<?php 
session_start();
if (!isset($_SESSION['session_keep_start']))
  header('location:../login?notice=2');

include 'essentials.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <?php include 'addons/metadata.php'; ?>
  <title>Guide &bull; UKeep</title>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php include 'site-header.php'; ?> <!-- Sidebars are stored here -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i> The information on this page is incomplete at the moment.
          </div>

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Guide on how to use the UKeep Dashboard</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm" disabled><i class="fas fa-download fa-sm text-white-50"></i> Print this page</a>
          </div>


          <div class="row">
            <div class="col-xl-12">

            <!-- Introduction card -->  
              <div class="card shadow mb-4">
                <a href="#collapseCardIntro" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardIntro">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-info-circle"></i> Introduction</h6>
                </a>
                <div class="collapse show" id="collapseCardIntro">
                  <div class="card-body">
                    <p>Thank you for choosing our UKeep service. UKeep is an advanced online note/task managing service to keep you productive and organized. This guide will introduce you to all of UKeeps functionalities, so you can start right away. It is divided into several categories containing information on these subjects:</p>

                    <ul>
                      <li><span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-clipboard"></i> Basic Functionality</span> - containing information about creating your first items, managing them and how to work efficiently while using this tool.</li>
                      <li><span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-globe"></i> Pages and their Features</span> - information about navigating UKeep and a list of all features and where to find them.</li>
                      <li><span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-palette"></i> Customization</span> - containing all information about customizing each aspect of your UKeep SMART Dashboard and how to use the customization features to increase your work efficiency.</li>
                      <li><span class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-gem"></i> Free vs. Premium</span> - a comparison of the UKeep free version versus the UKeep premium version. All of the features are displayed here.</li>
                    </ul>

                    <p class="mb-0">Click on the corresponding card below to open it and start reading.</p>
                  </div>
                </div>
              </div>
            
            <!-- Basic functionality card --> 
              <div class="card shadow mb-4">
                <a href="#collapseCardBasic" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardBasic">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-clipboard"></i> Basic Functionality</h6>
                </a>
                <div class="collapse" id="collapseCardBasic">
                  <div class="card-body">
                    <p>UKeep is a tool which can help you to manage all of your notes and tasks using labels and different input fields. The main difference between <span class="font-weight-bold text-<?php echo $theme_color; ?>">notes</span> and <span class="font-weight-bold text-<?php echo $theme_color; ?>">tasks</span> is:</p>

                    <ul>
                      <li><span class="font-weight-bold text-<?php echo $theme_color; ?>">Notes</span> contain your basic note taking fiels, such as note title, label, status (active note / archived), note description and the feature to bookmark it and hereby display it on your SMART Dashboard.</li>
                      <li><span class="font-weight-bold text-<?php echo $theme_color; ?>">Tasks</span> are more advanced and contain the same fields as a note, but also task taking fields, such as task due date, priority, location and people. These extra fields help you to specify as much information as needed to perform a task and allows you to easily find a particular task using the advanced filter.</li>
                    </ul>

                    <p class="mb-0">Managing items is one of the key features of UKeep and can be done by doing the following:</p>
                    <ul>
                      <li><span class="font-weight-bold text-<?php echo $theme_color; ?>">Creating an item (note/task/label)</span> can be done by clicking the <a href="#" data-toggle="collapse" data-target="#collapseNewItems" aria-expanded="true" aria-controls="collapseNewItems"><span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-plus-square"></i> New Item</span></a> link in your sidebar or by clicking the <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-plus-square"></i> icon</span> on the bottom right side of every page. Choose your item to create, fill in the form and create the item. After creating you will be send to the overview, where you can manage your items. All of your items can also be viewed by clicking on the <span class="font-weight-bold text-<?php echo $theme_color; ?>">Notes, Tasks</span> or <span class="font-weight-bold text-<?php echo $theme_color; ?>">Labels</span> link in the sidebar (or by selecting a category to view when the 'UKeep Suite' dropdown in the sidebar is enabled). You can also <span class="font-weight-bold text-<?php echo $theme_color; ?>">change your viewing category</span> by clicking on the <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-clipboard"></i> Items</span> button next to 'Viewing category:', which will display a more advanced dropdown.</li>
                      <li><span class="font-weight-bold text-<?php echo $theme_color; ?>">Editing an item</span> can be done by selecting it and by pressing on the edit button on the bottom right side of the page or inside the rightclick menu (by selecting the item and rightclicking on it).</li>
                      <li><span class="font-weight-bold text-<?php echo $theme_color; ?>">Removing an item</span> can be done by selecting it and using the bottom right button or also by selecting it in the rightclick menu. Items are <span class="font-weight-bold text-<?php echo $theme_color; ?>">not permanently gone</span> when removed from your items. Deleted items can be found in the <a href="trash"><span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-trash-alt"></i> Trash</span></a> where they can be permanently deleted or restored.</li>
                    </ul>

                    <p class="mb-0"><span class="font-weight-bold text-<?php echo $theme_color; ?>">Bookmarking</span> an item will place it on your dashboard in the <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-bookmark"></i> Bookmarked Items</span> section. <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-random"></i> Transforming an item</span> will change a note to a task or reversed. This is usefull in scenarios when a memo needs to become a task allowing it to be more detailed than a note.</p>

                    <p class="mb-0">More information coming soon..</p>
                  </div>
                </div>
              </div>

            <!-- Pages card -->  
              <div class="card shadow mb-4">
                <a href="#collapseCardPages" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardPages">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-globe"></i> Pages and their Features</h6>
                </a>
                <div class="collapse" id="collapseCardPages">
                  <div class="card-body">
                    <p>
                      <a href="../dashboard/">
                        <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-link"></i> SMART Dashboard</span>
                      </a><br> This is your automatically updating SMART dashboard with information about your notes, tasks and labels. The first 3 widgets show information about your tasks and can be enabled/disabled in the <a href="settings?customize=dashboard"><span class="font-weight-bold text-<?php echo $theme_color; ?>">dashboard customization settings</span></a>, where the intro card can be disabled as well. The <span class="font-weight-bold text-<?php echo $theme_color; ?>">item activity and type overview</span> show more stats about your items. The <span class="font-weight-bold text-<?php echo $theme_color; ?>">Label Analytics</span> show each of your labels and how much across different items they are used. The <span class="font-weight-bold text-<?php echo $theme_color; ?>"> Bookmarked Items</span> section contains all of your items which have been bookmarked in the edit page.
                    </p>

                    <p>
                      <a href="items?view=all">
                        <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-link"></i> View Items (Notes and Tasks)</span>
                      </a><br> This page is an overview of your items. Click on the <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-clipboard"></i> Items</span> button to view the items sorted by category. The items can also be displayed by priority, label and status when clicked on the <b>Filter</b> option on the top right side of the card.
                    </p>

                    <p>
                      <a href="contacts">
                        <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-link"></i> Managing contacts (premium feature)</span>
                      </a><br> Contacts is a premium feature to share items with one of your friend or coworker. There are multiple ways to add new contacts. You can start adding someone as a contact by visiting their profile and clicking on the 'add contact' button, which will send a request to the user, or by going to the contacts page and searching for your friend/coworker and adding them by pressing on the <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-user-plus"></i></span> button. After that you will be able to share an item by using the 'share item with...' dropdown while editing an item.
                    </p>

                    <p>
                      <a href="teams">
                        <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-link"></i> Managing teams (premium feature)</span>
                      </a><br> Teams can be managed by premium members to share items and collaborate with multiple people. Start by creating a team and by inviting people to join your team. To be able to do that you will first need to add a person to your contacts and let them accept the invitation to be able to add them to your team. After successfully creating a team, a new field can be found while editing items (called 'share item with...'), which will give team members the ability to edit the note/task you have shared with them.
                    </p>

                    <p>
                      <a href="support">
                        <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-link"></i> Support Panel</span>
                      </a><br> The support panel will let you to directly communicate with our customer support department. You can ask a question by submitting the form on the support page. Answered questions will appear next to the 'Submit your Question' card and can be removed after reading, to keep your page clean.
                    </p>

                    <p>
                      <a href="profile">
                        <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-link"></i> Your Profile</span>
                      </a><br> You can view and change all of your personal information on the profile page. You can see how other people see your profile by clicking on the info box below your profile information. To change what other people can see, you can go to the <a href="settings?customize=profile"><span class="font-weight-bold text-<?php echo $theme_color; ?>">public profile settings</span></a> and enable/disable the parts you want to be visible or hidden.
                    </p>

                    <p class="mb-0">
                      <a href="settings">
                        <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-link"></i> All of your settings</span>
                      </a><br> You can change all of your account preferences in the settings. This page is divided into two columns, seperating the customization settings from the account settings. Actions can be performed by selecting a category using the <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-ellipsis-v"></i></span> button or by rightclicking on the prefered card.
                    </p>
                  </div>
                </div>
              </div>

            <!-- Customization card --> 
              <div class="card shadow mb-4">
                <a href="#collapseCardCustom" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardCustom">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-palette"></i> Customization</h6>
                </a>
                <div class="collapse" id="collapseCardCustom">
                  <div class="card-body">
                    <p class="mb-0">There are a lot of different features to customize in the UKeep SMART Dashboard. You can customize the following:
                      <ul>
                        <li>
                          Your <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-fw fa-palette"></i> Dashboard Theme</span> (color across all pages of the UKeep service), <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-fw fa-map-signs"></i> Login Redirect</span> (the page you will be redirected to each time you login) and <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-fw fa-external-link-alt"></i> Sidebar items</span> (select which links will be displayed in the sidebar).
                        </li>
                        <li>Your <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-fw fa-columns"></i> Work Efficiency Settings</span> (select the way your items on the <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-clipboard"></i> Items</span> page will be displayed. You can choose to show them in Big picture mode or compact mode).</li>
                        <li>Your <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-fw fa-tachometer-alt"></i> SMART Dashboard</span> (select which widgets and card you want to hide from your dashboard).</li>
                        <li>Your <span class="font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-fw fa-user-circle"></i> Public profile</span> (select which information is available for others to see on your public profile. You can enable/disable the profile picture, your online/offline status, full name, email address, date of birth and gender).</li>
                      </ul>
                    </p>
                  </div>
                </div>
              </div>

            <!-- Free vs Premium account card -->
              <div class="card shadow mb-4">
                <a href="#collapseCardFreePrem" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardFreePrem">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-gem"></i> Free vs. Premium</h6>
                </a>
                <div class="collapse" id="collapseCardFreePrem">
                  <div class="card-body">
                    <p>As a premium member you can enjoy more features, like collaborating with multiple people using <span class="font-weight-bold text-<?php echo $theme_color; ?>">Teams</span> and sharing notes with a friend/coworker by adding them in <span class="font-weight-bold text-<?php echo $theme_color; ?>">Contacts</span>.</p>

                    <p class="mb-0">More premium features will come soon..</p>
                  </div>
                </div>
              </div>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

  <?php include 'site-footer.php'; ?>
  

  <!-- Custom scripts for charts -->
  <script src="../vendor/js/chart.js/Chart.min.js"></script>
  <script src="addons/chart-area-demo.js"></script>
  <script src="addons/chart-pie-demo.js"></script>

</body>
</html>