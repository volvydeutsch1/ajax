<?php
  class Users extends Controller{
    public function __construct(){
      $this->userModel = $this->model('User');
    }

    public function index(){
      redirect('welcome');
    }

    public function register(){
      // Check if logged in
      if($this->isLoggedIn()){
        redirect('posts');
      }

      // Check if POST
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'age' => trim($_POST['age']),
          'name' => trim($_POST['name']),
          'email' => trim($_POST['email']),
            'username' => trim($_POST['username']),
          'password' => trim($_POST['password']),
          'confirm_password' => trim($_POST['confirm_password']),
            'age_err' => '',
          'name_err' => '',
          'email_err' => '',
            'username_err' => '',
          'password_err' => '',
          'confirm_password_err' => ''
        ];
        if(empty($data['age'])){
              $data['age_err'] = 'Please enter an age';
            // Validate email
            if(empty($data['email'])) {
                $data['email_err'] = 'Please enter an email';
            }
            // Validate name
            if(empty($data['name'])){
              $data['name_err'] = 'Please enter a name';
            }
            if(empty($data['username'])){
                $data['username_err'] = 'Please enter a username';
            }
        } else{
          // Check Email
          if($this->userModel->findUserByName($data['name'])){
            $data['name_err'] = 'Name is already taken.';
          }
            if($this->userModel->findUserByEmail($data['email'])){
                $data['email_err'] = 'Email is already taken.';
            }
            if($this->userModel->findUserByUsername($data['username'])){
                $data['username_err'] = 'Username is already taken.';
            }
        }
      if($data['age'] < 1){
          $data['age_err'] = 'age must have atleast 1.';
      }
        // Validate password
        if(empty($data['password'])){
          $password_err = 'Please enter a password.';     
        } elseif(strlen($data['password']) < 8){
          $data['password_err'] = 'Password must have atleast 8 characters.';
        }

        // Validate confirm password
        if(empty($data['confirm_password'])){
          $data['confirm_password_err'] = 'Please confirm password.';     
        } else{
            if($data['password'] != $data['confirm_password']){
                $data['confirm_password_err'] = 'Password do not match.';
            }
        }
         
        // Make sure errors are empty
        if(empty($data['age_err']) && empty($data['name_err']) && empty($data['email_err']) && empty($data['username_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
          // SUCCESS - Proceed to insert

          // Hash Password
          $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

          //Execute
          if($this->userModel->register($data)){
            // Redirect to login
            flash('register_success', 'You are now registered and can log in');
            redirect('users/login');
          } else {
            die('Something went wrong');
          }
           
        } else {
          // Load View
          $this->view('users/register', $data);
        }
      } else {
        // IF NOT A POST REQUEST

        // Init data
        $data = [
            'age' => '',
          'name' => '',
          'email' => '',
            'username' => '',
          'password' => '',
          'confirm_password' => '',
            'age_err' => '',
          'name_err' => '',
          'email_err' => '',
            'username_err' => '',
          'password_err' => '',
          'confirm_password_err' => ''
        ];

        // Load View
        $this->view('users/register', $data);
      }
    }

      public function registerAjax(){
          // Check if logged in
          if($this->isLoggedIn()){
              redirect('posts');
          }

          // Check if POST
          if($_SERVER['REQUEST_METHOD'] == 'POST'){
              // Sanitize POST
              $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

              $data = [
                  'age' => trim($_POST['age']),
                  'name' => trim($_POST['name']),
                  'email' => trim($_POST['email']),
                  'username' => trim($_POST['username']),
                  'password' => trim($_POST['password']),
                  'confirm_password' => trim($_POST['confirm_password']),
                  'age_err' => '',
                  'name_err' => '',
                  'email_err' => '',
                  'username_err' => '',
                  'password_err' => '',
                  'confirm_password_err' => ''
              ];
              if(empty($data['age'])) {
                  $data['age_err'] = 'Please enter an age';
              }
              // Validate email
              if(empty($data['email'])) {
                  $data['email_err'] = 'Please enter an email';

              } else{
                  // Check Email
                  if($this->userModel->findUserByEmail($data['email'])){
                      $data['email_err'] = 'Email is already taken.';
                  }
              }

              if(empty($data['name'])){
                  $data['name_err'] = 'Please enter a name';

              }else{
                  if($this->userModel->findUserByName($data['name'])){
                    $data['name_err'] = 'Name is already taken.';
                    }
              }

              if(empty($data['username'])){
                  $data['username_err'] = 'Please enter a username';
              }else{
                  if($this->userModel->findUserByUsername($data['username'])){
                      $data['username_err'] = 'Username is already taken.';
                  }
              }
              if($data['age'] < 1){
                  $data['age_err'] = 'age must have atleast 1.';
              }
              // Validate password
              if(empty($data['password'])){
                  $data['password_err'] = 'Please enter a password.';
              } elseif(strlen($data['password']) < 8){
                  $data['password_err'] = 'Password must have atleast 8 characters.';
              }

              // Validate confirm password
              if(empty($data['confirm_password'])){
                  $data['confirm_password_err'] = 'Please confirm password.';
              } else{
                  if($data['password'] != $data['confirm_password']){
                      $data['confirm_password_err'] = 'Password do not match.';
                  }
              }

              // Make sure errors are empty
              if(empty($data['age_err']) && empty($data['name_err']) && empty($data['email_err']) && empty($data['username_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
                  // SUCCESS - Proceed to insert

                  // Hash Password
                  $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                  //Execute
                  if($this->userModel->register($data)){
                      // Redirect to login
                      flash('register_success', 'You are now registered and can log in');
                      redirect('users/login');
                  } else {
                      die('Something went wrong');
                  }

             } else {
//                  // Load View
//                  $this->view('users/registerAjax', $data);
                  echo $data['age_err'] . $data['name_err'] . $data['email_err'] . $data['username_err'] . $data['password_err'] . $data['confirm_password_err'];
              }
          } else {
              // IF NOT A POST REQUEST

              // Init data
              $data = [
                  'age' => '',
                  'name' => '',
                  'email' => '',
                  'username' => '',
                  'password' => '',
                  'confirm_password' => '',
                  'age_err' => '',
                  'name_err' => '',
                  'email_err' => '',
                  'username_err' => '',
                  'password_err' => '',
                  'confirm_password_err' => ''
              ];

              // Load View
              $this->view('users/registerAjax', $data);
          }
      }

    public function login(){
      // Check if logged in
      if($this->isLoggedIn()){
        redirect('posts');
      }

      // Check if POST
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        $data = [       
          'email' => trim($_POST['email']),
          'password' => trim($_POST['password']),        
          'email_err' => '',
          'password_err' => '',       
        ];

        // Check for email
        if(empty($data['email'])){
          $data['email_err'] = 'Please enter email.';
        }

        // Check for name
        if(empty($data['name'])){
          $data['name_err'] = 'Please enter name.';
        }

        // Check for user
        if($this->userModel->findUserByEmail($data['email'])){
          // User Found
        } else {
          // No User
          $data['email_err'] = 'This email is not registered.';
        }

        // Make sure errors are empty
        if(empty($data['email_err']) && empty($data['password_err'])){

          // Check and set logged in user
          $loggedInUser = $this->userModel->login($data['email'], $data['password']);

          if($loggedInUser){
            // User Authenticated!
            $this->createUserSession($loggedInUser);
           
          } else {
            $data['password_err'] = 'Password incorrect.';
            // Load View
            $this->view('users/login', $data);
          }
           
        } else {
          // Load View
          $this->view('users/login', $data);
        }

      } else {
        // If NOT a POST

        // Init data
        $data = [
          'email' => '',
          'password' => '',
          'email_err' => '',
          'password_err' => '',
        ];

        // Load View
        $this->view('users/login', $data);
      }
    }

    // Create Session With User Info
    public function createUserSession($user){
      $_SESSION['user_id'] = $user->id;
      $_SESSION['user_email'] = $user->email; 
      $_SESSION['user_name'] = $user->name;
      redirect('posts');
    }

    // Logout & Destroy Session
    public function logout(){
      unset($_SESSION['user_id']);
      unset($_SESSION['user_email']);
      unset($_SESSION['user_name']);
      session_destroy();
      redirect('users/login');
    }

    // Check Logged In
    public function isLoggedIn(){
      if(isset($_SESSION['user_id'])){
        return true;
      } else {
        return false;
      }
    }
  }
