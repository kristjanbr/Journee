<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "login.css" ?>">
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
    <link rel="icon" type="image/x-icon" href="<?= IMAGES_URL . "favicon.ico" ?>">
    <title>Journee | Login</title>
  </head>
  <body>
    <div id="root">
    <?php include("view/menu.php"); ?>
    <form action="<?= BASE_URL . "user/login" ?>" method="post">
      <div id="main">
        <header>Login:</header>
          <div id="field-username">
            <input
              id="username"
              name="username"
              type="text"
              placeholder="Username"
              required
            />
        </div>
        <div id="field-pass">
            <input
              id="password"
              name="password"
              type="password"
              placeholder="Password"
              required
            />
        </div>
        <div>
            <input type="submit" id="login" value="LOGIN" />
          </div>
          <p class="important"><?= $errorMessage?></p>
          <div>
            <p>Don't have an account? <a href="<?= BASE_URL . "user/signup" ?>">Sign up now!</a></p>
          </div>
      </div>
      </form>
    </div>
  </body>
</html>
