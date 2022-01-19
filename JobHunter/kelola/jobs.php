<?php

if (isset($_POST['update'])) {
  // Definisi Variabel
  $v_IDsekarang = $_POST['IDsekarang'];
  $v_idJob = $_POST['idJob'];
  $v_idKategori = $_POST['idKategori'];
  $v_nama_job = $_POST['nama_job'];
  $v_desc_job = $_POST['desc_job'];
  $v_harga_job = $_POST['harga_job'];
  $v_pict = $_POST['pict'];


  // tampung data gambar yang baru
  $filename = $_FILES['thumbnail']['name'];
  if ($filename != "") {
    $tmp_name = $_FILES['thumbnail']['tmp_name'];
    $type = explode('.', $filename);
    $type2 = $type[1];
    $newname = 'thumbnail jobs - ' . time() . '.' . $type2;

    // menampung data format yang diijinkan
    $ekstensi = array('jpg', 'jpeg', 'png', 'gif');
    // validasi : jika ganti gambar apa yang akan dilakukan 
    if ($filename != '') {
      // validasi format file
      if (!in_array($type2, $ekstensi)) {
        echo "<script>
        alert('Format File Salah. Ganti ke jpg, jpeg, png, gif');
        </script>";
      } else {
        unlink('assets/img/thumbnail/' . $pict);
        move_uploaded_file($tmp_name, 'assets/img/thumbnail/' . $newname);
        $namethumbnail = $newname;
      }
    } else {
      // validasi : jika ganti gambar apa yang akan dilakukan 
      $namethumbnail = $pict;
    }

    // Cek Ketersediaan Kategori
    $query = mysqli_query($koneksi, "SELECT * FROM kategorijobs WHERE idKategori='$v_idKategori'");
    $temp = mysqli_num_rows($query);
    if ($temp == 0) {
      echo "Kategori yang di inputkan tidak tersedia";
      setcookie("tempinput", "Kategori yang di inputkan tidak tersedia. Silahkan inputkan kategori terlebih dahulu", time() + 2 * 24 * 60 * 60);
      header('location: ../index.php?kelola=jobs');
      exit();
    }

    // query update data jobs
    // Bagian Edit
    $query = mysqli_query($koneksi, "UPDATE jobs SET idJob='$v_idJob', 
    idKategori='$v_idKategori', 
    thumbnail='$namethumbnail', 
    nama_job='$v_nama_job', 
    desc_job='$v_desc_job', 
    harga_job='$v_harga_job' 
    WHERE idJob='$v_idJob'") or die($koneksi);

    if ($query) {
      setcookie("tempinput", "Edit Data Jobs Berhasil", time() + 2 * 24 * 60 * 60);
      header('location: ../index.php?kelola=jobs');
    } else {
      setcookie("tempinput", "Edit Gagal. Hubungi Admin", time() + 2 * 24 * 60 * 60);
      header('location: ../index.php?kelola=jobs');
    }
  } else {
    $query = mysqli_query($koneksi, "UPDATE jobs SET idJob='$v_idJob', 
    idKategori='$v_idKategori',
    nama_job='$v_nama_job', 
    desc_job='$v_desc_job', 
    harga_job='$v_harga_job' 
    WHERE idJob='$v_idJob'") or die($koneksi);

    if ($query) {
      setcookie("tempinput", "Edit Data Jobs Berhasil", time() + 2 * 24 * 60 * 60);
      header('location: ../index.php?kelola=jobs');
    } else {
      setcookie("tempinput", "Edit Gagal. Hubungi Admin", time() + 2 * 24 * 60 * 60);
      header('location: ../index.php?kelola=jobs');
    }
  }
};



if (isset($_POST['hapus'])) {
  $v_idJob = $_POST['idJob'];

  $query = mysqli_query($koneksi, "SELECT * FROM jobs WHERE idJob='$v_idJob'");
  $array = mysqli_fetch_array($query);

  $query = mysqli_query($koneksi, "DELETE FROM jobs WHERE idJob='$v_idJob'");

  if ($query) {
    setcookie("tempinput", "Hapus Berhasil", time() + 2 * 24 * 60 * 60);
    header('location: ../index.php?kelola=jobs');
  } else {
    setcookie("tempinput", "Hapus Gagal. Hubungi Admin", time() + 2 * 24 * 60 * 60);
    header('location: ../index.php?kelola=jobs');
  }
};

?>


<div class="container-fluid">
  <h3 class="text-dark mb-4">DATA JOBS</h3>
  <div class="card shadow">

    <div class="card-header py-3">
      <div id="" class="col-md-6 text-nowrap" style="padding:0;">
        <input data-toggle="modal" data-target="#myModal" class="btn btn-primary" type="submit"
          value="Tambah Data Jobs">
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
              <th>ID Job</th>
              <th>Kategori Job</th>
              <th>Thumbnail</th>
              <th>Nama Job</th>
              <th>Desc Job</th>
              <th>Harga</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; ?>
            <?php
            $tampil = mysqli_query($koneksi, "SELECT jobs.*, kategorijobs.namaKategori FROM jobs
                    JOIN kategorijobs ON kategorijobs.idKategori = jobs.idKategori");
            while ($record = mysqli_fetch_array($tampil)) {
              $v_idJob = $record['0'];
            ?>

            <tr>
              <td><?= $i; ?></td>
              <td><?= $record['0']; ?></td>
              <td><?= $record['namaKategori']; ?></td>
              <td><img src="assets/img/thumbnail/<?= $record['2']; ?>" width="50px" alt=""></td>
              <td><?= $record['3']; ?></td>
              <td><?= $record['4']; ?></td>
              <td><?= $record['5']; ?></td>
              <td>
                <button style="margin-bottom: 3px;" data-toggle="modal" data-target="#edit<?= $v_idJob; ?>"
                  class="btn btn-success editbtn">Edit</button>

                <button data-toggle="modal" data-target="#del<?= $v_idJob; ?>" class="btn btn-danger">Del</button>
              </td>
            </tr>



            <!-- The modal EDIT-->
            <div class="modal fade" id="edit<?= $v_idJob; ?>">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form action="" method="POST" enctype="multipart/form-data">
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Edit Data Jobs <?php echo $record['0'] ?> -
                        <?php echo $record['3'] ?> || <?php echo $record['namaKategori'] ?> </h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                      <label for="idJob">ID Jobs</label>
                      <input name="IDsekarang" id="IDsekarang" type="text" class="form-control" hidden
                        value="<?php echo $record['idJob'] ?>">
                      <input name="idJob" id="idJob" type="text" class="form-control"
                        value="<?php echo $record['idJob'] ?>">

                      <label for="idKategori">ID Kategori</label>
                      <input name="idKategori" id="idKategori" type="text" class="form-control"
                        value="<?php echo $record['idKategori'] ?>">

                      <label for="thumbnail">Thumbnail</label>
                      <img src="assets/img/thumbnail/<?= $record['thumbnail']; ?>" alt="">
                      <input name="pict" id="pict" type="hidden" class="form-control"
                        value="<?php echo $record['thumbnail'] ?>">
                      <input name="thumbnail" id="thumbnail" type="file" class="form-control"
                        value="<?php echo $record['thumbnail'] ?>">

                      <label for="nama_job">Nama Job</label>
                      <input name="nama_job" id="nama_job" type="text" class="form-control"
                        value="<?php echo $record['nama_job'] ?>">

                      <label for="desc_job">Desc Job</label>
                      <input name="desc_job" id="desc_job" type="text" class="form-control"
                        value="<?php echo $record['desc_job'] ?>">

                      <label for="harga_job">Harga Job</label>
                      <input name="harga_job" id="harga_job" type="text" class="form-control"
                        value="<?php echo $record['harga_job'] ?>">
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
            <div class="modal fade" id="del<?= $v_idJob; ?>">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form method="post">
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Hapus Data Jobs : <?php echo $record['0'] ?> -
                        <?php echo $record['3'] ?> || <?php echo $record['namaKategori'] ?></h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                      Apakah Anda yakin ingin menghapus Data Jobs ini dari daftar?
                      <input type="hidden" name="idJob" value="<?= $v_idJob; ?>">
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
        <h5 class="modal-title" id="myModalLabel">Tambahkan Data Jobs</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="tambah/tjobs.php" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label>ID Job</label>
            <input name="idJob" type="text" class="form-control" placeholder="idJob" required>
          </div>

          <div class="form-group">
            <label>ID Kategori</label>
            <input name="idKategori" type="text" class="form-control" placeholder="ID Kategori" required>
          </div>

          <div class="form-group">
            <label>Thumbnail</label>
            <input name="thumbnail" type="file" class="form-control" placeholder="Thumbnail" required>
          </div>

          <div class="form-group">
            <label>Nama Job</label>
            <input name="nama_job" type="text" class="form-control" placeholder="Nama Job" required>
          </div>

          <div class="form-group">
            <label>Desc Job</label>
            <input name="desc_job" type="text" class="form-control" placeholder="Desc Job" required>
          </div>

          <div class="form-group">
            <label>Harga Job</label>
            <input name="harga_job" type="text" class="form-control" placeholder="Harga Job" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <input type="submit" class="btn btn-primary" value="Simpan">
          </div>
        </form>
      </div>
    </div>
  </div>