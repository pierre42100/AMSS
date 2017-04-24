<?php
/**
 * Main user class
 *
 * @author Pierre HUBERT
 */

class User{

    /**
     * @var String $userVariable User variable name
     */
    private $userVariable = "AMSS_user";

    /**
     * Public constructor
     */
    public function __construct(){

        //Check if session is started
        if(!isset($_SESSION))
            session_start();

    }


    /**
     * Check if a user is logged in or not
     *
     * @param Boolean Depending of user login state
     */
     public function userLoggedIn(){
         //We check if user variable exists
         if(!isset($_SESSION[$this->userVariable]))
             return false; //The variable is required
            
        //We check if username is specified
        if(!isset($_SESSION[$this->userVariable]['user_name']))
            return false; //This field is required
        
        //Else user is logged in
        return true;
     }

     /**
      * Try to retrieve data about a currently logged in user
      *
      * @return Array Data about user
      */
      public function infos() : array {
          //Check if there is anything to retrieve
          if(!isset($_SESSION[$this->userVariable])){
              //Return an empty array
              return array();
          }

          //Else return data about user
          return $_SESSION[$this->userVariable];
      }

     /**
      * Try to login user with given credentials
      *
      * Warning : this method is implemented for one single
      * system user !
      *
      * @param String $user_mail User e-mail address
      * @param String $user_password User password
      * @return Boolean Depends of the success of the operation
      */
      public function login($user_mail, $user_password){
          //Get user credentials infos
          $userCredentials = $this->parent->config->get("user_credentials");

          //Crypt password and check login
          $pass = crypt(sha1($user_password), sha1($user_password));
          
          if($userCredentials['user_mail'] !== $user_mail OR
             $userCredentials['password'] !== $pass){
              //Invalid login
              return false;
          }

          //Else we store login data in $_SESSION attribute
          $_SESSION[$this->userVariable] = array(
              "user_mail" => $userCredentials["user_mail"],
              "user_name" => $userCredentials["user_name"]
          );

          //Everything went good
          return true;
      }

      /**
       * Logout user (if any is logged in)
       *
       * @return Boolean Depending of the fact if a user has been logged out
       */
       public function logout(){
           //Check if there is somebody to logout
           if(!isset($_SESSION[$this->userVariable])){
               return false; //Nobody to log out
           }

           //Else, logout user
           unset($_SESSION[$this->userVariable]);

           //Someone was logged out
           return true;
       }

       /**
        * Check RestTokens validity
        *
        * @param String $token1 The first token
        * @param String $token2 The second token
        * @return Boolean Depends of the validity of the tokens
        */
        public function checkTokens($token1, $token2){
            //Get real tokens
            $realTokens = $this->parent->config->get("securityTokens");

            //Check the tokens and return the result
            if($token1 == $realTokens["token1"] AND $token2 == $realTokens["token2"]){
                //Everything seems to be correct
                return true;
            }

            //Else something is wrong
            else {
                return false;
            }
        }
}