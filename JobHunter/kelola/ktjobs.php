<?php

if (isset($_POST['update'])) {
  // Definisi Variabel
  $v_IDsekarang = $_POST['IDsekarang'];
  $v_idKategori = $_POST['idKategori'];
  $v_namaKategori = $_POST['namaKategori'];

  // Cek Kekosongan Data
  if (empty($v_IDsekarang) || empty($v_idKategori) || empty($v_namaKategori)) {
    setcookie("tempinput", "Ada data yang kosong. Mohon periksa kembali", time() + 2 * 24 * 60 * 60);

    header('location: ../index.php?kelola=ktjobs');
    exit();
  }

  // // Cek Ketersediaan ID Job
  // $query = mysqli_query($koneksi, "SELECT * FROM kategorijobs WHERE idKategori='$v_idKategori'");
  // $temp = mysqli_num_rows($query);
  // if ($temp != 0) {
  //   // echo "Data Telah Tersedia";
  //   setcookie("tempinput", "ID Telah Tersedia. Mohon inputkan ID yang lain.", time() + 2 * 24 * 60 * 60);
  //   header('location: ../index.php?kelola=admin');
  //   exit();
  // }

  // Bagian Edit
  $query = mysqli_query($koneksi, "UPDATE kategorijobs SET idKategori='$v_idKategori', namaKategori='$v_namaKategori' WHERE idKategori='$v_idKategori'") or die($koneksi);

  if ($query) {
    setcookie("tempinput", "Edit Data Kategori Jobs Berhasil", time() + 2 * 24 * 60 * 60);
    header('location: ../index.php?kelola=ktjobs');
  } else {
    setcookie("tempinput", "Edit Gagal. Hubungi Admin", time() + 2 * 24 * 60 * 60);
    header('location: ../index.php?kelola=ktjobs');
  }
};


if (isset($_POST['hapus'])) {
  $v_idKategori = $_POST['idKategori'];

  $query = mysqli_query($koneksi, "SELECT * FROM kategorijobs WHERE idKategori='$v_idKategori'");
  $array = mysqli_fetch_array($query);

  $query = mysqli_query($koneksi, "DELETE FROM kategorijobs WHERE idKategori='$v_idKategori'");

  if ($query) {
    setcookie("tempinput", "Hapus Berhasil", time() + 2 * 24 * 60 * 60);
    header('location: index.php?kelola=ktjobs');
  } else {
    setcookie("tempinput", "Hapus Gagal. Hubungi Admin", time() + 2 * 24 * 60 * 60);
    header('location: index.php?kelola=ktjobs');
  }
};

?>

<div class="container-fluid">
  <h3 class="text-dark mb-4">DATA KATEGORI JOBS</h3>
  <div class="card shadow">

    <div class="card-header py-3">
      <div id="" class="col-md-6 text-nowrap" style="padding:0;">
        <input data-toggle="modal" data-target="#myModal" class="btn btn-primary" type="submit"
          value="Tambah Data Kategori Jobs">
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
              <th>ID Kategori</th>
              <th>Nama Kategori</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; ?>
            <?php
            $tampil = mysqli_query($koneksi, "SELECT * FROM kategorijobs");
            while ($record = mysqli_fetch_array($tampil)) {
              $v_idKategori = $record['idKategori']
            ?>

            <tr>
              <td><?= $i; ?></td>
              <td><?= $record['0']; ?></td>
              <td><?= $record['1']; ?></td>
              <td>
                <button data-toggle="modal" data-target="#edit<?= $v_idKategori; ?>"
                  class="btn btn-success editbtn">Edit</button>

                <button data-toggle="modal" data-target="#del<?= $v_idKategori; ?>" class="btn btn-danger">Del</button>
              </td>
            </tr>



            <!-- The modal EDIT-->
            <div class="modal fade" id="edit<?= $v_idKategori; ?>">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form action="" method="POST">
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Edit Kategori Jobs <?php echo $record['0'] ?> -
                        <?php echo $record['1'] ?></h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                      <label for="usernameAdmin">ID Kategori</label>
                      <input name="IDsekarang" id="IDsekarang" type="text" class="form-control" hidden
                        value="<?php echo $record['idKategori'] ?>">
                      <input name="idKategori" id="idKategori" type="text" class="form-control"
                        value="<?php echo $record['idKategori'] ?>">

                      <label for="namaKategori">Nama Kategori</label>
                      <input name="namaKategori" id="namaKategori" type="text" class="form-control"
                        value="<?php echo $record['namaKategori'] ?>">
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
            <div class="modal fade" id="del<?= $v_idKategori; ?>">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form method="post">
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Hapus Kategori Jobs : <?php echo $record['0'] ?> -
                        <?php echo $record['1'] ?></h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                      Apakah Anda yakin ingin menghapus Kategori Jobs ini dari daftar?
                      <input type="hidden" name="idKategori" value="<?= $v_idKategori; ?>">
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

<!-- Modal input insert -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Tambahkan Data Kategori Jobs</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="tambah/tktjobs.php" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label>ID Kategori</label>
            <input name="idKategori" type="text" class="form-control" placeholder="ID Kategori" required>
          </div>

          <div class="form-group">
            <label>Nama Kategori</label>
            <input name="namaKategori" type="text" class="form-control" placeholder="Nama Kategori" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <input type="submit" class="btn btn-primary" value="Simpan">
          </div>
        </form>
      </div>
    </div>
  </div>