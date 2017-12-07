$(function() {

    //define list type variables as js variables
    // var listtitle = "<?php echo ucfirst($listtitle); ?>";
    // var listnoun = "<?php echo ucfirst($listnoun); ?>";

    //pull in from hidden input
    var listnoun = $('#listnoun').val();

    //fade out saved notification
    $('.notif-alert').delay(4000).fadeOut();

    //MODAL FUNCTIONS
    //NEW ITEM modal
    $(document).on("click", ".new-item-btn", function(){
        //config modal for new
        $(".edit-new-title").text("Create New "+listnoun);
        $(".submit-new-edit").text("Create "+listnoun);

        //send info on item to be created
        var itemcount = $(".panel").length;
        var newItemPos = itemcount + 1;
        $('input[name="new-item-pos"]').val(newItemPos);

        //clear out inputs
        $('input[name="item-title-input"]').val("");
        $('textarea#item-desc-input').text("");
        $('input[name="edit-item-uid"]').val("");
    });

    //EDIT PAGE modal
    $(document).on("click", ".edit-item-btn", function(){
        //config modal for editing
        $(".edit-new-title").text("Edit "+listnoun);
        $(".submit-new-edit").text("Save Changes");

        //send info on page to be edited
        var editUID = $(this).closest(".panel").data('uid');
        $('input[name="edit-item-uid"]').val(editUID);
        var editTitle = $(this).parent().parent().text();
        var editDesc = $(this).parent().parent().parent().siblings(".panel-body").text();
        var editTitle = $.trim(editTitle);
        var editDesc = $.trim(editDesc);
        $('input[name="item-title-input"]').val(editTitle);
        $('textarea#item-desc-input').text(editDesc);

        //clear any left overs from abandoned new item modals
        $('input[name="new-item-pos"]').val("");
    });

    //submit for NEW or EDIT
    $(".submit-new-edit").click(function(){
        document.getElementById("new-edit-item-form").submit();
    });

    //DELETE PAGE modal
    $(document).on("click", ".delete-item-btn", function(){
        var deleteUID = $(this).closest(".panel").data('uid');
        $('input[name="delete-item-uid"]').val(deleteUID);
        var deleteTitle = $(this).parent().parent().text();
        $(".delete-title").text(deleteTitle);
    });

    //submit for DELETE
    $(".submit-delete").click(function(){
        document.getElementById("delete-item-form").submit();
    });

    //autofocus modal inputs
    $('.modal').on('shown.bs.modal', function() {
        $(this).find('input:first').focus();
    });


    //toggle editors preview container
    $(".preview-header").click(function() {
        if($('.preview-body').hasClass('hidden')){
            $(".preview-body").hide().removeClass("hidden").slideDown();
            $(".preview-header .glyphicon-chevron-down").addClass("hidden");
            $(".preview-header .glyphicon-chevron-up").removeClass("hidden");
        }
        else{
            $(".preview-body").slideUp(function(){
                $(".preview-body").addClass("hidden");
                $(".preview-body").show();
            });
            $(".preview-header .glyphicon-chevron-down").removeClass("hidden");
            $(".preview-header .glyphicon-chevron-up").addClass("hidden");
        }
    });

    //click to call js submit for single/generic form
    $(".js-submit-btn").click(function() {
        submitJSForm();
    });

    //EDIT PAGE modal I don't know what I was doing with this or where I left off...
    // $(document).on("click", ".send-uid", function(){
    //     //send info on item to be edited to modal
    //     var budgetuid = $(this).closest(".budget-table").data('uid');
    //     var budgetuid = $(this).closest(".budget-table").data('name');
    //     var budgetuid = $(this).closest(".budget-table").data('modal');
    //     $('input[name="edit-item-uid"]').val(budgetuid);

    //     //clear any left overs from abandoned new item modals
    //     $('input[name="new-item-pos"]').val("");
    // });

    //ALLOWANCE CODE

    //show, hide auto-refill options
    $('#budget-refill-input').change(function(){
        if(this.checked){
            $("#refill-options-group").removeClass("hidden");
        }
        else{
            $("#refill-options-group").addClass("hidden");
        }
    });

    //if weekly or monthly, form show/hide
    $('#refill-frequency-input').change(function(){
        if($(this).val() === 'Weekly'){
            $("#refill-weekly-group").removeClass("hidden");
            $("#refill-monthly-group").addClass("hidden");
        }
        else if($(this).val() === 'Monthly'){
            $("#refill-weekly-group").addClass("hidden");
            $("#refill-monthly-group").removeClass("hidden");
        }
    });

    //clears forms on modal closing, hides hidden elements and shows hidden elements that should be unhidden
    //using .on() because we're using a class name... this will clear all forms on a page
    $(".form-modal").on("hidden.bs.modal", function () {
        $('form').trigger("reset");
        //rehide any unhidden form elements or show any default non-hidden classes that GOT hidden
        $('.form-hidden').addClass("hidden");
        $(".default-show").removeClass("hidden");
    });

    //trigger deduct modal
    $(document).on("click", ".deduct-btn", function(){
        var deductUID = $(this).data('uid');
        var deductName = $(this).data('name');
        var currentBalance = $(this).data('balance');
        $('input[name="deduct-uid"]').val(deductUID);
        $('input[name="current-balance"]').val(currentBalance);
        $(".say-budget-name").text(deductName);
    });
    
})

//reordering auto-ajax function
function updateOrder(uid, pos){
    $.ajax({
        type: "POST",
        data: {moveuid: uid, movepos: pos},
        cache: false,
        success: function(response){
            //$(".reorder-badge").show().delay(500).fadeOut("fast");
        }
    });
}


//js form submit function
function submitJSForm(formid){
    formid = formid || "js-submit-form";
    document.getElementById(formid).submit();
}