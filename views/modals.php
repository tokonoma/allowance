<!-- NEW BUDGET MODAL -->
<div class="modal fade form-modal" id="new-budget-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="new-budget-form" method="POST" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">New Budget</h4>
                </div>
                <div class="modal-body">
                    <p>Enter budget details</p>
                    <div class="form-group">
                        <label for="budget-name-input">Budget Name</label>
                        <input type="text" class="form-control" id="budget-name-input" name="budget-name-input" placeholder="Budget Title" autocomplete='off' autofocus>
                    </div>
                    <div class="form-group">
                        <label for="budget-balance-input">Initial Balance</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="number" class="form-control" id="budget-balance-input" name="budget-balance-input" placeholder="0.00" autocomplete='off' step="0.01">
                        </div>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="budget-refill-input" type="checkbox" name="budget-refill-input" value="1"> Auto-Refill
                        </label>
                    </div>
                    <div id="refill-options-group" class="hidden form-hidden">
                        <div id="refill-amount-group" class="form-group">
                            <label for="refill-amount-input">Refill Amount</label>
                            <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="number" class="form-control" name="refill-amount-input" placeholder="0.00" autocomplete='off' step="0.01">
                            </div>
                        </div>
                        <div id="refill-frequency-group" class="form-group">
                            <label for="refill-frequency-input">Refill Frequency</label>
                            <select id="refill-frequency-input"  class="form-control" name="refill-frequency-input">
                                <option>Weekly</option>
                                <option>Monthly</option>
                            </select>
                        </div>
                        <div id="refill-weekly-group" class="form-group default-show">
                            <label for="refill-weekly-input">Day of the Week</label>
                            <select class="form-control" name="refill-weekly-input">
                                <option>Sunday</option>
                                <option>Monday</option>
                                <option>Tuesday</option>
                                <option>Wednesday</option>
                                <option>Thursday</option>
                                <option>Friday</option>
                                <option>Saturday</option>
                            </select>
                        </div>
                        <div id="refill-monthly-group" class="form-group hidden form-hidden">
                            <label for="refill-monthly-input">Day of the Month</label>
                            <select class="form-control" name="refill-monthly-input">
                                <?php for ($i = 1; $i <= 31; $i++): ?>
                                    <option><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="budgetaction" value="new">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- BUDGET DEDUCT MODAL -->
<div class="modal fade form-modal" id="budget-deduct-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="budget-deduct-form" method="POST" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Deduct from Budget</h4>
                </div>
                <div class="modal-body">
                    <p>
                        <strong><span class="say-budget-name"></span></strong>: 
                        <span class="say-current-balance"></span>
                    </p>
                    <p>How much would you like to deduct?</p>
                    <div class="form-group">
                        <label for="budget-deduction-input">Deduction Amount</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="number" class="form-control" id="budget-deduction-input" name="budget-deduction-input" placeholder="0.00" autocomplete='off' step="0.01" autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="deduction-desc-input">Description (optional)</label>
                        <input type="text" class="form-control" id="deduction-desc-input" name="deduction-desc-input" placeholder="Write a brief description about this deduction!" autocomplete='off'>
                    </div>
                    <input type="hidden" name="budgetaction" value="deduct">
                    <input type="hidden" name="deduct-uid" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-primary">Deduct</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- BUDGET DELETE MODAL -->
<div class="modal fade form-modal" id="budget-delete-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete this Budget</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to <strong>DELETE</strong> this budget?</p>
                <p>
                    <strong><span class="say-delete-budget-name"></span></strong>: 
                    <span class="say-delete-current-balance"></span>
                </p>
                <p>Please check the following boxes to delete this budget</p>

                <p id="must-check-to-delete" class="hidden form-hidden">Gotta check those checkboxes!!!</p>
                
                <form id="budget-delete-form" method="POST" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>">
                    <div class="checkbox">
                        <label>
                            <input id="delete-you-sure-1" type="checkbox" name="delete-you-sure-1" value="1" class="delete-you-sure"> I want to delete this budget!
                        </label>
                    </div>
                   <div class="checkbox">
                        <label>
                            <input id="delete-you-sure-2" type="checkbox" name="delete-you-sure-2" value="1" class="delete-you-sure"> I want to destroy all data concerning this budget!
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="delete-you-sure-3" type="checkbox" name="delete-you-sure-3" value="1" class="delete-you-sure"> I want to never see this budget again!
                        </label>
                    </div>
                    <input type="hidden" name="budgetaction" value="delete">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" id="delete-budget-submit-btn" name="delete-budget-submit-btn" class="btn btn-danger disabled-fade">Delete Forever</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- BUDGET SHARE MODAL -->
