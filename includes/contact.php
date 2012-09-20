<?php
if(!empty($_POST)){
//  $formData and $formCSS is from this include
  include_once './formvalidate.php';
  include_once '../resource/var.php';
}else{
  include_once './resource/var.php';
}
?>
<h2>Contact Dave</h2>
<div class="contact">
<?php if(!empty($formData->global)){ ?>
  <div class="globalError">
  <?php
  foreach($formData->global as $error){
    echo $error;
  } ?>
  </div>
<?php } ?>
  <form id="contactForm" method="post" action="">
    <div class="column contactLeft">
      <div><label for="name">Full Name:</label></div>
      <div><label for="email">Contact Email:</label></div>
      <div><label for="phone">Contact Number:</label></div>
      <div><label for="hear">Where did you hear about Tattooin AZ:</label></div>
      <div><label for="first">Is this your first tattoo:</label></div>
      <div><label for="kind">What kind of tattoo are you wanting:</label></div>
      <div><label for="message">Message to Dave:</label></div>
    </div>

    <div class="column contactRight">
      <div><input type="text" id="name" name="name" value="<?=
        (empty($formData->name)) ? '' : $formData->name ;
      ?>" class="<?=  (empty($formCSS['name'])) ? '' : $formCSS['name'] ?>" /></div>
      <div><input type="text" id="email" name="email" value="<?=
        (empty($formData->email)) ? '' : $formData->email ;
      ?>" class="<?=  (empty($formCSS['email'])) ? '' : $formCSS['email'] ?>" /></div>
      <div><input type="text" id="phone" name="phone" value="<?=
        (empty($formData->phone)) ? '' : $formData->phone ;
      ?>" class="<?=  (empty($formCSS['phone'])) ? '' : $formCSS['phone'] ?>" /></div>
      <div>
        <select id="hear" name="hear">
          <option value="0" selected="selected">Choose one</option>
          <?php
            foreach($selectHeard as $value){ ?>
              <option value="<?= preg_replace("/ /", "-", strtolower($value)); ?>"><?= $value; ?></option>
            <?php }
          ?>
        </select>
      </div>
      <div>
        <select id="first" name="first">
          <option value="0" selected="selected">Choose one</option>
          <?php
            foreach($selectFistTattoo as $value){ ?>
              <option value="<?= preg_replace("/ /", "-", strtolower($value)); ?>"><?= $value; ?></option>
            <?php }
          ?>
        </select>
      </div>
      <div>
        <select id="kind" name="kind">
          <option value="0" selected="selected">Choose one</option>
          <?php
            foreach($selectKind as $value){ ?>
              <option value="<?= preg_replace("/ /", "-", strtolower($value)); ?>"><?= $value; ?></option>
            <?php }
          ?>
        </select>
      </div>
      <div><textarea id="message" name="message" class="messageBox"></textarea></div>
    </div>
    <div class="buttons">
      <input type="button" value="Submit" />
      <input type="button" value="Clear" />
      <div class="mandatory">some fields are mandatory</div>
    </div>
  </form>
</div>