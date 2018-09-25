<nav class="navbar navbar-expand-md navbar-dark bg-dark p-3" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
            <a class="navbar-brand" href="/cms/index">Lebon CMS</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#admin-top-nav" aria-controls="admin-top-nav" aria-expanded="false" aria-label="Toggle navigation">
               <span class="sr-only">Toggle navigation</span>
               <span class="navbar-toggler-icon"></span>
           </button>
            <div class="collapse navbar-collapse" id="admin-top-nav">
                <!-- Top Menu Items -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" id="users-online" href=""></a></li>
                    <li class="nav-item"><a class="nav-link" href="/cms/index">Home</a></li>
                    <li class="dropdown nav-item">
                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle" href="javascript:;" role="button"><i class="fa fa-user"></i>
    <?php
    if (isset($_SESSION['username'])) {
    	echo $_SESSION['username'];
    }
    ?>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="/cms/admin/profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                            <a class="dropdown-item" href="../include/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </div>
                    </li>
                </ul>
                <!-- /.navbar-collapse -->
            </div>
            </div>
        </nav>
