<?php
class Rating
{
    protected $rnum;
    protected $bnum;
    protected $user;


    public function __construct($rnum, $bnum, $user)
    {
        $this->setRnum($rnum);
        $this->setBnum($bnum);
        $this->setUser($user);
    }
    public function getRnum()
    {
        return $this->rnum;
    }
    public function setRnum($rnum)
    {
        $this->rnum = $rnum;
    }
    public function getBnum()
    {
        return $this->bnum;
    }
    public function setBnum($bnum)
    {
        $this->bnum = $bnum;
    }
    public function getUser()
    {
        return $this->user;
    }
    public function setUser($user)
    {
        $this->user = $user;
    }
}
