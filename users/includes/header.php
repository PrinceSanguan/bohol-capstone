<header class="topbar-nav">
  <nav class="navbar navbar-expand fixed-top">
    <ul class="navbar-nav mr-auto align-items-center">
      <li class="nav-item">
        <a class="nav-link toggle-menu" href="javascript:void();">
          <i class="icon-menu menu-icon"></i>
        </a>
      </li>
    </ul>

    <ul class="navbar-nav align-items-center right-nav-link">
      <li class="nav-item dropdown-lg">
        <?php 
        $uid = $_SESSION['uid'];
        // Include pending applications along with approved and rejected ones
        $sql = "SELECT * FROM tblapply WHERE (Status='Approved' OR Status='Rejected' OR Status='Pending') AND UserID='$uid'";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        $statusCount = $query->rowCount();
        ?>
        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();">
          <i class="fa fa-bell-o"></i>(<?php echo htmlentities($statusCount); ?>)
        </a>
        <ul class="dropdown-menu dropdown-menu-right">
          <?php foreach ($results as $row) { ?>
            <li class="dropdown-item">
              <a href="view-application-status.php?viewid=<?php echo htmlentities($row->ID); ?>" class="dropdown-item">
                <!-- Display the status and application number -->
                Status: <?php echo htmlentities($row->Status); ?> (<?php echo htmlentities($row->ApplicationNumber); ?>)
              </a>
            </li>
          <?php } ?>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
          <?php 
          $sql = "SELECT Photo FROM tbluser WHERE ID = :uid";
          $query = $dbh->prepare($sql);
          $query->bindParam(':uid', $uid, PDO::PARAM_STR);
          $query->execute();
          $user = $query->fetch(PDO::FETCH_OBJ);
          $img = $user->Photo;
          ?>
          <span class="user-profile"><img src="../uploads/<?php echo $img; ?>" class="img-circle" alt="user avatar"></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-right">
          <li class="dropdown-item user-details">
            <a href="javascript:void();">
              <div class="media">
                <div class="avatar"><img class="align-self-start mr-3" src="../uploads/<?php echo $img; ?>" alt="user avatar"></div>
                <div class="media-body">
                  <?php
                  $sql = "SELECT FirstName, MiddleName, LastName, Email FROM tbluser WHERE ID=:uid";
                  $query = $dbh->prepare($sql);
                  $query->bindParam(':uid', $uid, PDO::PARAM_STR);
                  $query->execute();
                  $results = $query->fetchAll(PDO::FETCH_OBJ);
                  if ($query->rowCount() > 0) {
                    foreach ($results as $row) {
                      ?>
                      <h6 class="mt-2 user-title"><?php echo htmlentities($row->FirstName); ?></h6>
                      <h6 class="mt-2 user-title"><?php echo htmlentities($row->MiddleName); ?></h6>
                      <h6 class="mt-2 user-title"><?php echo htmlentities($row->LastName); ?></h6>
                      <p class="user-subtitle"><?php echo htmlentities($row->Email); ?></p>
                    <?php }
                  } ?>
                </div>
              </div>
            </a>
          </li>
          <li class="dropdown-divider"></li>
          <a href="setting.php">
            <li class="dropdown-item"><i class="icon-settings mr-2"></i> Setting</li>
          </a>
          <li class="dropdown-divider"></li>
          <a href="logout.php">
            <li class="dropdown-item"><i class="icon-power mr-2"></i> Logout</li>
          </a>
        </ul>
      </li>
    </ul>
  </nav>
</header>
