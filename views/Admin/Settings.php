<?php 

   $temp = '';

   ob_start();
   if($test_mode){
   ?>
   <tr>
      <th scope="row"><label for="public_key">Test Credentials</label></th>
   </tr>
   <tr>
      <th scope="row"><label for="public_key">Public Key</label></th>
      <td><?=$public_key ?></td>
   </tr>
   <tr>
      <th scope="row"><label for="secret_key">Secret Key</label></th>
      <td><?= $secret_key ?></td>
   </tr>
   <?php
   }else{
   ?>
   <tr>
      <th scope="row"><label for="public_key">Public Key</label></th>
      <td><input name="public_key" type="text" value="<?= $public_key?>" id="public_key" class="regular-text"></td>
   </tr>
   <tr>
      <th scope="row"><label for="secret_key">Secret Key</label></th>
      <td><input name="secret_key" type="password" value="<?= $secret_key ?>" id="secret_key" class="regular-text"></td>
   </tr>
   <?php
   }
   $temp = ob_get_clean();

?>


<div class="wrap">
   <h1>GP Prime Pay Settings</h1>
   <form method="post" >
      <table class="form-table" role="presentation">
         <tbody>
            <tr>
               <th scope="row"><label for="public_key">Test Mode</label></th>
               <td><input name="test_mode" type="checkbox" <?= $test_mode ? "checked" : "" ?> id="test_mode" class="regular-text"></td>
            </tr>
            <?= $temp ?>
         </tbody>
      </table>
      <p class="submit">
         <input type="submit" name="gp_settings_submit" id="gp_settings_submit" class="button button-primary"
            value="Save Changes">
      </p>
   </form>
</div>