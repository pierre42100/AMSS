<?php
/**
 * Login page main controller
 *
 * @author Pierre HUBERT
 */

/**
 * First, check if user is logged in
 */
if($amss->user->userLoggedIn()){
    //This page is for logouted user only
    //Redirect to the main page
    header("Location: ".$amss->config->get("site_url"));

    //Exit page
    exit();
}

//Register parent folder as main login folder
define("LOGIN_PAGE_DIR", str_replace("controllers", "", __DIR__));

//Prepare view data
$login_view_data = array();

//We check if user has submitted login form
if(isset($_POST["user_mail"]) AND isset($_POST['user_password'])){
    //Try to perform login
    if($amss->user->login($_POST["user_mail"], $_POST['user_password'])){

        //User successfully logged in, redirecting to home page
        header("Location:".$amss->config->get("site_url"));
    }

    //Else login failed, maybe because email or password was incorrecte
    else
        $login_view_data['loginErrorMessage'] = "The given email address or password is/are incorrect!";
}

//Now we can show login form
$amss->views->load("body", LOGIN_PAGE_DIR."views/v_loginForm.php", $login_view_data);
