<?php

require_once('database.php');

class User
{

    protected $id;
    protected $email;
    protected $password;
    protected $isConfirmed;


    public function __construct($user = null)
    {

        if ($user != null):
            $this->setId(isset($user->id) ? $user->id : null);
            $this->setEmail($user->email);
            $this->setPassword($user->password, isset($user->password_confirm) ? $user->password_confirm : false);
            $this->setisConfirmed(isset($user->isConfirmed) ? $user->isConfirmed : null);
        endif;
    }

    /***************************
     * -------- SETTERS ---------
     ***************************/

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setEmail($email)
    {

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)):
            throw new Exception('Email incorrect');
        endif;

        $this->email = $email;

    }

    public function setPassword($password, $password_confirm = false)
    {

        if ($password_confirm && $password != $password_confirm) {
            throw new Exception('Vos mots de passes sont différents');
        } else if ((strlen($password) === 0 || strlen($password_confirm) === 0) && $password_confirm) {
            throw new Exception('Vos mots de passes sont vides');
        }

        $this->password = $password;
    }

    /**
     * @param mixed $isConfirmed
     */
    public function setisConfirmed($isConfirmed): void
    {
        $this->isConfirmed = $isConfirmed;
    }

    /***************************
     * -------- GETTERS ---------
     ***************************/

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getisConfirmed()
    {
        return $this->isConfirmed;
    }


    /***********************************
     * -------- CREATE NEW USER ---------
     ************************************/

    public function createUser()
    {

        // Open database connection
        $db = init_db();

        // Check if email already exist
        $req = $db->prepare("SELECT * FROM user WHERE email = '" . $this->email . "'");
        $req->execute();

        if ($req->rowCount() > 0) throw new Exception("Email ou mot de passe incorrect");

        // Insert new user
        $req->closeCursor();

        $req = $db->prepare("INSERT INTO user ( email, password ) VALUES ( :email, :password )");
        $req->execute(array(
            'email' => $this->getEmail(),
            'password' => $this->getPassword()
        ));

        // Send the activation mail
        $this->sendMailActivation();

        // Close databse connection
        $db = null;

    }

    /**************************************
     * -------- GET USER DATA BY ID --------
     ***************************************/

    public static function getUserById($id)
    {

        // Open database connection
        $db = init_db();

        $req = $db->prepare("SELECT * FROM user WHERE id  = '" . $id . "'");
        $req->execute(array($id));

        // Close databse connection
        $db = null;

        return $req->fetch();
    }

    /***************************************
     * ------- GET USER DATA BY EMAIL -------
     ****************************************/

    public function getUserByEmail()
    {
        $db = init_db();

        $req = $db->prepare("SELECT * FROM user WHERE email = '" . $this->email . "'");
        $req->execute();

        $db = null;

        return $req->fetch();
    }


     /**************************
     * ------- SEND MAIL -------
     ***************************/

    private function sendMailActivation()
    {
        $addressee = $this->email;

        $subject = "Activation de votre compte";
        $header = "From: support@codflix.com";

        $message = 'Bienvenue sur CodFlix,
        Veuillez cliquer sur le lien ci-dessous pour activer votre compte.
        http://codflix.com/activation.php?log='.urlencode($addressee);

        mail($addressee, $subject, $message, $header);
    }
}