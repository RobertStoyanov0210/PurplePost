<?php
class User
{
  private $db;
  public function __construct()
  {
    $this->db = new Database;
  }

  public function register($data)
  {
    $this->db->query('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
    $this->db->bind(':name', $data['name']);
    $this->db->bind(':email', $data['email']);
    // this will be the hashed password
    $this->db->bind(':password', $data['password']);

    return $this->db->execute() ? true : false;
  }

  public function login($email, $password)
  {
    $this->db->query('SELECT * FROM users WHERE email = :email');
    $this->db->bind(':email', $email);

    $row = $this->db->single();

    $hashed_password = $row->password;

    return password_verify($password, $hashed_password) ? $row : false;
  }
  /* ------ GETTERS ------ */
  # user by EMAIL
  public function findUserByEmail($email)
  {
    $this->db->query('SELECT * FROM users WHERE email = :email');
    $this->db->bind(':email', $email);

    $row = $this->db->single();

    return  $this->db->rowCount() > 0;
  }
  # user by ID
  public function getUserById($id)
  {
    $this->db->query('SELECT * FROM users WHERE id = :id');
    $this->db->bind(':id', $id);

    $row = $this->db->single();

    return  $row;
  }
}
