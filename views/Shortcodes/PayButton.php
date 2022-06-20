<div>
  

   <div data-gp="charge-form" style="display: <?= $error ? 'flex' : 'none'?>">
      <button id="gp-close-popup">&times;</button>
      <div class="gp-form-container">
         <h3 >PAY WITH CARD</h3>
         <div id="gp-payment-msg" style="display: <?= $error ? 'block' : 'none'?>"><?= $error ?></div>
         <form action="#" method="POST" id="gp-pay">
            <div class="form-loading-box">
               <div class="loading-snippit">
                  <div></div>
                  <div></div>
                  <div></div>
                  <div></div>
               </div>
            </div>
            <div class="gp-field">
               <div>
                  <label for="holder_name">Holder Name</label>
                  <input id="holder_name" name="holder_name" type="text" maxlength="250"  value="Card Test UAT (Server Test)">
               </div>
            </div>
            <div class="gp-field">
               <div>
                  <label for="card_number">Card Number</label>
                  <input id="card_number" name="card_number"  type="text" maxlength="16" value="4535017710535">
               </div>
            </div>

            <div class="gp-field">
               <div>
                  <div>
                     <label for="expirationMonth">MM</label>
                     <input id="expirationMonth" name="expire_month"  type="text" maxlength="2" value="05">
                  </div>
               </div>
               <div>
                  <div>
                     <label for="expirationYear">YY</label>
                     <input id="expirationYear" name="expire_year"  type="text" maxlength="2" value="28">
                  </div>
               </div>
               <div>
                  <div>
                     <label for="securityCode">CVV</label>
                     <input id="securityCode" name="security_code" type="password" maxlength="3" autocomplete="off" value="184">
                  </div>
               </div>
            </div>
            <div class="gp-field">
               <input id="button" type="submit" value="Pay Now <?= $currency.$amount ?>">
            </div>
            <div class="gp-field" style="justify-content: center; margin-top: 20px">
               <img style="width: 250px; border-radius: 7px" src="<?= GP_PRIME_ASSET_URI.'/img/payment-methods.png'?>" />
            </div>
         </form>
      </div>
   </div>
   <button data-gp="pay-btn" class="gp_pay_button" id="<?= $id ?>"><?= $button_text ?></button>
</div>

