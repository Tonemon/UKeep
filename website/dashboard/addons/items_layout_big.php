<?php 
                      while ($rws = mysql_fetch_array($result)){
                        // color matching the badges
                        $badgecolor = $rws[16];

                        if ($rws[11] == "0"){
                          $priority = "None";
                          $priority_color = "secondary";
                        } elseif ($rws[11] == "1"){
                          $priority = "Low";
                          $priority_color = "info";
                        } elseif ($rws[11] == "2"){
                          $priority = "Medium";
                          $priority_color = "warning";
                        } elseif ($rws[11] == "3"){
                          $priority = "High";
                          $priority_color = "danger";
                        }

                        if ($rws[10] == "1"){ // bookmarked
                          $icon = "fas fa-bookmark";
                        } elseif ($rws[2] == "task" AND $rws[12] == "ACTIVE"){ // task and active
                          $icon = "fas fa-calendar-alt";
                        } elseif ($rws[2] == "note" AND $rws[12] == "ACTIVE"){ // note
                          $icon = "fas fa-sticky-note";
                        } else { // means it is a note/task, but archived
                          $icon = "fas fa-archive";
                        }

                        // making date readable
                        $Date = date_format(date_create($rws[6]),"l, d F Y, H:i");

                      // Item output while loop
                      ?>

                        <div class="col-lg-6 mb-4">
                          <?php if ($rws[10] == "1"){ ?>
                          <div class="card product-chooser-item text-<?php echo $theme_color; ?> shadow-lg">
                          <?php } else { ?>
                          <div class="card product-chooser-item text-dark shadow-lg">
                          <?php } ?>
                            <div class="card-body">
                              <h4><i class="<?php echo $icon; ?>"></i> 
                                <?php
                                  echo $rws[3];

                                  if ($rws[12] == "ARCHIVED"){ // add '[archived]' text if item is archived
                                    echo ' <small><small><small>[ARCHIVED]</small></small></small>';
                                  }

                                  ?>
                              </h4>
                              <div class="small"><?php echo substr($rws[4], 0, 100); ?> ...</div>
                                <div class="small"><br>
                                  <?php if ($rws[15] != "") { ?>
                                  <i>Label:</i> <span class="badge badge-<?php echo $badgecolor; ?>"><?php echo $rws[15]; ?></span>
                                  <?php } if ($rws[2] == "task"){ ?>
                                  <i>Priority:</i> <span class="badge badge-<?php echo $priority_color; ?>"><?php echo $priority; ?></span>
                                  <i>Before:</i> <b><?php echo $Date; ?></b>
                                  <?php } ?>
                                </div>
                              <input type="radio" name="item_id" value="<?php echo $rws[0]; ?>">
                            </div>
                          </div>
                        </div>
                      <?php } ?>