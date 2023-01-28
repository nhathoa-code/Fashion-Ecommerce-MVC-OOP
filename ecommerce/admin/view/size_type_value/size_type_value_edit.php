 <table class="table">
     <thead>
         <tr>
             <th class="cell-small text-center" data-toggle="tooltip" title="" data-original-title="Toggle all!"><input type="checkbox" id="check1-all" name="check1-all"></th>
             <th class="hidden-xs hidden-sm">Giá Trị</th>
             <th class="text-center"><i class="fa fa-bolt"></i> Actions</th>
         </tr>
     </thead>
     <tbody>
         <form id="form-category" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="POST">
             <?php foreach ($size_type_values as $size_type_value) : extract($size_type_value); ?>
                 <?php if ($id == $size_type_value_ID) : ?>
                     <tr>
                         <td class="text-center"><input type="checkbox" name="check1-td1"></td>
                         <td>
                             <input style="width:fit-content" id="1" type="text" name="size_type_value" autofocus value="<?php echo $value ?>" class="form-control input-sm" onfocus="this.setSelectionRange(this.value.length,this.value.length);">
                         </td>
                         <td class="text-center">
                             <div class="btn-group">
                                 <button type="submit" name="submit_update_size_type_value_<?php echo $id ?>" value="Update" data-toggle="tooltip" title="" class="btn btn-xs btn-success" data-original-title="Update"><i class="fa fa-pencil"></i></button>
                                 <button type="submit" name="Cancel" value="Cancel" data-toggle="tooltip" title="" class="btn btn-xs btn-inverse" data-original-title="Cancel">Cancel</button>
                                 <button type="submit" name="submit_delete_size_type_value_<?php echo $id ?>" value="delete" data-toggle="tooltip" title="" class="btn btn-xs btn-danger" data-original-title="Delete"><i class="fa fa-times"></i></button>
                             </div>
                         </td>
                     </tr>
                 <?php else : ?>
                     <tr>
                         <td class="text-center"><input type="checkbox" name="check1-td1"></td>
                         <td class="hidden-xs hidden-sm"><?php echo $value ?></td>
                         <td class="text-center">
                             <div class="btn-group">
                                 <button type="submit" name="submit_edit_size_type_value_<?php echo $id ?>" value="sữa" data-toggle="tooltip" title="" class="btn btn-xs btn-success" data-original-title="Edit"><i class="fa fa-pencil"></i></button>
                                 <button type="submit" name="submit_delete_size_type_value_<?php echo $id ?>" value="delete" data-toggle="tooltip" title="" class="btn btn-xs btn-danger" data-original-title="Delete"><i class="fa fa-times"></i></button>
                             </div>
                         </td>
                     </tr>
                 <?php endif ?>
             <?php endforeach; ?>
         </form>
     </tbody>
 </table>