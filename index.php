<?php
    require_once './inc/user.php';
    $query = new User();
    $users = $query->getRows('users');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRUD with jQuery AJAX</title>
    <!-- import CSS dan Bootstrap -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-3">
                <h3>Manage Table Users</h3>
                <hr class="ma-hr">
                <!-- membuat tombol tambah data -->
                <div class="float-right">
                    <a href="javascript:void(0);" class="btn btn-success" 
                        data-type="add" data-toggle="modal" 
                        data-targe="#modalUserAddEdit">
                    <i class="plus">Buat User Baru</i>
                    </a>
                </div>
            </div>

            <div class="statusMsg"></div>

            <!-- memunculkan data dalam bentuk table -->
            <table class="cn-data-tables">
                <thead class="">
                    <tr>
                        <th>ID</th>
                        <th>NAMA</th>
                        <th>EMAIL</th>
                        <th>TELEPON</th>
                        <th>OPSI</th>
                    </tr>
                </thead>
                <tbody id="userData">
                    <?php
                        if(!empty($users)) {
                            foreach($users as $row) {
                    ?>
                    <tr>
                        <td><?php echo '#' . $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td>
                            <a href="javascript:void(0);">Ubah</a>
                            <a href="javascript:void(0);">Hapus</a>
                        </td>
                    </tr>
                    <?php } 
                    } else { ?>
                    <tr>
                        <td colspan="5">No user(s) found.</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>