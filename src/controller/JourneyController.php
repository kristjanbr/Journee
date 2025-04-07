<?php

require_once("model/JourneyDB.php");
require_once("model/CommentDB.php");
require_once("ViewHelper.php");
require_once("static/config.php");
class JourneyController {

    public static function index() {
        if (isset($_GET["id"])) {
            $journey = JourneyDB::get($_GET["id"]);
            if ($journey === false)
                ViewHelper::render("view/404.php");
            else{
                $errors["comment"] = "";
                
                $comments = CommentDB::getAllForJourney($_GET["id"]);
                ViewHelper::render("view/viewjourney.php", ["journey" => $journey, "errors" => $errors, "comments" => $comments]);
            }
        } else {
            ViewHelper::render("view/viewjourneys.php", ["journeys" => JourneyDB::getAll()]);
        }
    }

    public static function search() {
        ViewHelper::render("view/searchjourneys.php");
    }

    public static function searchApi() {
        if (isset($_GET["query"]) && !empty($_GET["query"])) {
            $hits = JourneyDB::search($_GET["query"]);
        } else {
            $hits = [];
        }

        header('Content-type: application/json; charset=utf-8');
        echo json_encode($hits);
    }

    // public static function search() {
    //     if (isset($_GET["query"])) {
    //         $query = $_GET["query"];
    //         $hits = JourneyDB::search($query);
    //     } else {
    //         $query = "";
    //         $hits = [];
    //     }

    //     ViewHelper::render("view/book-search.php", ["hits" => $hits, "query" => $query]);
    // }

    // Function can be called without providing arguments. In such case,
    // $data and $errors paramateres are initialized as empty arrays
    public static function showAddForm($data = [], $errors = []) {
        // If $data is an empty array, let's set some default values
        // if (empty($data)) {
        //     $data = [
        //         "author" => "",
        //         "title" => "",
        //         "description" => "",
        //         "price" => 0,
        //         "year" => date("Y"),
        //         "quantity" => 10
        //     ];
        // }

        // If $errors array is empty, let's make it contain the same keys as
        // $data array, but with empty values

        if(!isset($_SESSION['user_id'])){
            ViewHelper::render("view/401.php");
        }
        else{
            if (empty($errors)) {
                $errors = [
                    "title" => "",
                    "description" => "",
                    "picture_url" => "",
                    "upload" => ""
                ];
            }

            $vars = ["journey" => $data, "errors" => $errors];
            ViewHelper::render("view/addjourney.php", $vars);
        }
    }

