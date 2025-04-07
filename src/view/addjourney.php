<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "style.css" ?>">
    <link rel="stylesheet" type="text/css" href="<?= CSS_URL . "addjourney.css" ?>">
    <link rel="icon" type="image/x-icon" href="<?= IMAGES_URL . "favicon.ico" ?>">
    <title>Journee | Add journey</title>
    <script src="<?= JS_URL . "journey.js" ?>"></script>
  </head>
  <body>
    <div id="root">
    <?php include("view/menu.php"); ?>
      <form action="<?= BASE_URL . "journey/add" ?>" method="post"  enctype="multipart/form-data">
        <div id="main">
          <header>Add your journey</header>

          <div id="journeyname">
            <input
              id="text-name"
              name="title"
              type="text"
              placeholder="Journey name (required)"
              value="<?= isset($journey['title']) ? $journey['title'] : ''?>"
              required
            />
            
          </div>
          <p class="important"><?= $errors["title"] ?></p>
          <div id="journeydesc">
            <textarea
              id="text-desc"
              name="description"
              cols="30"
              rows="10"
              placeholder="Journey description (required)"
              required
            ><?= isset($journey['description']) ? $journey['description'] : ''?></textarea>
          </div>
          <p class="important"><?= $errors["description"] ?></p>
          <div id="imageurl">
            <input
              id="text-img"
              type="text"
              name="picture_url"
              value="<?= isset($journey['picture_url']) ? $journey['picture_url'] : ''?>"
              placeholder="Journey image - URL (not required)"
            />
          </div>
          <p class="important"><?= $errors["picture_url"] ?></p>
          <div><p id="or">OR</p></div>
          <div>
            <label for="file-upload" id="imageupload">Upload image</label>
            <input
              id="file-upload"
              name="picture_data"
              type="file"
              accept="image/*"
            />
            </div>
            <div>
              <span id="text"></span>
            </div>
            <p class="important"><?= $errors["upload"] ?></p>
          <div id="postupload">
            <input type="submit" id="upload" value="UPLOAD" />
          </div>
        </div>
      </form>
    </div>
  </body>
</html>
