<!-- REQ marian.js, $listnoun, $new-item-pos, $edit-item-uid, $delete-item-uid-->

<!--modals-->
<!--new and edit item modal-->
<div class="modal fade" id="new-edit-item-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title edit-new-title"></h4>
            </div>
            <div class="modal-body">
                <p>Enter <?php echo $listnoun; ?> title &amp; description</p>
                <form id="new-edit-item-form" method="POST" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>">
                    <div class="form-group">
                        <label for="titleinput"><?php echo ucfirst($listnoun); ?> Title</label>
                        <input type="text" class="form-control" id="item-title-input" name="item-title-input" placeholder="title" autocomplete='off' autofocus>
                    </div>
                    <div class="form-group">
                        <label for="descinput"><?php echo ucfirst($listnoun); ?> Description</label>
                        <textarea class="form-control" id="item-desc-input" name="item-desc-input" placeholder="description"></textarea>
                        <input type="hidden" name="new-item-pos" value="">
                        <input type="hidden" name="edit-item-uid" value="">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary submit-new-edit"></button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--delete item modal-->
<div class="modal fade" id="delete-item-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete <?php echo ucfirst($listnoun); ?></h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong>&quot;<span class="delete-title"></span>&quot;</strong></p>
                <form id="delete-item-form" method="POST" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>">
                    <input type="hidden" name="delete-item-uid" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger submit-delete">Delete It!</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->