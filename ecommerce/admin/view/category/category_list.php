<div>
    <a href="javascript:back()">Back</a>
</div>
<?php if (count($categories) !== 0) : ?>
    <table class="table">
        <thead>
            <tr>
                <th class="cell-small text-center" data-toggle="tooltip" title="" data-original-title="Toggle all!"><input type="checkbox" id="check1-all" name="check1-all"></th>
                <th class="hidden-xs hidden-sm">Tên Danh Mục</th>
                <th class="hidden-xs hidden-sm">Danh Mục Con</th>
                <th class="text-center"><i class="fa fa-bolt"></i> Actions</th>
            </tr>
        </thead>
        <tbody>
            <form id="form-category" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="POST">
                <?php foreach ($categories as $category) : extract($category); ?>
                    <tr>
                        <td class="text-center"><input type="checkbox" name="check1-td1"></td>
                        <td class="hidden-xs hidden-sm"><?php echo $name ?></td>
                        <td><a href="?page=category&parent_id=<?php echo $category_id ?>">Link</a></td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="submit" name="submit_edit_category_<?php echo $category_id ?>" value="sữa" data-toggle="tooltip" title="" class="btn btn-xs btn-success" data-original-title="Edit"><i class="fa fa-pencil"></i></button>
                                <button type="submit" name="submit_delete_category_<?php echo $category_id ?>" value="delete" data-toggle="tooltip" title="" class="btn btn-xs btn-danger" data-original-title="Delete"><i class="fa fa-times"></i></button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </form>
        </tbody>
    </table>
<?php else : ?>
    <h1>Không có danh mục con !</h1>
<?php endif; ?>
<h3 style="margin-top:30px">Thêm Danh Mục</h3>
<form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="POST">
    <div class="row">
        <div class="col-md-3">
            <input type="text" id="example-input-normal" name="category_name" placeholder="Tên danh mục" class="form-control">
        </div>
        <div>
            <input type="submit" name="submit_add_category_0" value="Thêm danh mục" class="btn btn-primary">
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
<script>
    function back() {
        console.log(document.referrer);
    }
</script>