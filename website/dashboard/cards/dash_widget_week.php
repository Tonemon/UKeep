<!-- 'Items to do this week' card -->
<?php
                $widget_week_sql = "SELECT title FROM UKeepDAT.items_$user_code WHERE `dateon` BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 7 DAY) AND `type`='task'";
                $widget_week_result = mysql_query($widget_week_sql) or die(mysql_error());
                $widget_week_total = mysql_num_rows($widget_week_result);
              ?>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <a href="items?view=week&advanced_search">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks todo this week (View)</div>
                      </a>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $widget_week_total; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>