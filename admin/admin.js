var jQ = jQuery;

jQ(function(){
  jQ('form').submit(function(event){
    var $this = jQ(this);

    var allGood = {};
    jQ('#imgFilesContainer').find('input').each(function(index){
      index += 1;
      allGood[index] = false;

      var checked = displayName = '';

      checked = jQ('#img_'+ index).find('input[name="img_'+ index +'"]:checked');
      displayName = jQ('#img_'+ index).find('input[name="img_'+ index +'_name"]').val();

      if((jQ(this).val().length != 0) && (displayName !== 'display name') && (checked.length != 0)){
        allGood[index] = true;
      }

      console.log(allGood);

    });

    for(active in allGood){
      if(!allGood[active]){
        var alertTxt = "<p>Something is wrong!<\/p>";
        jQ('#alerts').html(alertTxt);
        return false;
      }
    }

    $this.hide();
    jQ('#loading').show();
    return true;
  });

  jQ(document).find('input[type=text]').focus(function(){
    if (jQ(this).val() === 'display name'){
      jQ(this).val('');
    }
  });

  jQ(document).find('input[type=text]').blur(function(){
    if (jQ(this).val() === ''){
      jQ(this).val('display name');
    }
  });
});
