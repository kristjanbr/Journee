<?php

require_once("controller/JourneyController.php");
require_once("controller/UserController.php");

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/images/");
define("CSS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/css/");
define("JS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "static/js/");


$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

$urls = [
    "journey" => function () {
       JourneyController::index();
    },
    "journey/add" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            JourneyController::add();
        } else {
            JourneyController::showAddForm();
        }
     },

    "journey/search" => function () {
        JourneyController::search();
    },

    "journey/edit" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            JourneyController::edit();
        } else {
            JourneyController::showEditForm();
        }
    },
    "journey/delete" => function () {
        JourneyController::delete();
    },
    "comment/add" => function () {
        JourneyController::comment();
    },
    "comment/delete" => function () {
        JourneyController::deleteComment();
    },
    "user/login" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::login();
        } else {
            UserController::showLoginForm();
        }
    },
    "user/signup" => function () {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::signup();
        } else {
            UserController::showSignupForm();
        }
    },
    "user/logout" => function () {
        UserController::logout();
    },
    "api/journey/search" => function () {
        JourneyController::searchApi();
    },
    "about" => function () {
        JourneyController::about();
    },
    "" => function () {
        ViewHelper::redirect(BASE_URL . "journey");
    },
];

try {
    if (isset($urls[$path])) {
       $urls[$path]();
    } else {
        // echo "No controller for '$path'";
        JourneyController::error404();
    }
} catch (Exception $e) {
    echo "An error occurred: <pre>$e</pre>";
    // ViewHelper::error404();
} 
