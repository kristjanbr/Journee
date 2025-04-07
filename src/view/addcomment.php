<form class="container" action="<?= BASE_URL . "comment/add" ?>" method="post">
          <div class="datacomment">
            <p class="textcommentauthor">Add new comment:</p>
            <textarea name="comment" id="comment"></textarea>
            <p class="important"><?= $errors['comment']?></p>
            <input type="hidden" name="id" value="<?= $journey['id']?>" />
            <div id="commentbtn"><input type="submit" value="POST"></div>
          </div>
        </form>