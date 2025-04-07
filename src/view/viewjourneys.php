<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "home.css" ?>">
    <link rel="icon" type="image/x-icon" href="<?= IMAGES_URL . "favicon.ico" ?>">
    <title>Journee | Home</title>
    <script src="<?= JS_URL . "home.js" ?>"></script>
  </head>
  <body>
    <div id="root">
    <?php include("view/menu.php"); 
        ?>
      <div id="main">
        <?php
        if(isset($_SESSION['user_name']))
          echo "<header>What will you be reading today, ".$_SESSION['user_name']."?</header>";
        else
          echo "<header>What will you be reading today?</header>";
        ?>
        <div class="container">
        <?php foreach ($journeys as $journey): ?>
          <div class="container-journey">
            <a href="<?= BASE_URL . "journey?id=" . $journey["id"] ?>">
              <img src="<?= $journey["picture"] ?>">
              <h3><?= strlen($journey["title"]) > 83 ? substr(htmlspecialchars($journey["title"]),0,80). "..." : htmlspecialchars($journey["title"]) ?></h3>
              <p><?= strlen($journey["description"]) > 113 ? substr(htmlspecialchars($journey["description"]),0,110). "..." : htmlspecialchars($journey["description"]) ?></p>
            </a>
          </div>
        <?php endforeach; ?>
        </div>
      </div>
    </div>
  </body>
</html>
