<?php
class Post
{
    private $bnum = 0;
    private $subject = "";
    private $text = "";
    private $rating = 0.0;
    private $ratingCount = 0;
    private $created = 0;

    public function __construct($bnum, $subject = '', $text = '', $rating = 0, $ratingCount = 0, $created = 0)
    {
        $this->setBnum($bnum);
        $this->setSubject($subject);
        $this->setText($text);
        $this->setRating($rating);
        $this->setRatingCount($ratingCount);
        $this->setCreated($created);
    }
    public function getBnum()
    {
        return $this->bnum;
    }
    public function setBnum($bnum)
    {
        $this->bnum = $bnum;
    }
    public function getSubject()
    {
        return $this->subject;
    }
    public function setSubject($subject)
    {
        $this->subject = ucwords(strtolower($subject));
    }
    public function getText()
    {
        return $this->text;
    }
    public function setText($text)
    {
        $this->text = $text;
    }
    public function getRating()
    {
        return $this->rating;
    }
    public function setRating($rating)
    {
        $this->rating = $rating;
    }
    public function getCreated()
    {
        return $this->created;
    }
    public function setCreated($created)
    {
        $this->created = date('l jS \of F Y h:i:sa', $created);
    }
    public function getAdmin()
    {
        return $this->admin;
    }
    public function setAdmin($admin)
    {
        $this->admin = $admin;
    }
    public function getLoggedIn()
    {
        return $this->loggedIn;
    }
    public function setLoggedIn($loggedIn)
    {
        $this->loggedIn = $loggedIn;
    }
    public function getRatingCount()
    {
        return $this->ratingCount;
    }
    public function setRatingCount($ratingCount)
    {
        $this->ratingCount = $ratingCount;
    }
}
