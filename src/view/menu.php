<div id="navbar-container">
      <nav id="navbar">
        <div class="menu-icon" onclick="toggleNavbar()">
          &#9776; <!-- Hamburger icon -->
        </div>
        <div id="menu-links">
          <a href="<?= BASE_URL . 'journey' ?>">Home</a>
          <a href="<?= BASE_URL . 'journey/add' ?>">Add journey</a>
          <a href="<?= BASE_URL . 'journey/search' ?>">Search</a>
          <a href="<?= BASE_URL . 'about' ?>">About</a>
          <?php 
          if(isset($_SESSION['user_id'])){
            echo '<a href="'.BASE_URL.'user/logout">Logout</a>';
          }
          else{
            echo '<a href="'.BASE_URL.'user/login">Login</a>';
          }
          ?>
        </div>
      </nav>
    </div>
    <script>
    function toggleNavbar() {
        const navbar = document.getElementById('navbar');
        navbar.classList.toggle('menu-active');
      }
    </script>