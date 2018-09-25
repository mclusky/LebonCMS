<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
<aside class="admin-aside bg-dark text-white text-center">
    <ul class="list-group side-nav d-lg-inline">
        <li class="list-group-item bg-dark">
            <a href="/cms/admin/"><i class="fal fa-tachometer-alt"></i></i> Dashboard</a>
        </li>
        <li class="list-group-item bg-dark">
            <a href="javascript:;" data-toggle="collapse" data-target="#posts-dropdown"><i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i>
            </a>
            <ul id="posts-dropdown" class="collapse list-unstyled">
                <li class="py-2">
                    <a href="./posts.php">View All Posts</a>
                </li>
                <li class="py-2">
                    <a href="posts.php?source=add_post">Add Post</a>
                </li>
            </ul>
        </li>
        <li class="list-group-item bg-dark">
            <a href="categories.php"><i class="fa fa-fw fa-wrench"></i> Categories</a>
        </li>
        <li class="list-group-item bg-dark">
            <a href="/cms/admin/comments.php"><i class="fa fa-fw fa-file"></i> Comments</a>
        </li>
        <?php if (is_admin($_SESSION['username'])): ?>
        <li class="list-group-item bg-dark">
            <a href="javascript:;" data-toggle="collapse" data-target="#users"><i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
            <ul id="users" class="collapse list-unstyled">
                <li class="py-2">
                    <a href="users.php">View All Users</a>
                </li>
                <li class="py-2">
                    <a href="/cms/admin/users.php?source=add_user">Add User</a>
                </li>
            </ul>
        </li>
        <?php endif;?>
    </ul>
</aside>
