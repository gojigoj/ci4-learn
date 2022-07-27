<?php $this->extend('layout/template'); ?>


<?= $this->section('content'); ?>
<div class="container">
  <div class="row">
    <div class="col">
      <h2 class="mt-2">Comic Detail</h2>
      <div class="card mb-3" style="max-width: 540px;">
        <div class="row g-0">
          <div class="col-md-4">
            <img src="/img/<?= $comic['cover']; ?>" class="img-fluid rounded-start" alt="...">
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h5 class="card-title"><?= $comic['title']; ?></h5>
              <p class="card-text"><b>Penulis: </b><?= $comic['author']; ?></p>
              <p class="card-text"><b>Penerbit: </b><?= $comic['publisher']; ?></p>

              <a href="/comics/edit/<?= $comic['slug']; ?>" class="btn btn-warning">Edit</a>

              <form action="/comics/<?= $comic['id']; ?>" method="POST" class="d-inline">
                <?= csrf_field(); ?>
                <input type="hidden" name="_method" value="delete">
                <button type="submit" class="btn btn-danger" onclick="return confirm('apakah anda yakin?'); ">Delete</button>
              </form>
              <br><br>
              <a href="/comics">Back to list comics</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>