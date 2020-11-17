let displayCheckbox = false;
let custnum = itemid = version = prodgroupid = name = sort = externalitemtxt = lepsizew = lepsizel = tradeunitspecid = salesid = stocklevel = image = msg = "";

$(document).ready(function () {
  $(".fading").fadeIn(1500);

  $("#toItemSearch").click(function () {
    window.location.href = "searching.php";
  });

  $('.print').hover(function () {
    $(this).attr('src', 'Bilder/druckerFull.png');
  }, function () {
    $(this).attr('src', 'Bilder/drucker.png');
  });

  $('.sendMailCheck').change(function () {
    displayCheckbox = false;

    $('.sendMailCheck').filter(':checked').each(function () {
      displayCheckbox = true;
    });

    if (displayCheckbox)
      $('#sendmailbtn').css('display', 'block');
    else
      $('#sendmailbtn').css('display', 'none');
  });

  $('input').filter(':checked').each(function () {
    $(this).prop("checked", false);
  });
});

function sendMail() {
  msg = "";
  var test = [];

  $('.sendMailCheck').filter(':checked').each(function () {
    var tmp = [];
    let index = $('.sendMailCheck').index(this);
    custnum = $('.custvendrelation').eq(index).text();
    itemid = $('.itemid').eq(index).text();
    version = $('.version').eq(index).text();
    prodgroupid = $('.prodgroupid').eq(index).text();
    name = $('.name').eq(index).text();
    sort = $('.sort').eq(index).text();
    externalitemtxt = $('.externalitemtxt').eq(index).text();
    lepsizew = $('.lepsizew').eq(index).text();
    lepsizel = $('.lepsizel').eq(index).text();
    tradeunitspecid = $('.tradeunitspecid').eq(index).text();
    salesid = $('.salesid').eq(index).text();
    stocklevel = $('.stocklevel').eq(index).text();

    $.ajax({
      type: "get",
      url: "getImageUrl.php",
      data: { ItemId: itemid },
      success: function (image) {
        tmp.push(image);
      }
    });

    tmp.push("R-Nummer: " + itemid);
    tmp.push("Kundennummer: " + custnum);
    tmp.push("Version: " + version);
    tmp.push("Produktvariante: " + prodgroupid);
    tmp.push("Kundenname: " + name);
    tmp.push("Sorte: " + sort);
    tmp.push("Stichwort: " + externalitemtxt);
    tmp.push("FormatQuer: " + lepsizew);
    tmp.push("FormatLauf: " + lepsizel);
    tmp.push("Stellung: " + tradeunitspecid);
    tmp.push("Auftragsnummer: " + salesid);
    tmp.push("Lagerstand: " + stocklevel);
    test.push(tmp);
  });

  $.ajax({
    type: "get",
    url: "getMailFromCustomer.php",
    data: { CustNum: custnum },
    success: function (email) {
      var arrStr = JSON.stringify(test);
      window.location.href = "sendMail.php?email=" + email + "&data=" + arrStr;
      /*if (data != "") {
        window.location.href = "mailto:" + data + "?body=" + encodeURIComponent(msg);
      } else {
        alert("Keine hinterlegte E-Mail gefunden!");
      }*/
    }
  });
}

function toStart() {
  let elem = document.getElementById("inputFields");
  if (elem) {
    setTimeout(function () {
      elem.scrollIntoView({ left: 0, block: "start", behavior: "smooth" });
    }, 100);
  }
}

$(window).on("load", function () {
  let elem = document.getElementById("dataView");
  if (elem) {
    setTimeout(function () {
      elem.scrollIntoView({ left: 0, block: "start", behavior: "smooth" });
    }, 500);
  }
});

function changeTitle() {
  let val = document.getElementById("selectType").value;
  let rNumTitle = document.getElementById("Rnumber");
  let rNumPlaceHolder = document.getElementById("rNumber");
  
  rNumTitle.innerHTML = val == "Rollenetiketten" ? "R-Nummer:" : 'E-Nummer:';
  rNumPlaceHolder.placeholder = val == "Rollenetiketten" ? "R-Nummer eingeben" : 'E-Nummer eingeben';
}

function openImage(url, rnumber) {
  // Get the modal
  let modal = document.getElementById("myModal");

  // Get the image and insert it inside the modal - use its "alt" text as a caption
  let modalImg = document.getElementById("showImg");
  let captionText = document.getElementById("caption");

  modal.style.display = "block";
  modalImg.src = "data:image/jpg;base64, " + url;
  captionText.innerHTML = rnumber;
  
  // Get the <span> element that closes the modal
  let span = document.getElementsByClassName("close")[0];

  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
    modal.style.display = "none";
  } 
}

