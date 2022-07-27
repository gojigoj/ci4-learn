<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
  <div class="row">
    <div class="col-8">
      <h2 class="my-3">Form edit comic</h2>
      <form action="/comics/update/<?= $comic['id']; ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <input type="hidden" name="slug" value="<?= $comic['slug']; ?>">
        <input type="hidden" name="oldCover" value="<?= $comic['cover']; ?>">
        <div class="row mb-3">
          <label for="title" class="col-sm-2 col-form-label">Title</label>
          <div class="col-sm-10">
            <input type="text" class="form-control <?= ($validation->hasError('title') ? 'is-invalid' : ''); ?>" id="title" name="title" autofocus value="<?= (old('title')) ? old('title') : $comic['title']; ?>">
            <div class="invalid-feedback">
              <?= $validation->getError('title'); ?>
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <label for="author" class="col-sm-2 col-form-label">Author</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="author" name="author" value="<?= (old('author')) ? old('author') : $comic['author']; ?>">
          </div>
        </div>
        <div class="row mb-3">
          <label for="publisher" class="col-sm-2 col-form-label">Publisher</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="publisher" name="publisher" value="<?= (old('publisher')) ? old('publisher') : $comic['publisher']; ?>">
          </div>
        </div>
        <div class="row mb-3">
          <label for="cover" class="col-sm-2 col-form-label">Cover</label>
          <div class="col-sm-2">
            <img src="/img/<?= $comic['cover']; ?>" class="img-thumbnail img-preview">
          </div>
          <div class="col-sm-8">
            <input type="file" class="form-control <?= ($validation->hasError('cover') ? 'is-invalid' : ''); ?>" name="cover" id="cover" onchange="imgPreview()">
            <div class=" invalid-feedback">
              <?= $validation->getError('cover'); ?>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Edit comic</button>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>