<!-- 'Active / Total tasks ratio' card -->
<?php
                $widget_active_sql = "SELECT title FROM UKeepDAT.items_$user_code WHERE status='ACTIVE' AND type='task' AND `status`!='TRASH'";
                $widget_active_result = mysql_query($widget_active_sql) or die(mysql_error());
                $widget_active_total = mysql_num_rows($widget_active_result);

                $widget_count_sql = "SELECT title FROM UKeepDAT.items_$user_code WHERE `status`!='TRASH' AND type='task'";
                $widget_count_result = mysql_query($widget_count_sql) or die(mysql_error());
                $widget_count_total = mysql_num_rows($widget_count_result);

                $wiget_active_percentage = ($widget_active_total/$widget_count_total)*100;
              ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <a href="items?view=tasks&advanced_search">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1"><b>Active / total</b> Tasks</div>
                      </a>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $widget_active_total; ?>/<?php echo $widget_count_total; ?></div>
                        </div>
                        <div class="col">
                          <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $wiget_active_percentage; ?>%"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>