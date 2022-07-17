<div id="blog">
    <div id="b<?php echo $blog->getBnum()?>">
        <!----------------------------main blog start-------------------------->
        <h2><?php echo $blog->getSubject() ?></h2>
        <p><?php echo $blog->getText() ?></p>
        <p>Created: <?php echo $blog->getCreated() ?></p>
        <p><?php $rating->Stars($blog->getBnum());
            echo ' Ratings: ' . $rating->getRatingCount($blog->getBnum()); ?></p>
        <!----------------------------comments start-------------------------->
        <?php $comment = new CommentManagement(new CommentRepository(new DBConnector()));
        $comments = $comment->getComments($blog->getBnum()); ?>
        <div id='comments'>
            <p>Comments:</p>
            <?php foreach ($comments as $comment) {
                if ($comment->getBlogNum() == $blog->getBnum()) { ?>
                    <p id='singleComment'><?php echo $comment->getText() ?> <br />
                        Created: <?php echo $comment->getCreated() ?> <br />
                        From :<?php echo $comment->getUser() ?>
                        <!----------------------------delete comment only if same user created it-------------------------->
                        <?php if (isset($_SESSION['username']) && $comment->getUser() == $_SESSION['username']) { ?>
                            <button>
                                <a href="deleteComment.php?cnum=<?php echo $comment->getCnum() ?>">Delete</a>
                            </button>
                        <?php } ?>
                    </p>
                <?php }
            }
            if ($loggedIn == true) { ?>
                <a href="addComment.php?bnum=<?php echo $blog->getBnum() ?>">Add Comment</a>
            <?php } ?>
            <!----------------------------comments end-------------------------->
        </div>
        <!----------------------------admin only-------------------------->
        <?php if ($admin == true) { ?>
            <a href="editBlog.php?bnum=<?php echo $blog->getBnum() ?>">Edit</a>
            <a href="deleteBlog.php?bnum=<?php echo $blog->getBnum() ?>">Delete</a>
            <a href="hide.php?bnum=<?php echo $blog->getBnum() ?>">Hide/Show</a>
            <p id='hidden'>Post is currently <?php if ($blog->getHidden() == true) {
                                                    echo 'hidden';
                                                } else {
                                                    echo 'visible';
                                                } ?></p>
            </p>
        <?php } ?>
        <!----------------------------admin only-------------------------->
        <!----------------------------main blog end-------------------------->
    </div>
</div>