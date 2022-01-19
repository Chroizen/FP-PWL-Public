<?php

if (isset($_POST['update'])) {
  // Definisi Variabel
  $v_IDsekarang = $_POST['IDsekarang'];
  $v_idDigitalMoney = $_POST['idDigitalMoney'];
  $v_jumlahSaldo = $_POST['jumlahSaldo'];


  // Cek Kekosongan Saldo
  if ($v_jumlahSaldo <= 0) {
    setcookie("tempinput", "Nominal tidak valid", time() + 2 * 24 * 60 * 60);
    header('location: ../index.php?kelola=dmoney');
    exit();
  }

  // Bagian Edit
  $query = mysqli_query($koneksi, "UPDATE digitalmoney SET idDigitalMoney='$v_idDigitalMoney', jumlahSaldo='$v_jumlahSaldo' WHERE idDigitalMoney='$v_IDsekarang'") or die($koneksi);

  if ($query) {
    setcookie("tempinput", "Edit Data Digital Money Berhasil", time() + 2 * 24 * 60 * 60);
    header('location: ../index.php?kelola=dmoney');
  } else {
    setcookie("tempinput", "Edit Gagal. Hubungi Admin", time() + 2 * 24 * 60 * 60);
    header('location: ../index.php?kelola=dmoney');
  }
};


if (isset($_POST['hapus'])) {

  $v_idDigitalMoney = $_POST['idDigitalMoney'];

  $query = mysqli_query($koneksi, "SELECT * FROM digitalmoney WHERE idDigitalMoney='$v_idDigitalMoney'");
  $array = mysqli_fetch_array($query);

  // echo $array['idDigitalMoney'];

  $query = mysqli_query($koneksi, "DELETE FROM digitalmoney WHERE idDigitalMoney='$v_idDigitalMoney'");

  if ($query) {
    setcookie("tempinput", "Hapus Berhasil", time() + 2 * 24 * 60 * 60);
    header('location: ../index.php?kelola=dmoney');
  } else {
    setcookie("tempinput", "Hapus Gagal. Hubungi Admin", time() + 2 * 24 * 60 * 60);
    header('location: ../index.php?kelola=dmoney');
  }
};

?>

<!-- isi konten disini -->
<div class="container-fluid">
  <h3 class="text-dark mb-4">DATA DIGITAL MONEY</h3>
  <div class="card shadow">

    <div class="card-header py-3">
      <div id="" class="col-md-6 text-nowrap" style="padding:0;">
        <input data-toggle="modal" data-target="#myModal" class="btn btn-primary" type="submit"
          value="Tambah Data Digital Money">
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
              <th>ID Digital Money</th>
              <th>Username</th>
              <th>Jumlah Saldo</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; ?>
            <?php
            $tampil = mysqli_query($koneksi, "SELECT * FROM digitalmoney");
            while ($record = mysqli_fetch_array($tampil)) {
              $v_idDigitalMoney = $record['0'];
            ?>
            <tr>
              <td><?= $i; ?></td>
              <td><?= $record['0']; ?></td>
              <td><?= $record['1']; ?></td>
              <td>Rp. <?= $record['2']; ?></td>
              <td>
                <button data-toggle="modal" data-target="#edit<?= $v_idDigitalMoney; ?>"
                  class="btn btn-success editbtn">Edit</button>

                <button data-toggle="modal" data-target="#del<?= $v_idDigitalMoney; ?>"
                  class="btn btn-danger">Del</button>
              </td>
            </tr>


            <!-- The modal EDIT-->
            <div class="modal fade" id="edit<?= $v_idDigitalMoney; ?>">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form action="" method="POST">
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Edit Data Digital Money <?php echo $record['0'] ?> -
                        <?php echo $record['1'] ?> - <?php echo $record['2'] ?></h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                      <label for="idDigitalMoney">ID Digital Money</label>
                      <input name="IDsekarang" id="IDsekarang" type="text" class="form-control" hidden
                        value="<?php echo $record['idDigitalMoney'] ?>">
                      <input name="idDigitalMoney" id="idDigitalMoney" type="text" class="form-control"
                        value="<?php echo $record['idDigitalMoney'] ?>" disabled>

                      <label for="username">Username</label>
                      <input name="username" id="username" type="text" class="form-control"
                        value="<?php echo $record['username'] ?>" disabled>

                      <label for="jumlahSaldo">Jumlah Saldo</label>
                      <input name="jumlahSaldo" id="jumlahSaldo" type="text" class="form-control"
                        value="<?php echo $record['jumlahSaldo'] ?>">

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
            <div class="modal fade" id="del<?= $v_idDigitalMoney; ?>">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form method="post">
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Hapus Admin <?php echo $record['0'] ?> -
                        <?php echo $record['username'] ?> - <?php echo $record['jumlahSaldo'] ?></h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                      Apakah Anda yakin ingin menghapus Data Digital Money ini dari daftar?
                      <input type="hidden" name="idDigitalMoney" value="<?= $v_idDigitalMoney; ?>">
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


    <!-- modal input insert -->
    <div id="myModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Tambahkan Data Digital Money</h4>
          </div>

          <div class="modal-body">
            <form action="tambah/tdmoney.php" method="post">
              <div class="form-group">
                <label>ID Digital Money</label>
                <input name="idDigitalMoney" type="text" class="form-control" placeholder="ID Digital Money" required>
              </div>

              <div class="form-group">
                <label>Username</label>
                <input name="username" type="text" class="form-control" placeholder="Username" required>
              </div>

              <div class="form-group">
                <label>Jumlah Saldo</label>
                <input name="jumlahSaldo" type="text" class="form-control" placeholder="Jumlah Saldo" required>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <input type="submit" class="btn btn-primary" value="Simpan">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>