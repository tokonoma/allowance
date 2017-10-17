<!--js-->
<!--jquery-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
    //if local fallback is available 
    window.jQuery || document.write('<script src="../assets/js/jquery-3.1.1.min.js"><\/script>')
</script>

<!--bootstrap.js and CSS fallback-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    //if local fallback is available
    window.jQuery.fn.modal || document.write('<script src="../assets/bootstrap/js/bootstrap.min.js"><\/script>')
</script>
<script>
    (function($) {
        $(function() {
             if ($('#bootstrapCssTest').is(':visible') === true) {
                $('head').prepend('<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">');
            }
        });
    })(window.jQuery);
</script>

<script>
    $(function() {

        //for generic forms with no checks required
        $(".js-submit-btn").click(function() {
            submitJSForm();
        });
        
    });

    //when additonal checks are required prior to submission
    function submitJSForm(){
        document.getElementById("js-submit-form").submit();
    }
</script>

<script src="https://maxcdn.bootstrapcdn.com/js/ie10-viewport-bug-workaround.js"></script>