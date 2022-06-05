<div class="wrap">
   <h1>GP Prime Pay Settings</h1>
   <form method="post" >
      <table class="form-table" role="presentation">
         <tbody>
            <tr>
               <th scope="row"><label for="public_key">Public Key</label></th>
               <td><input name="public_key" type="text" value="<?= $public_key?>" id="public_key" class="regular-text"></td>
            </tr>
            <tr>
               <th scope="row"><label for="secret_key">Secret Key</label></th>
               <td><input name="secret_key" type="password" value="<?= $secret_key ?>" id="secret_key" class="regular-text"></td>
            </tr>
         </tbody>
      </table>
      <p class="submit">
         <input type="submit" name="gp_settings_submit" id="gp_settings_submit" class="button button-primary"
            value="Save Changes">
      </p>
   </form>
</div>