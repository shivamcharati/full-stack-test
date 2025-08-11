<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Slides - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="p-4">
<div class="container">
  <h1>Manage <?= htmlspecialchars($tab->title) ?> Slides</h1>
  <p>
    <a href="<?= site_url('admin/slide_form/'.$tab->id) ?>" class="btn btn-primary">Add Slide</a>
    <a href="<?= site_url('admin/tabs_list') ?>" class="btn btn-secondary">Back to Tabs</a>
  </p>

  <table class="table table-bordered">
    <thead><tr><th>ID</th><th>Tag</th><th>Title</th><th>Image</th><th>Order</th><th>Actions</th></tr></thead>
    <tbody>
      <?php foreach ($slides as $s): ?>
        <tr>
          <td><?= $s->id ?></td>
          <td><?= htmlspecialchars($s->tag) ?></td>
          <td><?= htmlspecialchars($s->title) ?></td>
          <td><?php if($s->image): ?><img src="<?= base_url('assets/upload/'.$s->image) ?>" style="width:120px"><?php endif; ?></td>
          <td><?= $s->sort_order ?></td>
          <td>
            <a href="<?= site_url('admin/slide_form/'.$tab->id.'/'.$s->id) ?>" class="btn btn-sm btn-secondary">Edit</a>
            <a href="javascript:void(0);" class="btn btn-sm btn-danger" onclick="confirmDeleteSlide(<?= $tab->id ?>, <?= $s->id ?>)">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
</body>
<script>
function confirmDeleteSlide(tabId, slideId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You can't restore a record once it is deleted.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "<?= site_url('admin/delete_slide/') ?>" + tabId + "/" + slideId;
        }
    });
}
</script>
</html>
