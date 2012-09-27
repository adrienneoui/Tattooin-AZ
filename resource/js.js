var jQ = jQuery,
    site = {
      data: {}
    };

jQ(function(){
  site = {
    data:{
      allImgs: (typeof allImgs != 'undefined') ? allImgs : '',
      thumbPage: 1
    },
    runCluster: function(oldRand){
      var miniCount = site.data.miniLength - 1;

      rand = Math.round(Math.random()*miniCount);

      while (rand>miniCount && rand<=0 && rand==oldRand){
        rand = Math.round(Math.random()*miniCount);
      }

      jQ("#cluster_"+rand).find('img').attr('src', './resource/artwork/mini/'+ site.data.miniFeed[rand]['image']);

      t=setTimeout("site.runCluster("+rand+")", 10 * 1000);
    },
    artShow: function(el){
      var data = el.data("image");

      if(data.name !== jQ('#imgName').text()){
        jQ("#thumbsMove").find('.selected').removeClass('selected');

        jQ('#imageViewer').find('img').fadeOut(function(){
          jQ(this).attr('src','./resource/artwork/'+ data.cat +'/'+ data.img).delay(200).fadeIn();
          el.addClass('selected');
        });
        jQ('#imgName').fadeOut(function(){
          jQ(this).text(data.name).delay(200).fadeIn();
        });
      }
    },
    moreThumbs: function(){
      var $thumbs = jQ('#thumbs').find('.thumbNail'),
          $nextPrev = jQ('#nextPrev'),
          thumbCount = jQ('#thumbsMove').find('.thumbNail').length;

      jQ('#nextPrev').find('a').click(function(event){
        event.preventDefault();
        var $this = jQ(this),
            upDown = '';

        if($this.hasClass('next')){
            upDown = '-=360';
            site.data.thumbPage += 1;
        } else {
          upDown = '+=360';
            site.data.thumbPage -= 1;
        }

        if(thumbCount > (site.data.thumbPage * 18)){
          $nextPrev.find('a.next').removeClass('hide');
        }else{
          $nextPrev.find('a.next').addClass('hide');
        }

        if(site.data.thumbPage > 1){
          $nextPrev.find('a.prev').removeClass('hide');
        }else{
          $nextPrev.find('a.prev').addClass('hide');
        }

        jQ('#thumbsMove').animate({
          marginTop: upDown
        },
        100);
      });
    },
    contactForm: function() {
      jQ(document).on("click", "#contactForm .buttons input", function(event){
        event.preventDefault;
        if(jQ(this).val() === 'SUBMIT'){
          var formData = {};

          jQ('#contactForm').find('input[type=text], select, textarea').each(function(){
            var $this = jQ(this);
            formData[$this.attr('id')] = $this.val();
          });

          jQ.ajax({
            url: './includes/contact.php',
            type: 'POST',
            data: {data: JSON.stringify(formData)},
            dataType: 'html',
            success: function(data){
              jQ('#content').html(data).on("focus",  "input[type=text], select", function(){
                var $this = jQ(this);
                $this.focus(function(){
                  if($this.hasClass('error')){
                    $this.removeClass('error').val('');
                  }
                });
              });
            }
          });
        }else{
          jQ('#content').find("input[type=text], select, textarea").each(function(){
            jQ(this).removeClass('error').val('');
          });
        }
      });
    }
  }

  site.moreThumbs();

  if(jQ('#contactForm').length >= 1){
    site.contactForm();
  }

  jQ(document).find('.thumbNail a').on('click', function(event){
    event.preventDefault;
    site.artShow(jQ(this));
  });

  jQ.ajax({
    url: './data/mini-imgs.json',
    dataType: 'json',
    success: function(data){
      site.data.miniFeed = data
      site.data.miniLength = data.length;
      site.runCluster(0);
    }
  });

  setTimeout("site.runCluster(0)", 10 * 1000);
});

