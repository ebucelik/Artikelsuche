let displayCheckbox = false;
let custnum = itemid = version = prodgroupid = name = sort = externalitemtxt = lepsizew = lepsizel = tradeunitspecid = salesid = stocklevel = image = msg = "";
let state = false;
let cntCheckedInputs = 0;

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

    $('#sendmailJpg, #sendmailPdf').css('display', displayCheckbox ? 'block' : 'none');
  });

  $('#dataView > input').filter(':checked').each(function () {
    $(this).prop("checked", false);
  });
});

function checkAll() {
  state = !state;

  $('#dataView input').each(function () {
    $(this).prop("checked", state);
  });

  $('#sendmailJpg, #sendmailPdf').css('display', state ? 'block' : 'none');

  $('#checkAllBtn').text(state ? 'Alle Artikel abwählen' : 'Alle Artikel auswählen');
}

function sendMailPdf() {
  let dataArr = [];

  $('.sendMailCheck').filter(':checked').each(function () {
    let tmp = [];
    let index = $('.sendMailCheck').index(this);
    custnum = $('.custvendrelation').eq(index).text();
    itemid = $('.itemid').eq(index).text();
    name = $('.name').eq(index).text();
    externalitemtxt = $('.externalitemtxt').eq(index).text();
    lepsizew = $('.lepsizew').eq(index).text();
    lepsizel = $('.lepsizel').eq(index).text();
    stocklevel = $('.stocklevel').eq(index).text();

    $.ajax({
      type: "get",
      url: "getImageUrl.php",
      data: { ItemId: itemid },
      success: function (image) {
        if (image) {
          tmp.push(image);
        } else {
          tmp.push("Uploads/noimage.jpg");
        }
      },
      async: false
    });

    tmp.push(itemid);
    tmp.push(externalitemtxt);
    tmp.push(stocklevel);
    tmp.push(lepsizew);
    tmp.push(lepsizel);
    dataArr.push(tmp);
  });

  $.ajax({
    type: "get",
    url: "createPdfForMail.php",
    data: { Data: JSON.stringify(dataArr), Name: name },
    success: function () {
      $.ajax({
        type: "get",
        url: "getMailFromCustomer.php",
        data: { CustNum: custnum },
        success: function (email) {
          window.location.href = "sendMail.php?email=" + email + "&PDF=Uploads/" + name + ".pdf";
        }
      });
    }
  });
}

function sendMailJpg() {
  let dataArr = [];
  cntCheckedInputs = 0;

  $('.sendMailCheck').filter(':checked').each(function () {
    cntCheckedInputs++;
    let tmp = [];
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
    dataArr.push(tmp);
  });

  if (cntCheckedInputs > 20) {
    alert("Achtung!\n\nSie haben die maximale Anzahl an ausgewählten Artikeln überschritten (max. 20).\nAktuell haben Sie " + cntCheckedInputs + " Artikel ausgewählt.");
  } else {
    $.ajax({
      type: "get",
      url: "getMailFromCustomer.php",
      data: { CustNum: custnum },
      success: function (email) {
        let arrStr = JSON.stringify(dataArr);
        window.location.href = "sendMail.php?email=" + email + "&data=" + arrStr;
      }
    });
  }
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

function addInputfield() {
  let val = document.getElementById("selectParameter").value;
  if (val != "Parameter auswählen") {
    let index = document.getElementById("selectParameter");
  
    let elem = '<div class="form-group fading searchForm" id="'+ val +'Div"><label for="' + val + '" class="align-self-center labelTxt">' + val + ':</label><input type="text" class="form-control searchInput" id="'+ val +'" placeholder="'+ val +' eingeben" name="'+ val +'" value=""><button class="deleteBtn align-self-center" onclick="deleteInputfield(this)" name="'+ val +'Div">X</button></div>';
  
    $('#parameterContainer').before(elem);
  
    index.remove(index.selectedIndex);
  }
}

function deleteInputfield(divId) {
  $('#' + divId.name).remove();
  
  let index = document.getElementById("selectParameter");
  let option = document.createElement("option");
  let txt = divId.name;
  txt = txt.replace("Div", "");

  option.text = txt;
  index.add(option);
}