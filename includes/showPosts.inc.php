<div id="blog">
    <!----------------------------main blog start-------------------------->
    <h2><?php echo $post->getSubject() ?></h2>
    <p><?php echo $post->getText() ?></p>
    <p>Created: <?php echo $post->getCreated() ?></p>
    <p><?php $rating->Stars($post->getBnum());
        echo ' Ratings: ' . $rating->getRatingCount($post->getBnum()); ?></p>
    <!----------------------------comments start-------------------------->
    <?php $comment = new CommentManagement(new CommentRepository(new DBConnector()));
    $comments = $comment->getComments($post->getBnum()); ?>
    <div id='comments'>
        <p>Comments:</p>
        <?php foreach ($comments as $comment) {
            if ($comment->getBlogNum() == $post->getBnum()) { ?>
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
            <a href="addComment.php?bnum=<?php echo $post->getBnum() ?>">Add Comment</a>
        <?php } ?>
    <!----------------------------comments end-------------------------->
    </div>
    <!----------------------------admin only-------------------------->
    <?php if ($admin == true) { ?>
        <a href="editBlog.php?bnum=<?php echo $post->getBnum() ?>">Edit</a>
        <a href="deleteBlog.php?bnum=<?php echo $post->getBnum() ?>">Delete</a>
        <a href="hide.php?bnum=<?php echo $post->getBnum() ?>">Hide/Show</a>
        <p id='hidden'>Post is currently <?php if ($post->getHidden() == true) {
                echo 'hidden';
                    } else {
                        echo 'visible';
                } ?></p>
        </p>
    <?php } ?>
    <!----------------------------admin only-------------------------->
    <!----------------------------main blog end-------------------------->
</div>