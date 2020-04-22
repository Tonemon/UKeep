<!-- 'Task deadlines passed' card -->
<?php
                $widget_passed_sql = "SELECT title FROM UKeepDAT.items_$user_code WHERE `dateon` < CURRENT_DATE() AND `type`='task' AND `status`!='TRASH'";
                $widget_passed_result = mysql_query($widget_passed_sql) or die(mysql_error());
                $widget_passed_total = mysql_num_rows($widget_passed_result);
              ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <a href="items?view=passed&advanced_search">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Task Deadlines missed (View)</div>
                      </a>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $widget_passed_total; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar-times fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>