<!-- Bookmarked Items card -->
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-<?php echo $theme_color; ?>"><i class="fas fa-bookmark"></i> Bookmarked Items</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-<?php echo $theme_color; ?>"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header text-<?php echo $theme_color; ?>">Bookmarked Actions:</div>
                      <a class="dropdown-item" href="items?view=bookmarked&advanced_search"><i class="fa fa-fw fa-bookmark"></i> View all bookmarked items</a>
                    </div>
                  </div>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                  <div class="row">
                    <?php 
                      $bookmark_sql = "SELECT * FROM UKeepDAT.items_$user_code LEFT JOIN UKeepDAT.label_$user_code on UKeepDAT.items_$user_code.label = label_$user_code.label_id WHERE bookmark='1' AND `status`!='TRASH'";
                      $bookmark_result = mysql_query($bookmark_sql) or die(mysql_error());
                      $bookmark_numrows = mysql_num_rows($result);

                      while ($bres = mysql_fetch_array($bookmark_result)){
                        // color matching the badges
                        $badgecolor = $bres[16];

                        if ($bres[11] == "0"){
                          $priority = "None";
                          $priority_color = "secondary";
                        } elseif ($bres[11] == "1"){
                          $priority = "Low";
                          $priority_color = "info";
                        } elseif ($bres[11] == "2"){
                          $priority = "Medium";
                          $priority_color = "warning";
                        } elseif ($bres[11] == "3"){
                          $priority = "High";
                          $priority_color = "danger";
                        }

                        if ($bres[2] == "task" AND $bres[12] == "ACTIVE"){ // task and active
                          $icon = "fas fa-calendar-alt";
                        } elseif ($bres[2] == "note" AND $bres[12] == "ACTIVE"){ // note
                          $icon = "fas fa-sticky-note";
                        } else { // means it is a note/task, but archived
                          $icon = "fas fa-archive";
                        }

                        $Date = date_format(date_create($rws[5]),"l, d F Y, H:i");
                        $search_query = str_replace(' ', '+', $bres[3]);

                      // Item output while loop
                      ?>
                      <div class="col-lg-6 mb-4">
                        <div class="card text-dark shadow-lg">
                          <div class="card-body" onclick="location.href='items?search=<?php echo $search_query; ?>&normal_search'">
                            <h4><i class="<?php echo $icon; ?>"></i> <?php echo $bres[3]; ?></h4>
                            <div class="small"><?php echo substr($bres[4], 0, 100); ?> ...</div>
                              <div class="small">
                                <?php if ($bres[15] != ""){ ?>
                                <i>Label:</i> <span class="badge badge-<?php echo $badgecolor; ?>"><?php echo $bres[15]; ?></span>
                                <?php } if ($bres[2] == "task"){ ?>
                                <i>Priority:</i> <span class="badge badge-<?php echo $priority_color; ?>"><?php echo $priority; ?></span>
                                <?php } ?>
                              </div>
                          </div>
                        </div>
                      </div>
                    <?php } ?>
                  </div>
                </div>
              </div>