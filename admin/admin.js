var jQ = jQuery;

jQ(function(){
  jQ('form').submit(function(event){
    $this = jQ(this);

    allGood = {};
    jQ('#imgFilesContainer').find('input').each(function(index){
      index += 1;
      allGood[index] = false;

      var checked = displayName = '';

      checked = jQ('#img_'+ index).find('input[name="img_'+ index +'"]:checked');
      displayName = jQ('#img_'+ index).find('input[name="img_'+ index +'_name"]').val();

      if((jQ(this).val().length != 0) && (displayName !== 'display name') && (checked.length != 0)){
        allGood[index] = true;
      }
    });

    for(active in allGood){
      if(allGood){
        $this.hide();
        jQ('#loading').show();
        return true;
      }
    }

    var alertTxt = "<p>Something is wrong!<\/p>";
    jQ('#alerts').html(alertTxt);
    return false;
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
