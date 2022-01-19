<?php
if (isset($_POST['update'])) {
  // Definisi Variabel
  $v_username = $_POST['usernameAdmin'];
  $v_password = $_POST['password'];
  $v_fulln = $_POST['nama_lengkap'];
  $v_email = $_POST['email'];
  $v_nohp = $_POST['no_hp'];
  $v_alamat = $_POST['alamat'];

  // Cek Kekosongan Data
  if (empty($v_username) || empty($v_password) || empty($v_fulln) || empty($v_email) || empty($v_nohp) || empty($v_alamat)) {
    setcookie("tempinput", "Ada data yang kosong. Mohon periksa kembali", time() + 2 * 24 * 60 * 60);
    header('location: ../index.php?kelola=admin');
    exit();
  }

  // Bagian Edit
  $query = mysqli_query($koneksi, "UPDATE admin SET usernameAdmin='$v_username', 
  password='$v_password', 
  nama_lengkap='$v_fulln', 
  email='$v_email', 
  no_hp='$v_nohp', 
  alamat='$v_alamat' 
  WHERE usernameAdmin='$v_username'");

  if ($query) {
    setcookie("tempinput", "Edit Data Admin Berhasil", time() + 2 * 24 * 60 * 60);
    header('location: ../index.php?kelola=admin');
  } else {
    setcookie("tempinput", "Edit Gagal. Hubungi Admin", time() + 2 * 24 * 60 * 60);
    header('location: ../index.php?kelola=admin');
  }
};


if (isset($_POST['hapus'])) {
  $v_username = $_POST['usernameAdmin'];
  $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE usernameAdmin='$v_username'");
  $array = mysqli_fetch_array($query);

  echo $array['username'];

  $query = mysqli_query($koneksi, "DELETE FROM admin WHERE usernameAdmin='$v_username'");

  if ($query) {
    setcookie("tempinput", "Hapus Berhasil", time() + 2 * 24 * 60 * 60);
    header('location: index.php?kelola=admin');
  } else {
    setcookie("tempinput", "Hapus Gagal. Hubungi Admin", time() + 2 * 24 * 60 * 60);
    header('location: index.php?kelola=admin');
  }
};

?>

<div class="container-fluid">
  <h3 class="text-dark mb-4">DATA ADMIN</h3>
  <div class="card shadow">

    <div class="card-header py-3">
      <div id="" class="col-md-6 text-nowrap" style="padding:0;">
        <input data-toggle="modal" data-target="#myModal" class="btn btn-primary" type="submit"
          value="Tambah Data Admin">
      </div>
    </div>




    <div class="card-body">

      <div class="row">
        <div class="col-md-6 text-nowrap">
          <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable">
            <label>Show&nbsp;<select class="form-control form-control-sm custom-select custom-select-sm">
                <option value="10" selected="">20</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
              </select>&nbsp;</label>
          </div>
        </div>

        <div class="col-md-6">
          <div class="text-md-right dataTables_filter" id="dataTable_filter">
            <label><input type="search" class="form-control form-control-sm" aria-controls="dataTable"
                placeholder="Search"></label>
          </div>
        </div>
      </div>



      <!-- TABEL DATA -->
      <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
        <table class="table my-0" id="dataTable">
          <thead>
            <tr>
              <th>No</th>
              <th>Username</th>
              <th>Password</th>
              <th>Nama Lengkap</th>
              <th>Email</th>
              <th>No. Hp</th>
              <th>Alamat</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; ?>
            <?php
            $tampil = mysqli_query($koneksi, "SELECT * FROM admin ORDER BY usernameAdmin ASC");
            while ($record = mysqli_fetch_array($tampil)) {
              $v_username = $record['usernameAdmin'];
            ?>

            <tr>
              <td><?= $i; ?></td>
              <td><?= $record['0']; ?></td>
              <td width="80"><?php
                                // $pw = strlen(password_hash($record['password'], PASSWORD_DEFAULT));
                                $pw = strlen($record['password']);
                                $loop = 0;
                                while ($loop != $pw) {
                                  echo "*";
                                  $loop++;
                                } ?></td>
              <td><?= $record['2']; ?></td>
              <td><?= $record['3']; ?></td>
              <td><?= $record['4']; ?></td>
              <td><?= $record['5']; ?></td>
              <td>
                <button style="margin-bottom: 3px;" data-toggle="modal" data-target="#edit<?= $v_username; ?>"
                  class="btn btn-success editbtn">Edit</button>

                <button data-toggle="modal" data-target="#del<?= $v_username; ?>" class="btn btn-danger">Del</button>
              </td>
            </tr>

            <!-- The modal EDIT-->
            <div class="modal fade" id="edit<?= $v_username; ?>">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form action="" method="POST">
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Edit Admin <?php echo $record['usernameAdmin'] ?> -
                        <?php echo $record['email'] ?></h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                      <label for="usernameAdmin">Username Admin</label>
                      <input name="usernameAdmin" id="usernameAdmin" type="text" class="form-control"
                        value="<?php echo $record['usernameAdmin'] ?>">

                      <label for="password">Password</label>
                      <input name="password" id="password" type="password" class="form-control"
                        value="<?php echo $record['password'] ?>">

                      <label for="nama_lengkap">Nama Lengkap</label>
                      <input name="nama_lengkap" id="nama_lengkap" type="text" class="form-control"
                        value="<?php echo $record['nama_lengkap'] ?>">

                      <label for="email">email</label>
                      <input name="email" id="email" type="text" class="form-control"
                        value="<?php echo $record['email'] ?>">

                      <label for="no_hp">No Hp</label>
                      <input name="no_hp" id="no_hp" type="text" class="form-control"
                        value="<?php echo $record['no_hp'] ?>">

                      <label for="alamat">alamat</label>
                      <input name="alamat" id="alamat" type="text" class="form-control"
                        value="<?php echo $record['alamat'] ?>">
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-success" name="update">Simpan Edit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <!-- The Modal Hapus-->
            <div class="modal fade" id="del<?= $v_username; ?>">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form method="post">
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Hapus Admin <?php echo $record['usernameAdmin'] ?> -
                        <?php echo $record['email'] ?> - <?php echo $record['nama_lengkap'] ?></h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                      Apakah Anda yakin ingin menghapus Admin ini dari daftar?
                      <input type="hidden" name="usernameAdmin" value="<?= $v_username; ?>">
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-success" name="hapus">Hapus</button>
                    </div>

                  </form>
                </div>
              </div>
            </div>


            <?php $i++; ?>
            <?php } ?>
          </tbody>
        </table>
      </div>

      <div class="row">
        <div class="col-md-6 align-self-center">
          <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Showing 1 to 20 of 27
          </p>
        </div>

        <div class="col-md-6">
          <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
            <ul class="pagination">
              <li class="page-item disabled">
                <a class="page-link" href="#" aria-label="Previous">
                  <span aria-hidden="true">«</span>
                </a>
              </li>
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#" aria-label="Next">
                  <span aria-hidden="true">»</span></a>
              </li>
            </ul>
          </nav>
        </div>
      </div>

    </div>
  </div>
</div>



<!-- Modal input insert-->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Tambahkan Data Admin</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="tambah/tadmin.php" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label>Username</label>
            <input name="usernameAdmin" type="text" class="form-control" placeholder="Username" required>
          </div>

          <div class="form-group">
            <label>Password</label>
            <input name="password" type="password" class="form-control" placeholder="Password" required>
          </div>

          <div class="form-group">
            <label>Nama Lengkap</label>
            <input name="nama_lengkap" type="text" class="form-control" placeholder="Nama Lengkap" required>
          </div>

          <div class="form-group">
            <label>Email</label>
            <input name="email" type="text" class="form-control" placeholder="Email" required>
          </div>

          <div class="form-group">
            <label>No Hp</label>
            <input name="no_hp" type="text" class="form-control" placeholder="No Hp" required>
          </div>

          <div class="form-group">
            <label>Alamat</label>
            <input name="alamat" type="text" class="form-control" placeholder="Alamat" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <input type="submit" class="btn btn-primary" value="Simpan">
          </div>
        </form>
      </div>
    </div>
  </div>


  <script src="../jquery.min.js"></script>