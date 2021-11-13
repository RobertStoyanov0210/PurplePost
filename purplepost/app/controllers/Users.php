<?php
class Users extends Controller
{
  public function __construct()
  {
    $this->userModel = $this->model('User');
  }

  public function register()
  {
    // Check for POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      // Sanitize POST data
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'name' => trim($_POST['name']),
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'confirm_password' => trim($_POST['confirm_password']),
        'name_err' => '',
        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => ''
      ];

      // Register validations
      # Email
      if (empty($data['email'])) {
        $data['email_err'] = 'Please enter email';
      } elseif ($this->userModel->findUserByEmail($data['email'])) {
        $data['email_err'] = 'Email is already taken';
      }

      # Name
      if (empty($data['name'])) {
        $data['name_err'] = 'Please enter name';
      }
      # Password
      if (empty($data['password'])) {
        $data['password_err'] = 'Please enter password';
      } elseif (strlen($data['password']) < 6) {
        $data['password_err'] = 'Password must be at least 6 characters';
      }
      # Confirm Password
      if (empty($data['confirm_password'])) {
        $data['confirm_password_err'] = 'Please confirm your password';
      } elseif ($data['password'] != $data['confirm_password']) {
        $data['confirm_password_err'] = 'Passwords do not match';
      }

      if (empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
        // Hash Password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        // Register the user
        if ($this->userModel->register($data)) {
          flash('register_success', 'You are registered. Please log in.');
          redirect('users/login');
        } else {
          die('Something went wrong');
        }
      } else {
        $this->view('users/register', $data);
      }
    } else {
      $data = [
        'name' => '',
        'email' => '',
        'password' => '',
        'confirm_password' => '',
        'name_err' => '',
        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => ''
      ];
      // Load form
      $this->view('users/register', $data);
    }
  }

  public function login()
  {
    // Check for POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Sanitize POST data
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      $data = [
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'email_err' => '',
        'password_err' => ''
      ];

      // Login validations
      # Email
      if (empty($data['email'])) {
        $data['email_err'] = 'Please enter email';
      }
      # Password
      if (empty($data['password'])) {
        $data['password_err'] = 'Please enter password';
      }

      // Check for email
      if ($this->userModel->findUserByEmail($data['email'])) {
        // User found
      } else {
        $data['email_err'] = 'Email not registered';
      }

      if (empty($data['email_err'])  && empty($data['password_err'])) {
        $loggedInUser = $this->userModel->login($data['email'], $data['password']);
        // loggedInUser is either $row or false
        if ($loggedInUser) {
          // Create Session
          $this->createUserSession($loggedInUser);
        } else {
          $data['password_err'] = 'Password incorrect';
          $this->view('users/login', $data);
        }
      } else {
        $this->view('users/login', $data);
      }
    } else {
      $data = [
        'email' => '',
        'password' => '',
        'email_err' => '',
        'password_err' => ''
      ];

      // Load form
      $this->view('users/login', $data);
    }
  }
  public function createUserSession($user)
  {
    $_SESSION['user_id'] = $user->id;
    $_SESSION['user_name'] = $user->name;
    $_SESSION['user_email'] = $user->email;
    redirect('posts');
  }

  public function logout()
  {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_name']);
    session_destroy();
    redirect('users/login');
  }
}
