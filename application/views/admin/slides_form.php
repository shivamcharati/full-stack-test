<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Slide Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <h1><?= $slide ? 'Edit' : 'Add' ?> Slide</h1>
  <form method="post" action="<?= site_url('admin/save_slide') ?>" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $slide ? $slide->id : '' ?>">
    <input type="hidden" name="tab_id" value="<?= $tab_id ?>">
    <div class="mb-3">
      <label>Tag</label>
      <input name="tag" class="form-control" value="<?= $slide ? htmlspecialchars($slide->tag) : '' ?>">
    </div>
    <div class="mb-3">
      <label>Title</label>
      <input name="title" class="form-control" value="<?= $slide ? htmlspecialchars($slide->title) : '' ?>" required>
    </div>
    <div class="mb-3">
      <label>Image</label>
      <input type="file" name="image" class="form-control">
      <?php if ($slide && $slide->image): ?>
        <div class="mt-2"><img src="<?= base_url('assets/upload/'.$slide->image) ?>" style="width:180px"></div>
      <?php endif; ?>
    </div>
    <div class="mb-3">
      <label>Sort Order</label>
      <input type="number" name="sort_order" class="form-control" value="<?= $slide ? $slide->sort_order : 0 ?>">
    </div>
    <button class="btn btn-success">Save</button>
    <a class="btn btn-secondary" href="<?= site_url('admin/slides_list/'.$tab_id) ?>">Cancel</a>
  </form>
</div>
</body>
</html>
