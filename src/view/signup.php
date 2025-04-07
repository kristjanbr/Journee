<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "login.css" ?>">
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
    <link rel="icon" type="image/x-icon" href="<?= IMAGES_URL . "favicon.ico" ?>">
    <title>Journee | Signup</title>
  </head>
  <body>
    <div id="root">
    <?php include("view/menu.php"); ?>
    <form action="<?= BASE_URL . "user/signup" ?>" method="post">
      <div id="main">
        <header>Signup:</header>
        <div >
            <input
              id="name"
              name="name"
              type="text"
              placeholder="First name"
              value="<?= $data['name']?>"
              required
            />
        </div>
        <div >
            <input
              id="surname"
              name="surname"
              type="text"
              placeholder="Last name"
              value="<?= $data['surname']?>"
              required
            />
        </div>
          <div id="field-username">
            <input
              id="username"
              name="username"
              type="text"
              placeholder="Username"
              value="<?= $data['username']?>"
              required
            />
        </div>
        <?php
        if(isset($usernameError))
          echo "<p class=\"important\">".$usernameError."</p>"
        ?>
        <div >
              <input
                id="email"
                name="email"
                type="email"
                placeholder="E-mail address"
                value="<?= $data['email']?>"
                required
              />
          </div>
          <?php
          if(isset($mailError))
            echo "<p class=\"important\">".$mailError."</p>"
          ?>
        <div id="field-pass">
            <input
              id="password"
              name="password"
              type="password"
              placeholder="Password"
              required
            />
        </div>
        <div id="field-pass">
            <input
              id="passwordconfirm"
              name="passwordconfirm"
              type="password"
              placeholder="Confirm password"
              required
            />
        </div>
        <?php
          if(isset($passError))
            echo "<p class=\"important\">".$passError."</p>"
          ?>
        <div>
            <input type="submit" id="signup" value="SIGN UP" />
          </div>
          <div>
            <p>Already have an account? <a href="<?= BASE_URL . "user/login" ?>">Log in now!</a></p>
          </div>
      </div>
      </form>
    </div>
  </body>
</html>
