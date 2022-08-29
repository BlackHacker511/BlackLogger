<?php
include_once 'session.php';
include_once 'logic/links.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Links Management - BlackLogger</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body>

    <?php include_once 'components/header.php'; ?>

    <main>
        <div class="container-fluid px-4">
            <ol class="breadcrumb mb-4 mt-4">
                <li class="breadcrumb-item active">Links Management</li>
            </ol>

            <?php if (isset($message)) :  ?>
                <div class="alert alert-success" role="alert">
                    <i class="fa-solid fa-circle-xmark"></i> Link has been deleted
                </div>
            <?php endif; ?>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Links Management
                </div>
                <div class="card-body">
                    <table id="table">
                        <thead>
                            <tr>
                                <th>Long Link</th>
                                <th>Shot Code</th>
                                <th>Hits</th>
                                <th>Manage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($links as $l) : ?>
                                <tr>
                                    <td><?php echo $l->long_url; ?></td>
                                    <td>
                                        <a href="/goto.php?c=<?php echo $l->short_code ?>">
                                            <?php echo $l->short_code; ?>
                                        </a>
                                    </td>
                                    <td><?php echo $l->hits; ?></td>
                                    <td>
                                        <a href="edit.php?sc=<?php echo $l->short_code ?>&t=<?php echo $_SESSION['csrf']; ?>">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="delete.php?c=<?php echo $l->short_code ?>&t=<?php echo $_SESSION['csrf']; ?>"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" id="addLink">Add Link</button>
                </div>
            </div>
        </div>
    </main>

    <?php include_once 'components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables.js"></script>
    <script>
        let addbutton = document.getElementById("addLink");
        let updatebutton = document.getElementById("updateLink");

        addbutton.addEventListener("click", () => {
            let longUrl = prompt("Please enter long url");

            if (longUrl != null) {
                $.post(
                    "api/addLink.php", {
                        longUrl: longUrl,
                    },
                    function(response) {
                        if (JSON.parse(response)["response"] == true) {
                            location.reload();
                        }
                    }
                );
            }

            return;
        });


        updatebutton.addEventListener("click", () => {
            alert("button clicked");
        });
    </script>
</body>

</html>