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
                // Query for new applications
                $sql = "SELECT tblapply.ID as appid, ApplicationNumber FROM tblapply WHERE Status = 'Pending'";
                $query = $dbh->prepare($sql);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $newapp = $query->rowCount();
                ?>
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();">
                    <i class="fa fa-bell-o"></i>(<?php echo htmlentities($newapp); ?>)
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <?php foreach ($results as $row) { ?>
                        <li class="dropdown-item">
                            <a href="view-application.php?viewid=<?php echo htmlentities($row->appid); ?>">New Application (<?php echo htmlentities($row->ApplicationNumber); ?>)</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
                    <span class="user-profile">
                        <?php 
                        // Fetch the admin's profile image
                        $aid = $_SESSION['aid'];
                        $sql = "SELECT Photo FROM tbladmin WHERE ID = :aid"; // Change 'ProfilePhoto' to your actual column name for the image
                        $query = $dbh->prepare($sql);
                        $query->bindParam(':aid', $aid, PDO::PARAM_STR);
                        $query->execute();
                        $result = $query->fetch(PDO::FETCH_OBJ);
                        $img = $result ? $result->Photo : 'default-avatar.png'; // Fallback image if not found
                        ?>
                        <img src="../uploads/<?php echo htmlspecialchars($img); ?>" class="img-circle" alt="Admin">
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li class="dropdown-item user-details">
                        <a href="javaScript:void();">
                            <div class="media">
                                <div class="avatar">
                                    <img class="align-self-start mr-3" src="../uploads/<?php echo htmlspecialchars($img); ?>" alt="Admin avatar">
                                </div>
                                <div class="media-body">
                                    <?php
                                    // Fetch the admin's name and email
                                    $sql = "SELECT AdminName, Email FROM tbladmin WHERE ID = :aid";
                                    $query = $dbh->prepare($sql);
                                    $query->bindParam(':aid', $aid, PDO::PARAM_STR);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);

                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $row) {
                                            ?>
                                            <h6 class="mt-2 user-title"><?php echo htmlentities($row->AdminName); ?></h6>
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
