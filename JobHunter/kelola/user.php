<?php


if (isset($_POST['update'])) {
  // Definisi Variabel
  $v_username = $_POST['username'];
  $v_password = $_POST['password'];
  $v_fulln = $_POST['nama_lengkap'];
  $v_email = $_POST['email'];
  $v_nohp = $_POST['no_hp'];
  $v_alamat = $_POST['alamat'];

  if ($_POST['idStatusUser'] == 1) {
    $v_idStatusUser = "STU-1";
  } else if ($_POST['idStatusUser'] == 2) {
    $v_idStatusUser = "STU-2";
  }

  echo $v_username;

  // Cek Kekosongan Data
  if (empty($v_username) || empty($v_password) || empty($v_fulln) || empty($v_email) || empty($v_nohp) || empty($v_alamat)) {
    setcookie("tempinput", "Ada data yang kosong. Mohon periksa kembali", time() + 2 * 24 * 60 * 60);
    header('location: index.php?kelola=user');
    exit();
  }

  // Bagian Edit
  $query = mysqli_query($koneksi, "UPDATE user SET username='$v_username', password='$v_password', nama_lengkap='$v_fulln', email='$v_email', no_hp='$v_nohp', alamat='$v_alamat', idStatusUser='$v_idStatusUser' WHERE username='$v_username'");
  if ($query) {
    setcookie("tempinput", "Edit Data User Berhasil", time() + 2 * 24 * 60 * 60);
    header('location: index.php?kelola=user');
  } else {
    setcookie("tempinput", "Edit Gagal. Hubungi Admin", time() + 2 * 24 * 60 * 60);
    header('location: index.php?kelola=user');
  }
};



if (isset($_POST['hapus'])) {
  $v_username = $_POST['username'];

  $query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$v_username'");
  $array = mysqli_fetch_array($query);

  echo $array['username'];

  $query = mysqli_query($koneksi, "DELETE FROM user WHERE username='$v_username'");

  if ($query) {
    setcookie("tempinput", "Hapus Berhasil", time() + 2 * 24 * 60 * 60);
    header('location: index.php?kelola=user');
  } else {
    setcookie("tempinput", "Hapus Gagal. Hubungi Admin", time() + 2 * 24 * 60 * 60);
    header('location: index.php?kelola=user');
  }
};


?>


<!-- isi konten disini -->
<div class="container-fluid">
  <h3 class="text-dark mb-4">DATA USER</h3>
  <div class="card shadow">

    <div class="card-header py-3">
      <div id="" class="col-md-6 text-nowrap" style="padding:0;">
        <input data-toggle="modal" data-target="#myModal" class="btn btn-primary" type="submit"
          value="Tambah Data User">
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
          <div class="text-md-right dataTables_filter" id="dataTable_filter"><label><input type="search"
                class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search"></label>
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
              <th>Status User</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; ?>
            <?php
            $tampil = mysqli_query($koneksi, "SELECT user.*, statususer.namaStatus FROM user
                    JOIN statususer ON statususer.idStatusUser = user.idStatusUser");
            while ($record = mysqli_fetch_array($tampil)) {
              $v_username = $record['0'];
            ?>
            <tr>

              <td><?= $i; ?></td>
              <td><?= $record['0']; ?></td>
              <td><?php
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
              <td><?= $record['namaStatus']; ?></td>
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
                      <h4 class="modal-title">Edit User : <?php echo $record['0'] ?> -
                        <?php echo $record['2'] ?></h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                      <div class="form-group">
                        <label for="username">Username</label>
                        <input name="username" id="username" type="text" class="form-control"
                          value="<?php echo $record['username'] ?>">
                      </div>

                      <div class="form-group">
                        <label for="password">Password</label>
                        <input name="password" id="password" type="password" class="form-control"
                          value="<?php echo $record['password'] ?>">
                      </div>

                      <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input name="nama_lengkap" id="nama_lengkap" type="text" class="form-control"
                          value="<?php echo $record['nama_lengkap'] ?>">
                      </div>

                      <div class="form-group">
                        <label for="email">email</label>
                        <input name="email" id="email" type="email" class="form-control"
                          value="<?php echo $record['email'] ?>">
                      </div>

                      <div class="form-group">
                        <label for="no_hp">No Hp</label>
                        <input name="no_hp" id="no_hp" type="text" class="form-control"
                          value="<?php echo $record['no_hp'] ?>">
                      </div>
                      <div class="form-group">
                        <label for="alamat">alamat</label>
                        <input name="alamat" id="alamat" type="text" class="form-control"
                          value="<?php echo $record['alamat'] ?>">
                      </div>
                      <div class="form-group">
                        <label for="">Status User</label>
                        <select name="idStatusUser" id="" class="custom-select form-control">
                          <?php if ($record['idStatusUser'] == "STU-1") { ?>
                          <option value="1" selected name="idStatusUser">Premium</option>
                          <option value="2" name="idStatusUser">Reguler</option>
                          <?php } else if ($record['idStatusUser'] == "STU-2") { ?>
                          <option value="1" name="idStatusUser">Premium</option>
                          <option value="2" selected name="idStatusUser">Reguler</option>
                          <?php } ?>

                        </select>
                      </div>

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
                      <h4 class="modal-title">Hapus User <?php echo $record['0'] ?> -
                        <?php echo $record['3'] ?> - <?php echo $record['namaStatus'] ?></h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                      Apakah Anda yakin ingin menghapus Data User ini dari daftar?
                      <input type="hidden" name="username" value="<?= $v_username; ?>">
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


    <!-- Modal input insert-->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">Tambahkan Data User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="tambah/tuser.php" method="post">
              <div class="form-group">
                <label>Username</label>
                <input name="username" type="text" class="form-control" placeholder="Username" required>
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
                <input name="email" type="email" class="form-control" placeholder="Email" required>
              </div>

              <div class="form-group">
                <label>No Hp</label>
                <input name="no_hp" type="text" class="form-control" placeholder="No Hp" required>
              </div>

              <div class="form-group">
                <label>Alamat</label>
                <input name="alamat" type="text" class="form-control" placeholder="Alamat" required>
              </div>

              <div class="form-group">
                <label for="">Status User</label>
                <select name="idStatusUser" id="" class="custom-select form-control">

                  <option selected name="idStatusUser">Status User</option>
                  <option value="1" name="idStatusUser">STU-1 (Penjual)</option>
                  <option value="2" name="idStatusUser">STU-2 (Pembeli)</option>

                </select>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <input type="submit" class="btn btn-primary" value="Simpan">
              </div>
            </form>
          </div>
        </div>
      </div>