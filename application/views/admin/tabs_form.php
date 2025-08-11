<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Tab Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
  <h1><?= $tab ? 'Edit' : 'Add' ?> Tab</h1>
  <form method="post" action="<?= site_url('admin/save_tab') ?>" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $tab ? $tab->id : '' ?>">
    <div class="mb-3">
      <label>Tab Key (unique)</label>
      <input name="tab_key" class="form-control" value="<?= $tab ? htmlspecialchars($tab->tab_key) : '' ?>" required>
    </div>
    <div class="mb-3">
      <label>Title</label>
      <input name="title" class="form-control" value="<?= $tab ? htmlspecialchars($tab->title) : '' ?>" required>
    </div>
    <div class="mb-3">
      <label>Icon</label>
      <input type="file" name="icon" class="form-control">
      <?php if ($tab && $tab->icon): ?>
        <div class="mt-2"><img src="<?= base_url('assets/upload/'.$tab->icon) ?>" style="width:80px"></div>
      <?php endif; ?>
    </div>
    <button class="btn btn-success">Save</button>
    <a class="btn btn-secondary" href="<?= site_url('admin/tabs_list') ?>">Cancel</a>
  </form>
</div>
</body>
</html>
