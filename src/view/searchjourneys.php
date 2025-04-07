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
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    var storedSearch = localStorage.getItem('inputSearch');
    if (storedSearch) {
        $("#search").val(storedSearch);
        handleSearch(storedSearch);
    }
    $("#search").keyup(function () {
        var query = $(this).val();
        localStorage.setItem('inputSearch', query);
        handleSearch(query);
    });

    function handleSearch(query) {
        $.get("<?= BASE_URL . "api/journey/search" ?>", {
            query: query
        }, function (data) {
            $("#journeys").empty();
            data.forEach(element => {
                var title = element.title.length > 83 ? element.title.substring(0, 80) + '...' : element.title;
                var description = element.description.length > 113 ? element.description.substring(0, 110) + '...' : element.description;
                var pic = element.picture.length == 0 ? "https://live.staticflickr.com/750/32191464373_e8864ab8bd_b.jpg" : element.picture;
                $("#journeys").append(
                    $('<div class="container-journey">').append(
                        $('<a>').attr('href', '<?= BASE_URL ?>journey?id=' + element.id).append(
                            $('<img>').attr('src', pic),
                            $('<h3>').text(title),
                            $('<p>').text(description)
                        )
                    )
                );
            });
        });
    }
});

</script>
  </head>
  <body>
    <div id="root">
    <?php include("view/menu.php"); 
        ?>
      <div id="main">
        <?php
        if(isset($_SESSION['user_name']))
          echo "<header>What do you want to search, ".$_SESSION['user_name']."?</header>";
        else
          echo "<header>What do you want to search?</header>";
        ?>
        <div id="searchbar">
        <input id="search" type="text" name="query" placeholder="Search" autocomplete="off" autofocus />
        </div>
        <div class="container" id="journeys">
        </div>
      </div>
    </div>
  </body>
</html>
