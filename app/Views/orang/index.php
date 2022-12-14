<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
  <div class="row">
    <div class="col-6">
      <h1 class="mt-2">List People</h1>
      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Search..." name="keyword">
          <button class="btn btn-outline-secondary" type="submit" name="submit" id="button-addon2">Search</button>
        </div>
      </form>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nama</th>
            <th scope="col">Alamat</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = (10 * ($current_page - 1)) + 1; ?>
          <?php foreach ($orang as $o) : ?>
            <tr>
              <th scope="row"><?= $i++ ?></th>
              <td><?= $o['nama'] ?></td>
              <td><?= $o['alamat'] ?></td>
              <td>
                <a href="" class="btn btn-success">Detail</a>
              </td>
            <?php endforeach; ?>
            </tr>
        </tbody>
      </table>

      <?= $pager->links('orang', 'orang_pagination'); ?>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>