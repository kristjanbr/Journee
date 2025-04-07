<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "home.css" ?>">
    <link rel="icon" type="image/x-icon" href="<?= IMAGES_URL . "favicon.ico" ?>">
    <title>Journee | 401</title>
    <script src="js/home.js"></script>
  </head>
  <body>
    <div id="root">
    <?php include("view/menu.php"); ?>
      <div id="main">
        <div id="notfound">
          <h1>401</h1>
          <p>You are unauthorized to perform this action.</p>
          <a href="<?= BASE_URL . "user/login" ?>">Login first.</a>
        </div>
      </div>
    </div>
  </body>
</html>
