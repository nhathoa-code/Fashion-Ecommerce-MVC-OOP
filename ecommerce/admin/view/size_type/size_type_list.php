<?php if (count($size_types) !== 0) : ?>
    <table class="table">
        <thead>
            <tr>
                <th class="cell-small text-center" data-toggle="tooltip" title="" data-original-title="Toggle all!"><input type="checkbox" id="check1-all" name="check1-all"></th>
                <th class="hidden-xs hidden-sm">Loại Kích Cỡ</th>
                <th class="hidden-xs hidden-sm">Giá Trị</th>
                <th class="text-center"><i class="fa fa-bolt"></i> Actions</th>
            </tr>
        </thead>
        <tbody>
            <form id="form-category" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="POST">
                <?php foreach ($size_types as $size_type) : extract($size_type); ?>
                    <tr>
                        <td class="text-center"><input type="checkbox" name="check1-td1"></td>
                        <td class="hidden-xs hidden-sm"><?php echo $name ?></td>
                        <td><a href="?page=size_type_value&size_type_id=<?php echo $id ?>">Link</a></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="submit" name="submit_edit_size_type_<?php echo $id ?>" value="sữa" data-toggle="tooltip" title="" class="btn btn-xs btn-success" data-original-title="Edit"><i class="fa fa-pencil"></i></button>
                                <button type="submit" name="submit_delete_size_type_<?php echo $id ?>" value="delete" data-toggle="tooltip" title="" class="btn btn-xs btn-danger" data-original-title="Delete"><i class="fa fa-times"></i></button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </form>
        </tbody>
    </table>
<?php else : ?>
    <h1>Không có loại kích cỡ !</h1>
<?php endif; ?>
<h3 style="margin-top:30px">Thêm Loại Kích Cỡ</h3>
<form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="POST">
    <div class="row">
        <div class="col-md-3">
            <input type="text" id="example-input-normal" name="size_type_name" placeholder="Tên loại kích cỡ" class="form-control">
        </div>
        <div>
            <input type="submit" name="submit_add_size_type_0" value="Thêm loại kích cỡ" class="btn btn-primary">
        </div>
    </div>
</form>
<?php if (isset($_SESSION['not_allow'])) { ?>
    <script>
        window.onload = function() {
            alert("<?php echo $_SESSION['message']; ?>");
        }
    </script>
<?php }
unset($_SESSION['not_allow'], $_SESSION['message']); ?>