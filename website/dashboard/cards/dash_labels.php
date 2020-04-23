<!-- 'Label Usage' card -->
              <div class="card shadow mb-4">
                <?php
                  // count total items (without counting trash items)
                  $ratio_sql = "SELECT title FROM UKeepDAT.items_$user_code WHERE `status`!='TRASH'";
                  $ratio_result = mysql_query($ratio_sql) or die(mysql_error());
                  $ratio_total = mysql_num_rows($ratio_result);

                  $viewlabel_sql = "SELECT * FROM UKeepDAT.label_$user_code";
                  $label_result = mysql_query($viewlabel_sql) or die(mysql_error());
                  $label_num_rows = mysql_num_rows($label_result);                    
                ?>
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-folder"></i> Label Analytics</h6>
                </div>
                <div class="card-body">
                  All your Labels (<?php echo $label_num_rows; ?> total)<span class="small font-weight-bold float-right">% of items has the label</span>
                    <div class="dropdown-divider"></div><br>


                  <?php // display each label
                    while ($rws = mysql_fetch_array($label_result)) {
                      // color matching for the badges and progress bars
                      $badgecolor = $rws[2];
                      $per_sql = "SELECT title FROM UKeepDAT.items_$user_code WHERE label='$rws[0]' AND `status`!='TRASH'";
                      $per_result = mysql_query($per_sql) or die(mysql_error());
                      $per_numrows = mysql_num_rows($per_result);

                      $per_current = ($per_numrows/$ratio_total)*100;
                    ?>

                    <span class="font-weight-bold float-right">&nbsp; <?php echo $per_current; ?>%</span>

                    <div class="progress progress-bar-striped mb-4">
                      <div class="progress-bar bg-<?php echo $badgecolor; ?>" role="progressbar" style="width: <?php echo $per_current; ?>%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                        <span class="d-flex position-absolute w-100">
                          <span class='badge badge-<?php echo $badgecolor; ?>'><?php echo $rws[1]; ?></span>
                        </span>
                        <span class="justify-content-center d-flex position-absolute w-100 text-dark">
                          <?php echo $per_numrows."/".$ratio_total." items"; ?>
                        </span>
                      </div>
                    </div>
                  <?php } ?>

                  <?php // progress bar for 'No Labels'
                      $nolabel_sql = "SELECT title FROM UKeepDAT.items_$user_code WHERE label='' AND `status`!='TRASH'";
                      $nolabel_result = mysql_query($nolabel_sql) or die(mysql_error());
                      $nolabel_numrows = mysql_num_rows($nolabel_result);

                      $nolabel_current = ($nolabel_numrows/$ratio_total)*100;
                  ?>
                  
                  <div class="dropdown-divider"></div><br>
                  <span class="font-weight-bold float-right">&nbsp; <?php echo $nolabel_current; ?>%</span>

                    <div class="progress progress-bar-striped mb-4">
                      <div class="progress-bar bg-secondary" role="progressbar" style="width: <?php echo $nolabel_current; ?>%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                        <span class="d-flex position-absolute w-100"><b><i>&nbsp; <u>No label</u></i></b></span>
                        <span class="justify-content-center d-flex position-absolute w-100 text-dark">
                          <?php echo $nolabel_numrows."/".$ratio_total." items"; ?>
                        </span>
                      </div>
                    </div>
                    

                </div>
              </div>