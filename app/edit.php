<?php
require_once 'session.php';
include_once 'logic/edit_links.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>BlackLogger - User Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body id="page-top">

    <?php include_once 'components/header.php'; ?>

    <div id="wrapper">
        <div id="content-wrapper">
            <div class="container-fluid">
                <div class="card mb-3 mt-3">
                    <div class="card-header">
                        <i class="fas fa-user-circle"></i>
                        User Settings
                    </div>
                    <form method="POST">
                        <div class="card-body">
                            <div class="container container-special">
                                <?php if (isset($message)) : ?>

                                    <?php if ($message == "yes") : ?>

                                        <?php echo $utils->alert(
                                            "Link has been updated",
                                            "success",
                                            "check-circle"
                                        ); ?>

                                    <?php endif; ?>

                                <?php endif; ?>
                            </div>
                            <div class="container container-special">
                                <div class="align-content-center justify-content-center">

                                    <?php echo $utils->input("id", $l->id); ?>

                                    <?php echo $utils->input("csrf", $utils->sanitize($_SESSION['csrf'])); ?>

                                    <div class="mb-2">

                                        <div class="form-label-group">
                                            <input class="form-control" type="text" name="long_url" placeholder="Long Url" value="<?php echo $l->long_url; ?>">
                                        </div>
                                    </div>

                                    <button class="btn btn-primary btn-block">Update Url</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include_once 'components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</body>

</html>