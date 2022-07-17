<?php
class UserManagement{
    private $userRepository;

    public function __construct($userRepository){
        $this->userRepository = $userRepository;
    }

    public function login($username, $password)
    {
        $this->userRepository->login($username, $password);
        header ('Location: index.php');
        exit;
    }

    public function logout()
    {
        $this->userRepository->logout();
    }

    public function isAdmin($user)
    {
        $this->userRepository->isAdmin($user);
    }

    public function isLoggedIn()
    {
        $this->userRepository->isLoggedIn();
    }
}