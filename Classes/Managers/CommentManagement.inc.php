<?php
class CommentManagement extends Comment{
    private $commentRepository;

    public function __construct($commentRepository){
        $this->commentRepository = $commentRepository;
    }

    public function getComments(){
        $comments = $this->commentRepository->getAll();
        $commentList = array();
        foreach($comments as $comment){
            $commentList[] = new Comment($comment->cnum, $comment->blogNum, $comment->text, $comment->user, $comment->created);
        }
        return $commentList;
    }

    public function setTime(){
        $this->time = time();
        return $this->time;
    }
    public function addComment($blogNum, $text, $user){
        $this->commentRepository->insert($blogNum, $text, $user, $this->setTime());
    }
    public function deleteComment($cnum, $user){
        $this->commentRepository->deleteComment($cnum, $user);
    }
}
 