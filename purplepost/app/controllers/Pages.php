<?php
class Pages extends Controller
{
  public function __construct()
  {
  }
  public function index()
  {
    if (isLoggedIn()) {
      redirect('posts');
    }

    $data = ['title' => "Welcome to my website", 'description' => 'Simple post sharing website build on custom MVC.'];
    $this->view('pages/index', $data);
  }
  public function about()
  {
    $data = ['title' => "This is the default About page.", 'description' => 'App to share posts with other users.'];
    $this->view('pages/about', $data);
  }
}
