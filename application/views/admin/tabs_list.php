<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Manage Tabs</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="p-4">
<div class="container">
  <h1>Manage Tabs</h1>
  <p><a href="<?= site_url() ?>" class="btn btn-warning">Home</a> &nbsp;&nbsp; <a href="<?= site_url('admin/tab_form') ?>" class="btn btn-primary">Add Tab</a></p>
  <table class="table table-bordered">
    <thead><tr><th>ID</th><th>Key</th><th>Title</th><th>Icon</th><th>Actions</th></tr></thead>
    <tbody>
      <?php foreach ($tabs as $t): ?>
        <tr>
          <td><?= $t->id ?></td>
          <td><?= htmlspecialchars($t->tab_key) ?></td>
          <td><?= htmlspecialchars($t->title) ?></td>
          <td><?php if ($t->icon): ?><img src="<?= base_url('assets/upload/'.$t->icon) ?>" style="width:48px"><?php endif; ?></td>
          <td>
            <a href="<?= site_url('admin/tab_form/'.$t->id) ?>" class="btn btn-sm btn-secondary">Edit</a>
            <a href="javascript:void(0);" class="btn btn-sm btn-danger" onclick="confirmDelete(<?= $t->id ?>)">Delete</a>
            <a href="<?= site_url('admin/slides_list/'.$t->id) ?>" class="btn btn-sm btn-info">Slides</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
</body>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You can't restore a record once it is deleted.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "<?= site_url('admin/delete_tab/') ?>" + id;
        }
    });
}
</script>
</html>
