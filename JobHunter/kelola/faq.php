<?php

if (isset($_POST['update'])) {
  // Definisi Variabel
  $v_IDsekarang = $_POST['IDsekarang'];
  $v_idFaq = $_POST['idFaq'];
  $v_usernameAdmin = $_POST['usernameAdmin'];
  $v_namaFaq = $_POST['namaFaq'];
  $v_desc_faq = $_POST['desc_faq'];

  // Cek Kekosongan Data
  if (empty($v_IDsekarang) || empty($v_idFaq) || empty($v_usernameAdmin) || empty($v_namaFaq) || empty($v_desc_faq)) {
    setcookie("tempinput", "Ada data yang kosong. Mohon periksa kembali", time() + 2 * 24 * 60 * 60);

    header('location: ../index.php?kelola=faq');
    exit();
  }

  // Cek Ketersediaan ID
  $query = mysqli_query($koneksi, "SELECT * FROM faq WHERE idFaq='$v_idFaq'");
  $temp = mysqli_num_rows($query);
  if ($temp == 0) {
    echo "Data Telah Tersedia";
    setcookie("tempinput", "ID FaQ Tidak Tersedia. Mohon inputkan ID yang tersedia.", time() + 2 * 24 * 60 * 60);
    header('location: ../index.php?kelola=faq');
    exit();
  }

  // Cek Ketersediaan User
  $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE usernameAdmin='$v_usernameAdmin'");
  $temp = mysqli_num_rows($query);
  if ($temp == 0) {
    echo "Data Telah Tersedia";
    setcookie("tempinput", "Username Admin Tidak Tersedia. Mohon inputkan yang tersedia.", time() + 2 * 24 * 60 * 60);
    header('location: ../index.php?kelola=faq');
    exit();
  }

  // Bagian Edit
  $query = mysqli_query($koneksi, "UPDATE faq SET idFaq='$v_idFaq', desc_faq='$v_desc_faq', usernameAdmin='$v_usernameAdmin', namaFaq='$v_namaFaq' WHERE idFaq='$v_IDsekarang'") or die($koneksi);

  if ($query) {
    setcookie("tempinput", "Edit Data FaQ Berhasil", time() + 2 * 24 * 60 * 60);
    header('location: faq.php');
  } else {
    setcookie("tempinput", "Edit Gagal. Hubungi Admin", time() + 2 * 24 * 60 * 60);
    header('location: ../index.php?kelola=faq');
  }
};

if (isset($_POST['hapus'])) {
  $v_idFaq = $_POST['idFaq'];

  $query = mysqli_query($koneksi, "SELECT * FROM faq WHERE idFaq='$v_idFaq'");
  $array = mysqli_fetch_array($query);

  // echo $array['idFaq'];

  $query = mysqli_query($koneksi, "DELETE FROM faq WHERE idFaq='$v_idFaq'");



  if ($query) {
    setcookie("tempinput", "Hapus Berhasil", time() + 2 * 24 * 60 * 60);
    header('location: ?kelola=faq');
  } else {
    setcookie("tempinput", "Hapus Gagal. Hubungi Admin", time() + 2 * 24 * 60 * 60);
    header('location: ?kelola=faq');
  }
};


?>


<div class="container-fluid">
  <h3 class="text-dark mb-4">DATA FAQ</h3>
  <div class="card shadow">

    <div class="card-header py-3">
      <div id="" class="col-md-6 text-nowrap" style="padding:0;">
        <input data-toggle="modal" data-target="#myModal" class="btn btn-primary" type="submit" value="Tambah Data FAQ">
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
              <th>ID FAQ</th>
              <th>Username Admin</th>
              <th>Judul FAQ</th>
              <th>Desc FAQ</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; ?>
            <?php
            $tampil = mysqli_query($koneksi, "SELECT faq.*, admin.usernameAdmin FROM faq
                    JOIN admin ON admin.usernameAdmin = faq.usernameAdmin");
            while ($record = mysqli_fetch_array($tampil)) {
              $v_idFaq = $record['0'];
            ?>

            <tr>
              <td><?= $i; ?></td>
              <td><?= $record['0']; ?></td>
              <td><?= $record['usernameAdmin']; ?></td>
              <td><?= $record['2']; ?></td>
              <td><?= $record['3']; ?></td>
              <td>
                <button style="margin-bottom: 3px;" data-toggle="modal" data-target="#edit<?= $v_idFaq; ?>"
                  class="btn btn-success editbtn">Edit</button>

                <button data-toggle="modal" data-target="#del<?= $v_idFaq; ?>" class="btn btn-danger">Del</button>
              </td>
            </tr>


            <!-- The modal EDIT-->
            <div class="modal fade" id="edit<?= $v_idFaq; ?>">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form action="" method="POST">
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Edit FAQ <?php echo $record['0'] ?> -
                        <?php echo $record['2'] ?> || <?php echo $record['1'] ?></h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                      <label for="idFaq">ID FAQ</label>
                      <input name="IDsekarang" id="IDsekarang" type="text" class="form-control"
                        value="<?php echo $record['idFaq'] ?>">
                      <input name="idFaq" id="idFaq" type="text" class="form-control"
                        value="<?php echo $record['idFaq'] ?>">

                      <label for="usernameAdmin">Username Admin</label>
                      <input name="usernameAdmin" id="usernameAdmin" type="text" class="form-control"
                        value="<?php echo $record['usernameAdmin'] ?>">

                      <label for="namaFaq">Nama FAQ</label>
                      <input name="namaFaq" id="namaFaq" type="text" class="form-control"
                        value="<?php echo $record['namaFaq'] ?>">

                      <label for="desc_faq">Desc FAQ</label>
                      <input name="desc_faq" id="desc_faq" type="text" class="form-control"
                        value="<?php echo $record['desc_faq'] ?>">

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
            <div class="modal fade" id="del<?= $v_idFaq; ?>">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form method="post">
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Hapus FAQ <?php echo $record['0'] ?> -
                        <?php echo $record['2'] ?> - <?php echo $record['1'] ?></h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                      Apakah Anda yakin ingin menghapus FAQ ini dari daftar?
                      <input type="hidden" name="idFaq" value="<?= $v_idFaq; ?>">
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

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Tambahkan Data FAQ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="tambah/tfaq.php" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label>ID FAQ</label>
            <input name="idFaq" type="text" class="form-control" placeholder="ID FAQ" required>
          </div>

          <div class="form-group">
            <label>Username Admin</label>
            <input name="usernameAdmin" type="text" class="form-control" placeholder="Username Admin" required>
          </div>

          <div class="form-group">
            <label>Nama FAQ</label>
            <input name="namaFaq" type="text" class="form-control" placeholder="Nama FAQ" required>
          </div>

          <div class="form-group">
            <label>Desc FAQ</label>
            <input name="desc_faq" type="text" class="form-control" placeholder="Desc FAQ" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <input type="submit" class="btn btn-primary" value="Simpan">
          </div>
        </form>
      </div>
    </div>
  </div>