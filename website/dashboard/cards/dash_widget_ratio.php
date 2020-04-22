<!-- 'Notes / Tasks ratio' card -->
<?php
                $widget_ratio_note_sql = "SELECT title FROM UKeepDAT.items_$user_code WHERE type='note' AND `status`!='TRASH'";
                $widget_ratio_note_result = mysql_query($widget_ratio_note_sql) or die(mysql_error());
                $widget_ratio_note_total = mysql_num_rows($widget_ratio_note_result);

                $widget_ratio_task_sql = "SELECT title FROM UKeepDAT.items_$user_code WHERE type='task' AND `status`!='TRASH'";
                $widget_ratio_task_result = mysql_query($widget_ratio_task_sql) or die(mysql_error());
                $widget_ratio_task_total = mysql_num_rows($widget_ratio_task_result);

                $widget_ratio_total = $widget_ratio_note_total + $widget_ratio_task_total;
                $widget_ratio_percentage = ($widget_ratio_note_total/$widget_ratio_total)*100;
              ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <a href="items?view=all">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><b>Notes / Tasks</b> Ratio (<?php echo $widget_ratio_total; ?> items total)</div>
                      </a>
                      <div class="row no-gutters align-items-center">
                        <div class="col">
                          <h4 class="small font-weight-bold"><span class="text-primary"><?php echo $widget_ratio_note_total; ?> Notes</span> <span class="float-right"><?php echo $widget_ratio_task_total; ?> Tasks</span></h4>
                          <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $widget_ratio_percentage; ?>%"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-columns fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>