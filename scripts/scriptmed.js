$(document).ready(function () {
    $("#toCustomerSearch").click(function () {
    window.location.href = "customerSearch.php";
    });
    $("#kNumber").bind("keyup keydown", function() {		
        var amount = parseFloat($(this).val());
        var div = $( "#kNumber" ).last();
        var offsettop = div.offset().top + 5;
        var offsetleft = div.offset().left + 452;
        console.log(amount)
            if (amount.length < 4) {
                $("span.kNumberalert").html("Geben Sie mindestens 4 Stellen ein");
            } else
                {
                $("span.kNumberalert").html("Gültig");
            }
        $('.kNumberalert').css({'position':'absolute','left' : offsetleft, 'top' : offsettop});
    });
});

/* Backup
$(document).ready(function () {
    $("#toCustomerSearch").click(function () {
    window.location.href = "customerSearch.php";
    });
    $("#kNumber").bind("keyup keydown", function() {		
        var amount = parseFloat($(this).val());
        var div = $( "#kNumber" ).last();
        var offsettop = div.offset().top + 5;
        var offsetleft = div.offset().left + 452;
        //div.html( "left: " + offset.left + ", top: " + offset.top );
        console.log(amount)
        if (amount) {
            if (amount < 4) {
                $("span.kNumberalert").html("Geben Sie mindestens 4 Stellen ein");
            } else
            if(amount > 4) {
                $("span.kNumberalert").html("Gültig");
            }
        } else {
            $("span.kNumberalert").html("Geben Sie nur Zahlen ein");
        }
        $('.kNumberalert').css({'position':'absolute','left' : offsetleft, 'top' : offsettop});
    });
});
*/