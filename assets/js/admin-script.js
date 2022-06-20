;(function(){

   var $ = jQuery
   var queryForm = $('#gp_payment_query_form')
   var queryResult = $('#query-result')

   queryForm.submit(function(e){
      e.preventDefault()
      var ref = queryForm.find('[name=ref]')
      var secret_key = GP_PRIME.secret_key
      queryResult.html('')

      if(ref.val()){
         var dataReq = {
            referenceNo: ref.val()
         };
      
         // Read Token
         jQuery.ajax({
            type: "POST",
            url: GP_PRIME.endpoinds.query,
            data: JSON.stringify(dataReq),
            contentType: "application/json",
            dataType: "json",
            headers: {
               "Authorization": "Basic " + btoa(secret_key + ":")
            },
            success: function (res) {
               var temp = ''
               if(res.resultCode === "00"){
                  var rows = ''
                  for(var key in res.txn){
                     var val = res.txn[key]
                     rows += `<tr>
                        <td>${key}</td>
                        <td>${val}</td>
                     </tr>`
                  }

                  temp = `<table>${rows}</table>`
               }else{
                  temp = res.resultMessage
               }
               queryResult.html(temp)
            },
            error: function (res) {
               queryResult.html(res?.resultMessage)
            }
         });
      }
   })

})();