    public static function add() {
        if(!isset($_SESSION['user_id'])){
            ViewHelper::render("view/401.php");
        }
        else{
            $rules = [
                // we convert HTML special characters
                "title" => FILTER_DEFAULT,
                "description" => FILTER_DEFAULT,
                "picture_url" => FILTER_VALIDATE_URL
            ];
            // Apply filter to all POST variables; from here onwards we never
            // access $_POST directly, but use the $data array
            $data = filter_input_array(INPUT_POST, $rules);

            $errors["title"] = empty($data["title"]) ? "Provide the journey title." : "";
            $errors["description"] = empty($data["description"]) ? "Provide the journey description." : "";
            $errors["upload"] = "";
            $errors["picture_url"] = "";
            
            $pic_data = $_FILES['picture_data'];
            if($pic_data['name']==='' && $_POST["picture_url"]!==''){
                $errors["picture_url"] = $data["picture_url"] === false ? "Invalid image URL." : "";
            }

            // Is there an error?
            $isDataValid = true;
            foreach ($errors as $error) {
                $isDataValid = $isDataValid && empty($error);
            }
            
            if ($isDataValid) {

                if ($pic_data['name']!==''){
                    $tmp_path = $pic_data["tmp_name"];
                    
                    $imgbb_url = "https://api.imgbb.com/1/upload?key=".APIKEY;

                    $pic_64_data = base64_encode(file_get_contents($tmp_path));
                    $post_fields = [
                        'image' => $pic_64_data
                    ];

                    $ch = curl_init();

                    // Configure cURL options
                    curl_setopt($ch, CURLOPT_URL, $imgbb_url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    $response = curl_exec($ch);
                    $response_data = json_decode($response, true);
                    if (isset($response_data['data']['url'])) {
                        $image_url = $response_data['data']['url'];
                        JourneyDB::insert($data["title"], $data["description"], 
                        $image_url, $_SESSION['user_id']);
                        ViewHelper::redirect(BASE_URL . "journey");
        
                    } else {
                        $errors["upload"] = "Error uploading image. Try again, or provide URL.";
                        self::showAddForm($data, $errors);
                    }
                }
                else{
                    JourneyDB::insert($data["title"], $data["description"], 
                        $data["picture_url"], $_SESSION['user_id']);
                    ViewHelper::redirect(BASE_URL . "journey");
                }
            } else {
                self::showAddForm($data, $errors);
            }
        }
    }

    public static function showEditForm($journey = [], $errors = []) {
        if (!isset($_GET["id"])){
            ViewHelper::render("view/403.php");
            exit;
        }
        $journey = JourneyDB::get($_GET["id"]);
        if ($journey === false)
            ViewHelper::render("view/404.php");
        else if (isset($_SESSION['user_id']) && $journey['userid']===$_SESSION['user_id']){
            if (empty($errors)) {
                $errors = [
                    "title" => "",
                    "description" => "",
                    "picture_url" => "",
                    "upload" => ""
                ];
            }
            ViewHelper::render("view/editjourney.php", ["journey" => $journey, "errors" => $errors]);
        }
        else{
            ViewHelper::render("view/403.php");
        }

        
    }    

    public static function edit() {
        $rules = [
            // we convert HTML special characters
            "title" => FILTER_DEFAULT,
            "description" => FILTER_DEFAULT,
            "picture_url" => FILTER_VALIDATE_URL,
            "id" => [
                "filter" => FILTER_CALLBACK,
                "options" => function ($value) { return (is_numeric($value) && $value > 0) ? floatval($value) : false; }
            ]
        ];
        $data = filter_input_array(INPUT_POST, $rules);

        $errors["title"] = empty($data["title"]) ? "Provide the journey title." : "";
        $errors["description"] = empty($data["description"]) ? "Provide the journey description." : "";
        $errors["upload"] = "";
        $errors["picture_url"] = "";
        $errors["id"] = $data["id"] === false ? "ID should be positive." : "";

        if(!$data['id']){
            self::showAddForm($data, $errors);
            exit;
        }

        $journey = JourneyDB::get($data["id"]);
        if(!isset($_SESSION['user_id'])){
            ViewHelper::render("view/401.php");
        }
        else if ($journey['userid']!==$_SESSION['user_id']){
            ViewHelper::render("view/403.php");
        }
        else{
            $pic_data = $_FILES['picture_data'];
            if($pic_data['name']==='' && $_POST["picture_url"]!==''){
                $errors["picture_url"] = $data["picture_url"] === false ? "Invalid image URL." : "";
            }

            // Is there an error?
            $isDataValid = true;
            foreach ($errors as $error) {
                $isDataValid = $isDataValid && empty($error);
            }
            
            if ($isDataValid) {

                if ($pic_data['name']!==''){
                    $tmp_path = $pic_data["tmp_name"];
                    
                    $imgbb_url = "https://api.imgbb.com/1/upload?key=".APIKEY;

                    $pic_64_data = base64_encode(file_get_contents($tmp_path));
                    $post_fields = [
                        'image' => $pic_64_data
                    ];

                    $ch = curl_init();

                    // Configure cURL options
                    curl_setopt($ch, CURLOPT_URL, $imgbb_url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    $response = curl_exec($ch);
                    $response_data = json_decode($response, true);
                    if (isset($response_data['data']['url'])) {
                        $image_url = $response_data['data']['url'];
                        JourneyDB::update($data["title"], $data["description"], 
                        $image_url, $data["id"]);
                        ViewHelper::redirect(BASE_URL . "journey?id=" . $data["id"]);
        
                    } else {
                        $errors["upload"] = "Error uploading image. Try again, or provide URL.";
                        self::showAddForm($data, $errors);
                    }
                }
                else{
                    JourneyDB::update($data["title"], $data["description"], 
                        $_POST["picture_url"], $data["id"]);
                    ViewHelper::redirect(BASE_URL . "journey?id=" . $data["id"]);
                }
            } else {
                self::showAddForm($data, $errors);
            }
        }
        
    }

    public static function delete() {
        $rules = [
            "id" => [
                "filter" => FILTER_VALIDATE_INT,
                "options" => ["min_range" => 1]
            ]
        ];
        $data = filter_input_array(INPUT_GET, $rules);
        
        if(!$data['id']){
            ViewHelper::render("view/403.php");
            exit;
        }

        $errors["id"] = $data["id"] === null ? "Invalid ID" : "";

        $journey = JourneyDB::get($data["id"]);
        if(!isset($_SESSION['user_id'])){
            ViewHelper::render("view/401.php");
        }
        else if ($journey === false)
            ViewHelper::render("view/404.php");
        else if ($journey['userid']!==$_SESSION['user_id']){
            ViewHelper::render("view/403.php");
        }
        else{
            $isDataValid = true;
            foreach ($errors as $error) {
                $isDataValid = $isDataValid && empty($error);
            }

            if ($isDataValid) {
                CommentDB::deleteAll($data["id"]);
                JourneyDB::delete($data["id"]);
                $url = BASE_URL . "journey";
            } else {
                if ($data["id"] !== null) {
                    $url = BASE_URL . "journey/edit?id=" . $data["id"];
                } else {
                    $url = BASE_URL . "journey";
                }
            }
            ViewHelper::redirect($url);
        }
        
    }

    public static function comment() {
        $rules = [
            "comment" => FILTER_SANITIZE_SPECIAL_CHARS,
            "id" => [
                "filter" => FILTER_VALIDATE_INT,
                "options" => ["min_range" => 1]
            ]
        ];
        $data = filter_input_array(INPUT_POST, $rules);
        
        if(!isset($data) || !$data['id']){
            ViewHelper::render("view/403.php");
            exit;
        }

        $errors["id"] = $data["id"] === null ? "Invalid ID" : "";
        $errors["comment"] = empty($data["comment"]) ? "Comment cannot be empty." : "";

        $journey = JourneyDB::get($data["id"]);
        if(!isset($_SESSION['user_id'])){
            ViewHelper::render("view/401.php");
        }
        else if ($journey === false)
            ViewHelper::render("view/404.php");
        else{
            $isDataValid = true;
            foreach ($errors as $error) {
                $isDataValid = $isDataValid && empty($error);
            }

            if ($isDataValid) {
                CommentDB::insert($data["id"],$_SESSION["user_id"],$data["comment"]);
            }

            ViewHelper::redirect(BASE_URL . "journey/?id=" . $data["id"], $errors);
        }
        
    }


    public static function deleteComment() {
        $rules = [
            "id" => [
                "filter" => FILTER_VALIDATE_INT,
                "options" => ["min_range" => 1]
            ]
        ];
        $data = filter_input_array(INPUT_POST, $rules);
        
        if(!isset($data) || !$data['id']){
            ViewHelper::render("view/403.php");
            exit;
        }

        $errors["id"] = $data["id"] === null ? "Invalid ID" : "";

        $comment = CommentDB::get($data["id"]);
        if(!isset($_SESSION['user_id'])){
            ViewHelper::render("view/401.php");
        }
        
        else if ($comment === false)
            ViewHelper::render("view/404.php");
        else if ($comment['userid']!==$_SESSION['user_id']){
            ViewHelper::render("view/403.php");
        }
        else{
            $isDataValid = true;
            foreach ($errors as $error) {
                $isDataValid = $isDataValid && empty($error);
            }

            if ($isDataValid) {
                CommentDB::delete($data["id"]);
            }
            ViewHelper::redirect(BASE_URL . "journey/?id=".$comment['journeyid'],$errors);
        }
        
    }

    public static function about() {
        ViewHelper::render("view/about.php");
    }

    public static function error404() {
        ViewHelper::render("view/404.php");
    }
}