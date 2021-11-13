<?php
class Posts extends Controller
{
  public function __construct()
  {
    if (!isLoggedIn()) {
      redirect('users/login');
      flash('unknown_user', 'Please login to access posts', 'alert alert-danger');
    }

    $this->postModel = $this->model('Post');
    $this->userModel = $this->model('User');
  }
  public function index()
  {
    // Get posts
    $posts = $this->postModel->getPosts();

    $data = [
      'posts' => $posts
    ];
    $this->view('posts/index', $data);
  }

  public function add()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Sanitize post
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      $data = [
        'title' => trim($_POST['title']),
        'body' => trim($_POST['body']),
        'user_id' => $_SESSION['user_id'],
        'title_err' => '',
        'body_err' => ''
      ];

      // Add Post Validations
      # Title
      if (empty($data['title'])) {
        $data['title_err'] = 'Please enter title';
      }
      # Body
      if (empty($data['body'])) {
        $data['body_err'] = 'Please enter body text';
      }
      if (empty($data['title_err']) && empty($data['body_err'])) {
        // Success
        if ($this->postModel->addPost($data)) {
          flash('post_message', 'Your post was added');
          redirect('posts');
        } else {
          die('Something went wrong');
        }
      } else {
        // Load view with errors
        $this->view('posts/add', $data);
      }
    } else {
      $data = [
        'title' => '',
        'body' => ''
      ];
      $this->view('posts/add', $data);
    }
  }

  public function edit($id)
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Sanitize post
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      $data = [
        'id' => $id,
        'title' => trim($_POST['title']),
        'body' => trim($_POST['body']),
        'user_id' => $_SESSION['user_id'],
        'title_err' => '',
        'body_err' => ''
      ];

      // Add Post Validations
      # Title
      if (empty($data['title'])) {
        $data['title_err'] = 'Please enter title';
      }
      # Body
      if (empty($data['body'])) {
        $data['body_err'] = 'Please enter body text';
      }
      if (empty($data['title_err']) && empty($data['body_err'])) {
        // Success
        if ($this->postModel->updatePost($data)) {
          flash('post_message', 'Your post was updated');
          redirect('posts');
        } else {
          die('Something went wrong');
        }
      } else {
        // Load view with errors
        $this->view('posts/edit', $data);
      }
    } else {
      // Get current post
      $post = $this->postModel->getPostById($id);
      // Check for owner
      if ($post->user_id != $_SESSION['user_id']) {
        flash('post_message', 'You have to be the owner of the post to edit it', 'alert alert-danger');
        redirect('posts');
      }
      $data = [
        'id' => $id,
        'title' => $post->title,
        'body' => $post->body
      ];
      $this->view('posts/edit', $data);
    }
  }

  public function show($id)
  {
    $post = $this->postModel->getPostById($id);
    $user = $this->userModel->getUserById($post->user_id);
    $data = [
      'post' => $post,
      'user' => $user
    ];

    $this->view('posts/show', $data);
  }

  public function delete($id)
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Get current post
      $post = $this->postModel->getPostById($id);
      // Check for owner
      if ($post->user_id != $_SESSION['user_id']) {
        flash('post_message', 'You have to be the owner of the post to edit it', 'alert alert-danger');
        redirect('posts');
      }
      if ($this->postModel->deletePost($id)) {
        flash('post_message', 'Your post was removed');
        redirect('posts');
      } else {
        die("Something went wrong");
      }
    } else {
      redirect('posts');
    }
  }
}
