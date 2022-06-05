var $ = jQuery
var body = $('body')
var container = $('[data-gp="charge-form"]');
var gp_pay_button = $('[data-gp="pay-btn"]');
var form = $('form#gp-pay');
var closeBtn = $('#gp-close-popup');
var loading = $('.form-loading-box')

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

function pay() {
   var formate = {
      action: 'gp_pay'
   };
   form.find('input[name]').each(function (index, ele) {
      var input = $(ele)
      formate[input.attr('name')] = input.val()
   })

   // jQuery.ajax({
   //    type: "POST",
   //    url: GP_PRIME.ajaxurl, // Test URL: https://api.globalprimepay.com/v2/tokens , Production URL: https://api.gbprimepay.com/v2/tokens
   //    data: dataReq,
   //    success: function (dataResp) {
   //       loading.fadeOut()
   //    },
   //    failure: function (errMsg) {
   //       console.error(errMsg);
   //       loading.fadeOut()
   //    }
   // });
}

form.submit((e) => {
   e.preventDefault();
   var self = $(this)

   var publicKey = GP_PRIME.public_key;
   var formate = {};
   form.find('input[name]').each(function (index, ele) {
      var input = $(ele)
      formate[input.attr('name')] = input.val()
   })
   loading.css({
      display: 'flex'
   })
   var dataReq = {
      "rememberCard": false,
      "card": {
         "name": formate.holder_name,
         "number": formate.card_number,
         "expirationMonth": formate.expire_month,
         "expirationYear": formate.expire_year,
         "securityCode": formate.security_code
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
      success: function (dataResp) {
         console.log(dataResp);
         loading.fadeOut()
      },
      failure: function (errMsg) {
         alert(errMsg);
         loading.fadeOut()
      }
   });

})