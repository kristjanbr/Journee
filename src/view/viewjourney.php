<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "view.css" ?>">
    <link rel="icon" type="image/x-icon" href="<?= IMAGES_URL . "favicon.ico" ?>">
    <title>Journee | View journey</title>
    <script src="<?= JS_URL . "view.js" ?>"></script>
  </head>
  <body>
    <div id="root">
    <?php include("view/menu.php"); ?>
      <div id="main">
        <div class="container">
          <div class="data">
            <img id="img" src="<?= $journey["picture"] ?>" alt="" />
            <br />
            <span id="header"><?= htmlspecialchars($journey["title"]) ?></span>
            <p class="textauthor">Author: <?= $journey["name"] . " " .  $journey["surname"] . " (@" . $journey["username"]. ")" ?></p>
            <p class="textauthor">Posted: <?= $journey["postTimestamp"] ?></p>
            <p id="text"><?= nl2br(htmlspecialchars($journey["description"])) ?></p>
            <?php
            if (isset($_SESSION['user_id']) && $journey['userid']==$_SESSION['user_id']){
              echo("
                  <div class=\"edit_delete\">
                  <a class=\"edit\" href=\"".BASE_URL."journey/edit?id=".$journey['id']."\"></a>
                  <a class=\"delete\" href=\"".BASE_URL."journey/delete?id=".$journey['id']."\" onclick=\"return confirmDeletionPost(event)\"></a>
                </div>
              ");
            }
            ?>
          </div>
        </div>
        <?php if (isset($_SESSION['user_id'])) include("view/addcomment.php"); ?>
        <?php foreach ($comments as $comment): ?>
        <div class="container">
          <form class="datacomment" action="<?= BASE_URL . "comment/delete" ?>"method="post" onsubmit="confirmDeletionComment(event)">
            <span class="textcommentauthor"><?= $comment['username']?> @ <?= $comment['commenttimestamp']?></span>
            <p class=""><?= $comment['comment']?></p>
            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id']===$comment['userid']) echo "<input class=\"delbtn\" type=\"submit\" value=\"DELETE\">"; ?>
            <input type="hidden" name="id" value="<?= $comment['id']?>" />
        </form>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </body>
</html>
