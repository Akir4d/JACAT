<table cellpadding="0" cellspacing="0" border="0" class="groceryCrudTable table table-striped table-bordered" id="<?php echo uniqid(); ?>">
    <thead>
        <tr>

            <?php if (!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)) { ?>
                <th>

                    <input type="text" class="form-control dt-ci-input search_hidden hidden" />
                    <div class="btn-group">					
                        <button class="btn btn-default refresh-data" role="button" onclick="location.reload()" data-url="<?php echo $ajax_list_url; ?>">
                            <i class="fa fa-refresh"></i>
                        </button>
                        <button onclick='$(".groceryCrudTable").find("thead tr th input").val("");' class="clear-filtering btn btn-default">
                            <i class="fa fa-eraser"></i> <i class="glyphicon glyphicon-arrow-right"></i>
                        </button>
                    </div>

                    </div>

                </th>
            <?php } ?>
            <?php $a = 0;
            foreach ($columns as $column) {
                ?>
                <th><input type="text" data-index="<?php echo ++$a ?>" autocomplete="no" name="<?php echo $column->field_name; ?>" placeholder=" &#xF002; <?php echo $column->display_as; ?>" class="form-control dt-ci-input search_<?php echo $column->field_name; ?>" style="font-family: FontAwesome, Arial;" /></th>
<?php } ?>
        </tr>
        <tr>
            <?php if (!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)) { ?>
                <th class='actions'><?php echo $this->l('list_actions'); ?></th>
            <?php } ?>
            <?php foreach ($columns as $column) { ?>
                <th><?php echo $column->display_as; ?></th>
<?php } ?>

        </tr>
    </thead>
    <tbody>
<?php foreach ($list as $num_row => $row) { ?>
            <tr id="row-<?php echo $num_row;?>">
                <?php if (!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)) { ?>
                    <td class='actions'>
                        <div class="btn-group">
                            <?php
                            if (!empty($row->action_urls)) {
                                foreach ($row->action_urls as $action_unique_id => $action_url) {
                                    $action = $actions[$action_unique_id];
                                    ?>

                                    <a href="<?php echo $action_url; ?>" class="btn btn-default">
                                        <i class="fa <?php echo $action->css_class; ?>"></i> <?php //echo $action->label ?>
                                    </a>
                                    <?php
                                }
                            }
                            ?>
        <?php if (!$unset_read) { ?>
                                <a href="<?php echo $row->read_url ?>" class="btn btn-default">
                                    <i class="fa fa-eye"></i> <?php //echo $this->l('list_view') ?>
                                </a>
                            <?php } ?>

        <?php if (!$unset_clone) { ?>
                                <a href="<?php echo $row->clone_url ?>" class="btn btn-default">
                                    <i class="fa fa-copy"></i> <?php //echo $clone_string;  ?>
                                </a>
                            <?php } ?>

        <?php if (!$unset_edit) { ?>
                                <a href="<?php echo $row->edit_url ?>" class="btn btn-default">
                                    <i class="fa fa-pencil"></i> <?php //echo $this->l('list_edit');  ?>
                                </a>
                            <?php } ?>

        <?php if (!$unset_delete) { ?>
                                <a onclick = "javascript: return delete_row('<?php echo $row->delete_url ?>', '<?php echo $num_row ?>')"
                                   href="javascript:void(0)" class="btn btn-default">
                                    <i class="fa fa-trash-o text-danger"></i>
                                    <span class="text-danger"><?php //echo $this->l('list_delete') ?></span>
                                </a>
        <?php } ?>
                        </div>
                    </td>
                <?php } ?>
                            <?php foreach ($columns as $column) { ?>
                    <td>
                        
                       <?php $wild=substr($row->{$column->field_name},0,1);if (($wild !== '<') && (!$unset_delete || !$unset_edit || !$unset_read || !empty($actions))) { ?>
                        <div class="dropdown">
                            <a type="button" class="black-text dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <?php echo $row->{$column->field_name} ?></a>
                            <ul class="dropdown-menu">
                                        
                                            <?php
                                            if (!empty($row->action_urls)) {
                                                foreach ($row->action_urls as $action_unique_id => $action_url) {
                                                    $action = $actions[$action_unique_id];
                                                    ?>

                                              <li> <a href="<?php echo $action_url; ?>">
                                                        <i class="fa <?php echo $action->css_class; ?>"></i> <?php echo $action->label ?>
                                                   </a>
                                              </li> 
                                                    <?php
                                                }
                                            }
                                            ?>
            <?php if (!$unset_read) { ?>
                                          <li>      <a href="<?php echo $row->read_url ?>">
                                                    <i class="fa fa-eye"></i> <?php echo $this->l('list_view'); ?>
                                                </a></li> 
                                            <?php } ?>

            <?php if (!$unset_clone) { ?>
                                         <li>       <a href="<?php echo $row->clone_url ?>">
                                                    <i class="fa fa-copy"></i> <?php $this->l('list_clone');  ?>
                                                </a></li> 
                                            <?php } ?>

            <?php if (!$unset_edit) { ?>
                                          <li>      <a href="<?php echo $row->edit_url ?>">
                                                    <i class="fa fa-pencil"></i> <?php echo $this->l('list_edit');  ?>
                                                </a></li> 
                                            <?php } ?>

            <?php if (!$unset_delete) { ?>
                                <li> <a onclick = "javascript: return delete_row('<?php echo $row->delete_url ?>', '<?php echo $num_row ?>')"
                                                   href="javascript:void(0)">
                                                    <i class="fa fa-trash-o text-danger"></i>
                                                    <span class="text-danger"><?php echo $this->l('list_delete') ?></span>
                                    </a></li>
            <?php } ?>
                                </ul>
                        </div></td>
                <?php } else { echo $row->{$column->field_name}; }?>
            <?php } ?>
            </tr>
    <?php } ?>
    </tbody>
    <tfoot>
    </tfoot>
</table>
