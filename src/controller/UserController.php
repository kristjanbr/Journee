<?php

require_once("model/UserDB.php");
require_once("ViewHelper.php");
session_start();

class UserController {

    public static function showLoginForm() {
       ViewHelper::render("view/login.php",[
        "errorMessage" => ""]);
    }

    public static function login() {
        $rules = [
            "username" => FILTER_SANITIZE_SPECIAL_CHARS,
            "password" => FILTER_DEFAULT,
        ];
        $data = filter_input_array(INPUT_POST, $rules);
        
        $user_data = UserDB::validLoginAttempt($data["username"], $data["password"]);
        if ($user_data===false) {
             ViewHelper::render("view/login.php", [
                 "errorMessage" => "Invalid username or password."]);
        } else {
            $_SESSION['user_id'] = $user_data['id'];
            $_SESSION['user_username'] = $user_data['username'];
            $_SESSION['user_name'] = $user_data['name'];
            ViewHelper::redirect(BASE_URL . "journey");
        }
    }


    public static function showSignupForm() {
        ViewHelper::render("view/signup.php", [
            "data" => [
               "name" =>"",
               "surname" => "",
               "username" => "",
               "email" => "",
            ]
            ]);
     }
 
     public static function signup() {
        $rules = [
            "name" => FILTER_SANITIZE_SPECIAL_CHARS,
            "surname" => FILTER_SANITIZE_SPECIAL_CHARS,
            "username" => FILTER_SANITIZE_SPECIAL_CHARS,
            "email" => FILTER_VALIDATE_EMAIL,
            "password" => FILTER_DEFAULT,
            "passwordconfirm" => FILTER_DEFAULT,
        ];
        $data = filter_input_array(INPUT_POST, $rules);
        

        if($data['password']!==$data['passwordconfirm']){
            ViewHelper::render("view/signup.php", [
                "passError" => "Paswords do not match.",
                "data" => [
                   "name" => $data['name'],
                   "surname" => $data['surname'],
                   "username" => $data['username'],
                   "email" => $data['email'],
                ]
            ]);
        }
        else if (strlen($data['password'])<6){
            ViewHelper::render("view/signup.php", [
                "passError" => "Pasword needs to be at least 6 characters long.",
                "data" => [
                   "name" => $data['name'],
                   "surname" => $data['surname'],
                   "username" => $data['username'],
                   "email" => $data['email'],
                ]
            ]);
        }
        else if ($data['email']===false){
            ViewHelper::render("view/signup.php", [
                "mailError" => "Invalid email.",
                "data" => [
                    "name" => $data['name'],
                    "surname" => $data['surname'],
                    "username" => $data['username'],
                    "email" => "",
                ]
            ]);
        } else {
            $signup_code = UserDB::validSignupAttempt($data);
            if ($signup_code  === 0) {
                $user_data = UserDB::validLoginAttempt($data["username"], $data["password"]);
                if ($user_data===false) {
                    ViewHelper::render("view/login.php", [
                        "errorMessage" => "Unknown error ocurred."]);
                } else {
                    $_SESSION['user_id'] = $user_data['id'];
                    $_SESSION['user_username'] = $user_data['username'];
                    $_SESSION['user_name'] = $user_data['name'];
                    ViewHelper::redirect(BASE_URL . "journey");
                }
            } else if ($signup_code === 1) {
                ViewHelper::render("view/signup.php", [
                    "usernameError" => "Username is already taken.",
                    "data" => [
                        "name" => $data['name'],
                        "surname" => $data['surname'],
                        "username" => "",
                        "email" => $data['email'],
                    ]
                ]);
            } else {
                ViewHelper::render("view/signup.php", [
                    "mailError" => "User is already registered with such email.",
                    "data" => [
                        "name" => $data['name'],
                        "surname" => $data['surname'],
                        "username" => $data['username'],
                        "email" => "",
                    ]
                ]);
            }
        }
     }

     public static function logout() {
        session_destroy();
        ViewHelper::redirect(BASE_URL . "journey");
    }
    

}