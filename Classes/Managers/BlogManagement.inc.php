<?php
class BlogManagement{
    private $blogRepository;

    public function __construct($blogRepository){
        $this->blogRepository = $blogRepository;
    }

    public function login($username, $password)
    {
        $this->blogRepository->login($username, $password);
        header ('Location: index.php');
        exit;
    }

    public function logout()
    {
        $this->blogRepository->logout();
    }

    public function isAdmin($user)
    {
        $this->blogRepository->isAdmin($user);
    }

    public function isLoggedIn()
    {
        $this->blogRepository->isLoggedIn();
    }
}