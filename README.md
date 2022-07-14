Blog class assignment with database written in PHP and focusing on classes

includes/demoDb.inc.php -> to create/reset database (it will drop fa111 database if exists! careful!)

Admin can: 
    Full CRUD for Posts
    View visible/hidden posts/comments/ratings
    View post visibility
    Show/Hide posts (still see hidden posts)
    Add comments
    Add rating
    Delete own comments only
User can:
    View visible posts/comments/ratings
    Add comments
    Add rating (if already rated, will update rating to new value)
    Delete own comments only
Unregistered user can:
    View visible posts/comments/ratings


Classes: 
    Blog* login/logout etc
    Posts* handels CRUD for posts. Only Admin access to CUD. Admin+User+Unregistered access to Read
    Comment* handles CRUD for comments. Admin+User access. 
    Rating* handles CRU for ratings. Admin+User access