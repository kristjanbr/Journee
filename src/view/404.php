<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "home.css" ?>">
    <link rel="icon" type="image/x-icon" href="<?= IMAGES_URL . "favicon.ico" ?>">
    <title>Journee | 404</title>
    <script src="js/home.js"></script>
  </head>
  <body>
    <div id="root">
    <?php include("view/menu.php"); ?>
      <div id="main">
        <div id="notfound">
          <h1>404</h1>
          <p>Oh no! The page could not be found.</p>
          <a href="<?= BASE_URL . "journey" ?>">Go back home</a>
        </div>
      </div>
    </div>
  </body>
</html>
