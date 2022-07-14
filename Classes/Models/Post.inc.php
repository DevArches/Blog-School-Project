<?php
class Post
{
    private $bnum = 0;
    private $subject = "";
    private $text = "";
    private $created = 0;
    private $hidden = true;

    public function __construct($bnum, $subject = '', $text = '',  $created = 0, $hidden = true)
    {
        $this->setBnum($bnum);
        $this->setSubject($subject);
        $this->setText($text);
        $this->setCreated($created);
        $this->setHidden($hidden);
    }

    public function getBnum()
    {
        return $this->bnum;
    }
    
    public function setBnum($bnum)
    {
        $this->bnum = (int)$bnum;

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
        $this->text = nl2br($text);
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created)
    {
        $this->created = date('l jS \of F Y h:i:sa', $created);
    }

    public function getHidden()
    {
        return $this->hidden;
    }

    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }
}
