<nav class="navbar navbar-expand-lg navbar-dark bg-custom ftco-navbar-light" id="ftco-navbar">
  
    <div class="d-flex align-items-center">
      <!-- First Logo -->
      <a class="navbar-brand mr-2" href="index.php">
        <img src="images/mlogo.png" alt="First Logo" style="height: 59px;"> <!-- First logo -->
      </a>
      
      <!-- Second Logo -->
      <a class="navbar-brand ml-8" href="index.php"> <!-- Add margin-left to separate logos -->
        <img src="images/saslogo.png" alt="Second Logo" style="height: 69px;"> <!-- Second logo -->
      </a>
    </div>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="oi oi-menu"></span> Menu
    </button>

    <div class="collapse navbar-collapse" id="ftco-nav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
        <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
        <li class="nav-item"><a href="schemes.php" class="nav-link">Scholarships</a></li>
        <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
        <li class="nav-item mr-5"><a href="admin/login.php" class="nav-link">Admin</a></li>
     
      </ul>
    </div>

</nav>

<style>
  /* Custom styles for the new background color */
  .bg-custom {
    background-color: rgba(76, 90, 125, 1.0) !important; /* New RGBA color */
  }

  .navbar-brand img {
    height: 50px; /* Set height for the logo image */
    max-height: 100%; /* Ensure image fits within the navbar */
  }

  /* Style for nav items */
  .nav-link {
    color: white !important; /* Change text color to white */
    font-weight: bold; /* Make text bold */
    font-size: 18px; /* Increase font size */
    transition: color 0.3s ease; /* Smooth transition for hover effect */
  }

  /* Hover effect for nav items */
  .nav-link:hover {
    color: black !important; /* Change text color on hover (e.g., gold) */
  }

  /* Adjust logo size for smaller screens */
  @media (max-width: 768px) {
    .navbar-brand img {
      height: 40px; /* Smaller logo for mobile */
    }

    .nav-link {
      font-size: 16px; /* Adjust font size for smaller screens */
    }
  }
</style>
