<?php
class PostManagement extends Post
{
    private $postRepository;

    public function __construct($postRepository){
        $this->postRepository = $postRepository;
    }

    public function getBlogs()
    {
        $blogs = $this->postRepository->getBlogs();
        $blogList = array();
        foreach ($blogs as $blog) {
            $blogList[] = new Post($blog->bnum, $blog->subject, $blog->text, $blog->created, $blog->hidden);
        }
        return $blogList;
    }

    public function getBlog($bnum)
    {
        $blog = $this->postRepository->getBlog($bnum);
        return new Post($blog->bnum, $blog->subject, $blog->text, $blog->created, $blog->hidden);
    }

    public function deleteBlog($bnum)
    {
        $this->postRepository->delete($bnum);
    }
    public function setTime()
    {
        $this->time = time();
        return $this->time;
    }

    public function newBlog($hidden, $subject, $text)
    {
        $time = $this->setTime();
        $this->postRepository->insert($hidden, $subject, $text, $time);
    }

    public function editBlog($bnum, $subject, $text)
    {
        $this->postRepository->editBLog($bnum, $subject, $text);
    }
    public function toggleHidden($bnum)
    {
        $blog = $this->postRepository->getBlog($bnum);
        $hiddenStatus = $blog->hidden;
        if($hiddenStatus == 0){
            $hiddenStatus = 1;
        }else{
            $hiddenStatus = 0;
        }
        $this->postRepository->editHidden($bnum, $hiddenStatus);
    }

}
