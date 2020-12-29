$(document).ready(function () {
    $("#toCustomerSearch").click(function () {
    window.location.href = "customerSearch.php";
    });
    $("#kNumber").bind("keyup keydown", function() {		
        var amount = $(this).val();
        var div = $( "#kNumber" ).last();
        var offsettop = div.offset().top + 5;
        var offsetleft = div.offset().left + 452;
            if (amount.length < 5) {
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
            if (amount.length < 4) {
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
            if (amount.length < 7) {
                $("span.tNumberalert").html("Geben Sie mindestens 7 Zeichen ein.");
            } else
                {
                $("span.tNumberalert").html("");
            }
        $('.tNumberalert').css({'position':'absolute','left' : offsetleft, 'top' : offsettop});
    });
});
