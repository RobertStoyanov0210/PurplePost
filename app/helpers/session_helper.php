<?php
session_start();


function flash($name = '', $msg = '', $class = 'alert alert-success')
{
  if (!empty($name)) { // name for flash is required
    if (!empty($msg)) {
      # Unset previous values stored in session
      if (!empty($_SESSION[$name])) {
        unset($_SESSION[$name]);
      }
      if (!empty($_SESSION[$name . '_class'])) {
        unset($_SESSION[$name . '_class']);
      }
      $_SESSION[$name] = $msg;
      $_SESSION[$name . '_class'] = $class;
    } elseif (empty($msg) && !empty($_SESSION[$name])) {
      echo '<div class="' . $_SESSION[$name . '_class'] . '" id="msg-flash">' . $_SESSION[$name] . '</div>';
      # Unset current flash
      unset($_SESSION[$name]);
      unset($_SESSION[$name . '_class']);
    }
  }
}

function isLoggedIn()
{
  return isset($_SESSION['user_id']);
}
