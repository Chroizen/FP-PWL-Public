<?php

if (isset($_POST['update'])) {
  // Definisi Variabel
  $v_IDsekarang = $_POST['IDsekarang'];
  $v_idReview = $_POST['idReview'];
  $v_idJob = $_POST['idJob'];
  $v_username = $_POST['username'];
  $v_desc_review = $_POST['desc_review'];
  $v_rating = $_POST['rating'];

  // Cek Kekosongan Data
  if (empty($v_IDsekarang) || empty($v_idReview) || empty($v_idJob) || empty($v_username) || empty($v_desc_review) || empty($v_rating)) {
    setcookie("tempinput", "Ada data yang kosong. Mohon periksa kembali", time() + 2 * 24 * 60 * 60);

    header('location: index.php?kelola=review');
    exit();
  }

  // Cek Ketersediaan ID Job
  $query = mysqli_query($koneksi, "SELECT * FROM jobs WHERE idJob='$v_idJob'");
  $temp = mysqli_num_rows($query);
  if ($temp == 0) {
    echo "Data Telah Tersedia";
    setcookie("tempinput", "ID Job Tidak Tersedia. Mohon inputkan ID yang tersedia.", time() + 2 * 24 * 60 * 60);
    header('location: index.php?kelola=review');
    exit();
  }

  // Cek Ketersediaan User
  $query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$v_username'");
  $temp = mysqli_num_rows($query);
  if ($temp == 0) {
    echo "Data Telah Tersedia";
    setcookie("tempinput", "Username Tidak Tersedia. Mohon inputkan yang tersedia.", time() + 2 * 24 * 60 * 60);
    header('location: index.php?kelola=review');
    exit();
  }

  // Bagian Edit
  $query = mysqli_query($koneksi, "UPDATE review SET idReview='$v_idReview', idJob='$v_idJob', rating='$v_rating', username='$v_username', desc_review='$v_desc_review' WHERE idReview='$v_IDsekarang'") or die($koneksi);

  if ($query) {
    setcookie("tempinput", "Edit Data Review Berhasil", time() + 2 * 24 * 60 * 60);
    header('location: index.php?kelola=review');
  } else {
    setcookie("tempinput", "Edit Gagal. Hubungi Admin", time() + 2 * 24 * 60 * 60);
    header('location: index.php?kelola=review');
  }
};



if (isset($_POST['hapus'])) {
  $v_idReview = $_POST['idReview'];

  $query = mysqli_query($koneksi, "SELECT * FROM review WHERE idReview='$v_idReview'");
  $array = mysqli_fetch_array($query);

  // echo $array['idReview'];

  $query = mysqli_query($koneksi, "DELETE FROM review WHERE idReview='$v_idReview'");

  if ($query) {
    setcookie("tempinput", "Hapus Berhasil", time() + 2 * 24 * 60 * 60);
    header('location: index.php?kelola=review');
  } else {
    setcookie("tempinput", "Hapus Gagal. Hubungi Admin", time() + 2 * 24 * 60 * 60);
    header('location: index.php?kelola=review');
  }
};


?>

<div class="container-fluid">
  <h3 class="text-dark mb-4">DATA REVIEW</h3>
  <div class="card shadow">

    <div class="card-header py-3">
      <div id="" class="col-md-6 text-nowrap" style="padding:0;">
        <input data-toggle="modal" data-target="#myModal" class="btn btn-primary" type="submit"
          value="Tambah Data Review">
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
              <th>ID Review</th>
              <th>Nama Job</th>
              <th>Username</th>
              <th>Deskripsi Review</th>
              <th>Rating</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; ?>
            <?php
            $tampil = mysqli_query($koneksi, "SELECT review.*, jobs.nama_job, user.username FROM review
                    JOIN jobs ON jobs.idJob = review.idJob
                    JOIN user ON user.username = review.username");
            while ($record = mysqli_fetch_array($tampil)) {
              $v_idReview = $record['idReview'];
            ?>

            <tr>
              <td><?= $i; ?></td>
              <td><?= $record['0']; ?></td>
              <td><?= $record['nama_job']; ?></td>
              <td><?= $record['username']; ?></td>
              <td><?= $record['3']; ?></td>
              <td><?= $record['4']; ?></td>
              <td>
                <button style="margin-bottom: 3px;" data-toggle="modal" data-target="#edit<?= $v_idReview; ?>"
                  class="btn btn-success editbtn">Edit</button>

                <button data-toggle="modal" data-target="#del<?= $v_idReview; ?>" class="btn btn-danger">Del</button>
              </td>
            </tr>



            <!-- The modal EDIT-->
            <div class="modal fade" id="edit<?= $v_idReview; ?>">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form action="" method="POST">
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Edit Review <?php echo $record['0'] ?> -
                        <?php echo $record['username'] ?> - <?php echo $record['nama_job'] ?></h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                      <label for="idReview">ID Review</label>
                      <input name="IDsekarang" id="IDsekarang" type="text" class="form-control" hidden
                        value="<?php echo $record['idReview'] ?>">
                      <input name="idReview" id="idReview" type="text" class="form-control"
                        value="<?php echo $record['idReview'] ?>">

                      <label for="idJob">ID Job</label>
                      <input name="idJob" id="idJob" type="text" class="form-control"
                        value="<?php echo $record['idJob'] ?>">

                      <label for="username">Username</label>
                      <input name="username" id="username" type="text" class="form-control"
                        value="<?php echo $record['username'] ?>">

                      <label for="desc_review">Desc Review</label>
                      <input name="desc_review" id="desc_review" type="text" class="form-control"
                        value="<?php echo $record['desc_review'] ?>">

                      <label for="rating">rating</label>
                      <input name="rating" id="rating" type="number" class="form-control"
                        value="<?php echo $record['rating'] ?>">
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
            <div class="modal fade" id="del<?= $v_idReview; ?>">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form method="post">
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Hapus Data Review : <?php echo $record['0'] ?> -
                        <?php echo $record['username'] ?> - <?php echo $record['nama_job'] ?></h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                      Apakah Anda yakin ingin menghapus Data Review ini dari daftar?
                      <input type="hidden" name="idReview" value="<?= $v_idReview; ?>">
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
        <h5 class="modal-title" id="myModalLabel">Tambahkan Data Review</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="tambah/treview.php" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label>ID Review</label>
            <input name="idReview" type="text" class="form-control" placeholder="ID Review" required>
          </div>

          <div class="form-group">
            <label>ID Job</label>
            <input name="idJob" type="text" class="form-control" placeholder="ID Job" required>
          </div>

          <div class="form-group">
            <label>Username</label>
            <input name="username" type="text" class="form-control" placeholder="Username" required>
          </div>

          <div class="form-group">
            <label>Desc Review</label>
            <input name="desc_review" type="text" class="form-control" placeholder="Desc Review" required>
          </div>

          <div class="form-group">
            <label>Rating</label>
            <input name="rating" type="text" class="form-control" placeholder="Rating" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <input type="submit" class="btn btn-primary" value="Simpan">
          </div>
        </form>
      </div>
    </div>
  </div>