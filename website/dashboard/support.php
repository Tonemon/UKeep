<?php 
session_start();
if (!isset($_SESSION['session_keep_start']))
  header('location:../login?notice=2');

include 'essentials.php';

  $support_sql = "SELECT * FROM UKeepMAIN.users WHERE usercode='$user_code'";
  $support_result = mysql_query($support_sql) or die(mysql_error());
  $supportarr = mysql_fetch_array($support_result);

  // variables for different fields on this page
  $display_fullname = $supportarr[1];
  $display_email = $supportarr[2];

  if (isset($_REQUEST['submit_question'])){

    // getting variables to store in table
    $qname = mysql_real_escape_string($_REQUEST['q_name']);
    $qemail = mysql_real_escape_string($_REQUEST['q_email']);
    $qtype = mysql_real_escape_string($_REQUEST['q_category']);
    $qmessage = mysql_real_escape_string($_REQUEST['q_content']);

    // variables to set on the go
    $qstatus = "TO REVIEW";
    $qfrom = "User";
    $qdate = date('Y-m-d h:i:s');

    // insert question to table 'questions'
    $qsql = "INSERT INTO UKeepMAIN.questions values('','$qname','$qemail','$qtype','$qmessage','$qstatus','','$qfrom','$qdate')";
    mysql_query($qsql) or die(header('location:profile?error=1'));
    header('location:profile?success=1');
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>

  <?php include 'addons/metadata.php'; ?>
  <title>Support &bull; UKeep</title>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php include 'site-header.php'; ?> <!-- Sidebars are stored here -->

    <!-- Begin Page Content -->
    <div class="container-fluid">
      <?php
        if ($_GET['success'] == "1") { // created new task
          echo "<div class='alert alert-success alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <i class='fas fa-check'></i> Question successfully submitted. </div>";
        } elseif ($_GET['error'] == "1") { // error: something wrong
          echo "<div class='alert alert-warning alert-dismissible'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <i class='fas fa-exclamation-triangle'></i> Oh. Something went wrong. Please try again.</div>";
        }
      ?>


      <!-- Page Heading -->
      <h1 class="h3 mb-4 text-gray-800">Support page</h1>

      <div class="row">

        <!-- Submit your question -->
        <div class="col-xl-6 col-lg-7">
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-life-ring"></i> Submit your Question</h6>
            </div>
            <div class="card-body">
              <p>If you got any questions please submit the form below and we will answer it as soon as possible.</p>
              <form action="support" method="POST">
                <table>
                  <tr>
                    <td>First name:</td>
                    <td><input type="text" name="q_name" class="form-control" value="<?php echo $display_fullname; ?>" disabled="disabled" /></td>
                  </tr>
                  <tr>
                    <td>Email address:</td>
                    <td><input type="email" name="q_email" class="form-control" value="<?php echo $display_email; ?>" disabled="disabled" /></td>
                  </tr>
                  <tr>
                    <td>Category:</td>
                    <td>
                      <select name="q_category" class="form-control" required="required" data-error="Select your category.">
                        <option value="" disabled selected>Select a category</option>
                        <option value="About">About UKeep Service / UKeep Group</option>
                        <option value="Bug">Exploit/Bug Found</option>
                        <option value="Other">Other</option>
                      </select>
                    </td>
                  </tr> 
                </table><br>
                <small class="form-text">Enter more information about your question below.</small>
                <textarea class="form-control" name="q_content" rows="2" placeholder="Please enter your question here" required></textarea><br>
                <button type="submit" class="btn btn-<?php echo $theme_color; ?>" name="submit_question"><i class="fas fa-check"></i> Submit my Question</button>
              </form>
            </div>
          </div>
        </div>

        <!-- View question responses (show this card only if one or more questions are answered) -->
        <div class="col-xl-6 col-lg-7">
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-reply-all"></i> Answered Questions</h6>
              <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">  <i class="fas fa-ellipsis-v fa-sm fa-fw text-<?php echo $theme_color; ?>"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                  <div class="dropdown-header text-<?php echo $theme_color; ?>">Select a question folder</div>
                  <a class="dropdown-item" href="?folder=inbox"><i class="fas fa-fw fa-inbox"></i> Inbox</a>
                  <a class="dropdown-item" href="?folder=archived"><i class="fas fa-fw fa-archive"></i> Archived</a>
                  <a class="dropdown-item" href="?folder=deleted"><i class="fas fa-fw fa-trash-alt"></i> Deleted</a>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i> This feature is not yet available.
              </div>
              <p>You have no answered questions.</p>
              
            </div>
          </div>
        </div>


      </div>

    </div>
    <!-- /.container-fluid -->

  </div>
  <!-- End of Main Content -->

  <?php include 'site-footer.php'; ?>

</body>
</html>