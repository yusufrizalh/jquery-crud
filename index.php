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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-3">
                <h3>Manage Table Users</h3>
                <hr class="ma-hr">
                <!-- membuat tombol tambah data -->
                <div class="float-right">
                    <a href="javascript:void(0);" class="btn btn-success" data-type="add" data-toggle="modal"
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

    <!-- membuat form untuk menambah dan mengubah data -->
    <div class="modal fade" id="modalUserAddEdit" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- modal header -->
                <div class="modal-header">
                    <h4 class="modal-title">Menambah User Baru</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- modal body -->
                <div class="modal-body">
                    <div class="statusMsg"></div>
                    <form role="form">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" name="name" id="name" 
                                placeholder="Tuliskan nama">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="Tuliskan email">
                        </div>
                        <div class="form-group">
                            <label for="phone">Telepon</label>
                            <input type="text" class="form-control" name="phone" id="phone"
                                placeholder="Tuliskan telepon">
                        </div>
                        <input type="hidden" class="form-control" name="id" id="id" />
                    </form>
                </div>

                <!-- modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="userSubmit">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- import jQuery dan dataTables -->
    <script src="./js/jquery-3.4.1.min.js"></script>
    <script src="./js/jquery.dataTables.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        function getUsers() {
            $.ajax({
                type: 'POST', 
                url: 'userAction.php', 
                data: 'action_type=view', 
                success: function(html) {
                    $('#userData').html(html);
                }
            });
        }

        
    </script>
</body>

</html>