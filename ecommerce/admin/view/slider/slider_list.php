<?php if (count($sliders) !== 0) : ?>
    <table class="table">
        <thead>
            <tr>
                <th style="width: 20%;" class="hidden-xs hidden-sm">Ảnh</th>
                <th class="hidden-xs hidden-sm">Tiêu Đề</th>
                <th class="hidden-xs hidden-sm">Tiêu Đề 1</th>
                <th style="width:30%" class="hidden-xs hidden-sm">Nội Dung</th>
                <th class="hidden-xs hidden-sm">Nút</th>
                <th class="hidden-xs hidden-sm">Đường dẫn</th>
                <th class="text-center"><i class="fa fa-bolt"></i> Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sliders as $slider) : extract($slider); ?>
                <tr id="<?php echo $id ?>">
                    <td class="hidden-xs hidden-sm image">
                        <img style="width:100%;height:auto" src="<?php echo "$ROOT_URL/content/images/slider/$image" ?>" alt="">
                    </td>
                    <td class="title"><?php echo $title ?></td>
                    <td class="title1"><?php echo $title1 ?></td>
                    <td class="content"><?php echo $content ?></td>
                    <td class="button"><?php echo $button ?></td>
                    <td class="link"><?php echo $link ?></td>
                    <td class="text-center">
                        <div class="btn-group">
                            <button data-id="<?php echo $id ?>" data-image="<?php echo $image ?>" class="btn btn-success edit">Sữa</button>
                            <button data-id="<?php echo $id ?>" data-image="<?php echo $image ?>" class="btn btn-danger delete" style="margin-left:3px">Xóa</button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <h1>Không có slider !</h1>
<?php endif; ?>
<h3 style="margin-top:30px">Thêm slider</h3>
<form id="form" style="width:50%" action="#" method="post" enctype="multipart/form-data" class="form-horizontal form-box" onsubmit="return false;">
    <div class="form-box-content">
        <div class="form-group">
            <label class="control-label col-md-2">Ảnh</label>
            <div class="col-md-8">
                <input type="file" name="image" class="form-control">
            </div>
            <div id="preview">

            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Tiêu Đề</label>
            <div class="col-md-8">
                <input type="text" name="title" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Tiêu Đề 1</label>
            <div class="col-md-8">
                <input type="text" name="title1" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Nội Dung</label>
            <div class="col-md-8">
                <textarea name="content" class="form-control" rows="3"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Nút</label>
            <div class="col-md-8">
                <input type="text" name="button" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2">Link</label>
            <div class="col-md-8">
                <input type="text" name="link" class="form-control">
            </div>
        </div>
        <div class="form-group form-actions">
            <div class="col-md-10 col-md-offset-2">
                <input id="add_slider_btn" type="submit" class="btn btn-success" value="Thêm">
            </div>
        </div>
    </div>
</form>