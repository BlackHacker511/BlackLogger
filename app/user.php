<?php
require_once 'session.php';
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
                    <form method="POST" action="logic/user.php">
                        <div class="card-body">
                            <div class="container container-special">
                                <?php if (isset($_GET['msg'])) : ?>

                                    <?php if ($_GET['msg'] == "yes") : ?>

                                        <?php echo $utils->alert(
                                            "User settings has been updated",
                                            "success",
                                            "check-circle"
                                        ); ?>

                                    <?php elseif ($_GET['msg'] == "csrf") : ?>

                                        <?php echo $utils->alert(
                                            "CSRF token is invalid.",
                                            "danger",
                                            "times-circle"
                                        ); ?>

                                    <?php elseif ($_GET['msg'] == "error") : ?>

                                        <?php echo $utils->alert(
                                            "An unexpected error has occurred",
                                            "danger",
                                            "times-circle"
                                        ); ?>

                                    <?php elseif ($_GET['msg'] == "attack") : ?>

                                        <?php echo $utils->alert(
                                            "You are trying to access another account",
                                            "danger",
                                            "times-circle"
                                        ); ?>

                                    <?php endif; ?>

                                <?php endif; ?>
                            </div>
                            <div class="container container-special">
                                <div class="align-content-center justify-content-center">

                                    <?php echo $utils->input("id", $data->id); ?>

                                    <?php echo $utils->input("csrf", $utils->sanitize($_SESSION['csrf'])); ?>

                                    <div class="mb-2">

                                        <div class="form-label-group">
                                            <input class="form-control" type="text" id="Username" name="Username" placeholder="Username" value="<?php echo $data->username; ?>">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-label-group">
                                            <input class="form-control" type="password" title="Must contain at least one number, one uppercase letter, lowercase letter, one special character, and at least 8 or more characters" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" id="Password" name="Password" placeholder="New Password">
                                        </div>
                                        <small>Keep it empty if you do not want change the password.</small>
                                    </div>

                                    <button class="btn btn-primary btn-block">Update your information</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</body>

</html>