<?php if(isset($budgetuid)): ?>
<div class="modal fade form-modal" id="budget-share-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Share this Budget</h4>
            </div>
            <form id="budget-delete-form" method="POST" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>">
                <div class="modal-body">
                    <p>Aye yo <?php echo $_SESSION['firstname'] ?>, you tryin' to share this budget?</p>
                    <p>
                        <strong><?php echo $thisbudgetname; ?></strong>: <?php echo $thisprintbalance; ?>
                    </p>
                    <p>
                        Enter the email address of the user with whom you would like to share. And try not to faint at how grammatically correct that sentence was...
                    </p>
                    <p>
                        If the user has an account, this budget will appear on their dashboard.
                    </p>
                    <div class="form-group">
                        <label for="share-user-input">Share With</label>
                        <input type="email" class="form-control" id="share-user-input" name="share-user-input" placeholder="Please enter a users email address" autocomplete='off'>
                    </div>
                    <input type="hidden" name="budgetaction" value="share">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-success">Share!</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>

<!-- EDIT BUDGET MODAL -->
<?php if(isset($budgetuid)): ?>
<div class="modal fade form-modal" id="edit-budget-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="edit-budget-form" method="POST" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Budget</h4>
                </div>
                <div class="modal-body">
                    <p>Edit budget details</p>
                    <div class="form-group">
                        <label for="budget-name-input">Budget Name</label>
                        <input type="text" class="form-control" id="budget-name-input" name="budget-name-input" placeholder="Budget Title" autocomplete='off' value="<?php echo $thisbudgetname ?>">
                    </div>
                    <div class="form-group">
                        <label for="budget-balance-input">Current Balance</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="number" class="form-control" id="budget-balance-input" name="budget-balance-input" placeholder="0.00" autocomplete='off' step="0.01" value="<?php echo $thisprintbalance ?>">
                        </div>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input id="budget-refill-input" type="checkbox" name="budget-refill-input" value="1"> Auto-Refill
                        </label>
                    </div>
                    <div id="refill-options-group" class="hidden form-hidden">
                        <div id="refill-amount-group" class="form-group">
                            <label for="refill-amount-input">Refill Amount</label>
                            <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="number" class="form-control" name="refill-amount-input" placeholder="0.00" autocomplete='off' step="0.01">
                            </div>
                        </div>
                        <div id="refill-frequency-group" class="form-group">
                            <label for="refill-frequency-input">Refill Frequency</label>
                            <select id="refill-frequency-input"  class="form-control" name="refill-frequency-input">
                                <option>Weekly</option>
                                <option>Monthly</option>
                            </select>
                        </div>
                        <div id="refill-weekly-group" class="form-group default-show">
                            <label for="refill-weekly-input">Day of the Week</label>
                            <select class="form-control" name="refill-weekly-input">
                                <option>Sunday</option>
                                <option>Monday</option>
                                <option>Tuesday</option>
                                <option>Wednesday</option>
                                <option>Thursday</option>
                                <option>Friday</option>
                                <option>Saturday</option>
                            </select>
                        </div>
                        <div id="refill-monthly-group" class="form-group hidden form-hidden">
                            <label for="refill-monthly-input">Day of the Month</label>
                            <select class="form-control" name="refill-monthly-input">
                                <?php for ($i = 1; $i <= 31; $i++): ?>
                                    <option><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="budgetaction" value="new">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>





















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