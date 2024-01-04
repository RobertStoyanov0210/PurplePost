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

    $data = ['title' => "Welcome to my website", 'description' => 'Simple post sharing website build on <a target="_blank" href="https://github.com/RobertStoyanov0210/robertsmvc">custom MVC</a>.'];
    $this->view('pages/index', $data);
  }
  public function about()
  {
    $data = ['title' => "This is the default About page.", 'description' => ' Sign up to peek into the amazing world of user-generated content on PurplePost. It\'s where all the cool stuff happens! :)'];
    $this->view('pages/about', $data);
  }
}
