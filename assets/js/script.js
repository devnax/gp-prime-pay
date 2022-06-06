var $ = jQuery
var body = $('body')
var container = $('[data-gp="charge-form"]');
var gp_pay_button = $('[data-gp="pay-btn"]');
var form = $('form#gp-pay');
var closeBtn = $('#gp-close-popup');
var loading = $('.form-loading-box')
var msgContainer = $('#gp-payment-msg')


var MSG = {
   success: function(msg){
      msgContainer.html(msg)
      msgContainer.removeClass('gp-msg-error')
      msgContainer.fadeIn()
   },
   error: function(msg){
      msgContainer.html(msg)
      msgContainer.addClass('gp-msg-error')
      msgContainer.fadeIn()
   },
   hide: function(){
      msgContainer.removeClass('gp-msg-error')
      msgContainer.html('')
      msgContainer.fadeOut()
   }
}

gp_pay_button.click(() => {
   container.css({
      display: "flex"
   });
   body.css({
      overflow: "hidden"
   })
})

closeBtn.click(() => {
   container.fadeOut(400, function () {
      body.css({
         overflow: "initial"
      })
   })
})


function confirm3dPayment(gbpReferenceNo) {
   var form = $("<form>");
   form.css({display: "none"})
    form.attr("method", "post");
    form.attr("action", GP_PRIME.endpoinds.secure);

    var publicKeyField = $("<input>");
    publicKeyField.attr("type", "hidden");
    publicKeyField.attr("name", "publicKey");
    publicKeyField.attr("value", GP_PRIME.public_key);

    var ReferenceField = $("<input>");
    ReferenceField.attr("type", "hidden");
    ReferenceField.attr("name", "gbpReferenceNo");
    ReferenceField.attr("value", gbpReferenceNo);
    form.append(publicKeyField);
    form.append(ReferenceField);
    body.append(form);
    form.submit();
}

function paymentProcess(data) {
   data.action = 'gp_prime_pay'

   jQuery.ajax({
      type: "POST",
      url: GP_PRIME.ajaxurl, // Test URL: https://api.globalprimepay.com/v2/tokens , Production URL: https://api.gbprimepay.com/v2/tokens
      data,
      success: function (res) {
         confirm3dPayment(res.gbpReferenceNo)
      },
      error: function (res) {
         MSG.error(res.message);
         loading.fadeOut()
      }
   });
}

form.submit((e) => {
   e.preventDefault();

   var publicKey = GP_PRIME.public_key;
   var formate = {};
   form.find('input[name]').each(function (index, ele) {
      var input = $(ele)
      formate[input.attr('name')] = input.val()
   })
   loading.css({
      display: 'flex'
   })
   MSG.hide();

   var dataReq = {
      "rememberCard": false,
      "card": {
         name: formate.holder_name,
         number: formate.card_number,
         expirationMonth: formate.expire_month,
         expirationYear: formate.expire_year,
         securityCode: formate.security_code
      }
   };

   // Read Token
   jQuery.ajax({
      type: "POST",
      url: GP_PRIME.endpoinds.tokens,
      data: JSON.stringify(dataReq),
      contentType: "application/json",
      dataType: "json",
      headers: {
         "Authorization": "Basic " + btoa(publicKey + ":")
      },
      success: function (res) {
         if(res.resultCode === "00"){
            paymentProcess({
               token: res.card.token,
               holder_name: formate.holder_name
            })
         }else{
            MSG.error(res.resultMessage)
         }
      },
      error: function (res) {
         MSG.error(res.responseJSON.message);
         loading.fadeOut()
      }
   });

})