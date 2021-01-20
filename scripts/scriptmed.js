$(document).ready(function () {
    $("#toCustomerSearch").click(function () {
    window.location.href = "customerSearch.php";
    });
     $("#kNumber").bind("keyup keydown", function() {		
        var amount = $(this).val();
        var div = $( "#kNumber" ).last();
        var offsettop = div.offset().top + 5;
        var offsetleft = div.offset().left + 452;
            if (amount.length > 0 && amount.length < 5) {
                $("span.kNumberalert").html("Geben Sie mindestens 5 Zahlen ein.");
            } else
                {
                $("span.kNumberalert").html("");
            }
        $('.kNumberalert').css({'position':'absolute','left' : offsetleft, 'top' : offsettop});
    });
    $("#kPLZ").bind("keyup keydown", function() {		
        var amount = $(this).val();
        var div = $( "#kPLZ" ).last();
        var offsettop = div.offset().top + 5;
        var offsetleft = div.offset().left + 452;
            if (amount.length > 0 && amount.length < 4) {
                $("span.kPLZalert").html("Geben Sie mindestens 4 Zahlen ein.");
            } else
                {
                $("span.kPLZalert").html("");
            }
        $('.kPLZalert').css({'position':'absolute','left' : offsetleft, 'top' : offsettop});       
    });
    $("#tNumber").bind("keyup keydown", function() {		
        var amount = $(this).val();
        var div = $( "#tNumber" ).last();
        var offsettop = div.offset().top + 5;
        var offsetleft = div.offset().left + 452;
            if (amount.length > 0 && amount.length < 7) {
                $("span.tNumberalert").html("Geben Sie mindestens 7 Zeichen ein.");
            } else
                {
                $("span.tNumberalert").html("");
            }
        $('.tNumberalert').css({'position':'absolute','left' : offsetleft, 'top' : offsettop});
    });

    $('.alert2').keyup(function() {
        var amountkNumber = $('#kNumber').val();
        var amountkPLZ = $('#kPLZ').val();
        var amounttNumber = $('#tNumber').val();
        
           
        if ((amountkNumber.length > 0 && amountkNumber.length < 5) || 
            (amountkPLZ.length > 0 && amountkPLZ.length < 4) || 
            (amounttNumber.length > 0 && amounttNumber.length < 7)) 
        {
            $('.customerSubmit').attr('disabled', 'disabled');
        } 
        else
        {
            $('.customerSubmit').removeAttr('disabled');
        }
    });
}); 

    



