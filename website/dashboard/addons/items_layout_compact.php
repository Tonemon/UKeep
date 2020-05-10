<?php 
                      while ($rws = mysql_fetch_array($result)){
                        // color matching the badges
                        $badgecolor = $rws[16];

                        if ($rws[11] == "0"){
                          $priority = "No priority";
                          $priority_color = "secondary";
                        } elseif ($rws[11] == "1"){
                          $priority = "Low priority";
                          $priority_color = "info";
                        } elseif ($rws[11] == "2"){
                          $priority = "Medium priority";
                          $priority_color = "warning";
                        } elseif ($rws[11] == "3"){
                          $priority = "High priority";
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
                        $Date = date_format(date_create($rws[5]),"l, d F Y, H:i");

                      // Item output while loop
                      ?>

                        <div class="col-lg-12">
                          <?php if ($rws[10] == "1"){ ?>
                          <div class="card product-chooser-item text-<?php echo $theme_color; ?> shadow-lg">
                          <?php } else { ?>
                          <div class="card product-chooser-item text-dark shadow-lg">
                          <?php } ?>
                            <div class="card-body">

                              <i class="<?php echo $icon; ?>"></i>
                              <span class="name" style="min-width: 180px; display: inline-block;"><?php echo mb_strimwidth($rws[3], 0, 22, "..."); ?></span>
                              <?php if ($rws[2] == "note"){ ?>
                                <span class="" style="font-size: 11px;"><?php echo mb_strimwidth($rws[4], 0, 140, "..."); ?></span>
                              <?php } elseif ($rws[2] == "task"){ ?>
                                <span class="" style="font-size: 11px;"><?php echo mb_strimwidth($rws[4], 0, 120, "..."); ?></span>
                                <span class="badge badge-<?php echo $priority_color; ?>" style="font-size: 11px;"><?php echo $priority; ?></span>
                                  
                                  <?php } else {} ?>

                            
                            <span class="float-right">
                              <?php if ($rws[2] == "task"){ ?>
                                <span class="badge badge-secondary">Before: <?php echo $Date; ?></span></b>
                              <?php } ?>
                              <span class="badge badge-<?php echo $badgecolor; ?>"><?php echo $rws[15]; ?></span>
                            </span>

                              <input type="radio" name="item_id" value="<?php echo $rws[0]; ?>">
                            </div>
                          </div>
                        </div>
                      <?php } ?>