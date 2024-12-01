<footer class="ftcop-footer ftcop-section img" style="background-color: #4c5a7d; background-image: url('images/mapss.jpg'); background-size: cover; background-blend-mode: multiply; padding: 20px 0;">
  <div class="container">
    <div class="row mb-4">
      <div class="col-md-4 col-sm-12">
        <div class="ftcop-footer-widget">
          <p>Let your talents and achievements shine with a scholarship.</p>
          <ul class="ftcop-footer-social list-unstyled float-md-left float-lft mt-2">
            <li class="ftcop-animate"><a href="https://www.facebook.com/BNSCPAGE"><span class="icon-facebook"></span></a></li>
            <li class="ftcop-animate"><a href="https://www.youtube.com/channel/UCkjPm1v0oWecX_oEsX65W1w"><span class="icon-youtube"></span></a></li>
          </ul>
        </div>
      </div>

      <div class="col-md-4 col-sm-12">
        <div class="ftcop-footer-widget">
          <h2 class="ftcop-heading-2">Site Links</h2>
          <ul class="list-unstyled">
            <li><a href="index.php" class="py-1 d-block">Home</a></li>
            <li><a href="about.php" class="py-1 d-block">About</a></li>
            <li><a href="schemes.php" class="py-1 d-block">Scholarship</a></li>
            <li><a href="contact.php" class="py-1 d-block">Contact Us</a></li>
            <li><a href="admin/login.php" class="py-1 d-block">Admin</a></li>
          </ul>
        </div>
      </div>

      <div class="col-md-4 col-sm-12">
        <div class="ftcop-footer-widget">
          <h2 class="ftcop-heading-2">Contact Information</h2>
          <div class="block-23">
            <ul>
              <?php
              $sql="SELECT * from tblpage where PageType='contactus'";
              $query = $dbh -> prepare($sql);
              $query->execute();
              $results=$query->fetchAll(PDO::FETCH_OBJ);

              if($query->rowCount() > 0) {
                foreach($results as $row) { ?>
                  <li><a href="mailto:info@bnsc.edu.ph"><span class="icon icon-envelope"></span><span class="text"><?php echo htmlentities($row->Email); ?></span></a></li>
                  <li><a href="index.php"><span class="icon icon-globe"></span><span class="text"><?php echo htmlentities($row->website_links); ?></span></a></li>
                  <li><a href="http://tiny.cc/pv2rzz" target="_blank"><span class="icon icon-map-marker"></span><span class="text"><?php echo htmlentities($row->Address); ?></span></a></li>
                  <li><span class="icon icon-clock-o"></span><span class="text"><?php echo htmlentities($row->PageDescription); ?></span></li>
                  <li><span class="icon icon-phone"></span><span class="text">+<?php echo htmlentities($row->MobileNumber); ?></span></li>
              <?php } } ?>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 text-center">
        <p class="footer-company-name">COPYRIGHT © 2024 SCHOLARSHIPS MANAGEMENT SYSTEM </p>
      </div>
    </div>
  </div>
</footer>

<style>
  /* Footer Styles */
  .ftcop-footer {
    color: #fff;
    padding: 20px 0;
  }

  .ftcop-footer h2 {
    font-size: 18px;
    margin-bottom: 10px; /* Reduced margin */
  }

  .ftcop-footer p {
    font-size: 14px;
    margin-bottom: 10px;
  }

  .ftcop-footer ul {
    list-style: none;
    padding-left: 0;
  }

  .ftcop-footer ul li {
    margin-bottom: 5px; /* Adjusted margin */
  }

  .ftcop-footer a {
    color: #ddd;
    text-decoration: none;
  }

  .ftcop-footer a:hover {
    color: black;
  }

  .ftcop-footer-social {
    margin-top: 5px; /* Reduced margin */
  }

  .ftcop-footer-social li {
    display: inline-block;
    margin-right: 5px; /* Reduced margin */
  }

  .icon {
    margin-right: 5px;
  }

  @media (max-width: 768px) {
    .ftcop-footer {
      padding: 15px 0;
    }

    .ftcop-footer p {
      font-size: 13px;
    }

    .ftcop-footer h2 {
      font-size: 16px;
    }
  }  

  @media (max-width: 576px) {
    .ftcop-footer {
      text-align: left;
    }
  }
</style>