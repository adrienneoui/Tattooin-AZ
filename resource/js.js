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
      var data = JSON.parse(el.attr('js-data'));
      jQ('#imageViewer').find('img').attr('src','./resource/artwork/'+ data.cat +'/'+ data.img);
      jQ('#imgName').text(data.name);
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
      var $error = jQ(document).find('.contact .error');

      jQ('#contactForm').find('input').each(function(){
        var $this = jQ(this);

        $this.focus(function(){
          $this.val('').css('color','#000');
          $error.slideUp(function(){
            $error.find('div').replaceWith('');
          });
        });

        if($this.attr('id') === 'name') {
          if($this.val() === '' || $this.val().length === 0){
            $this.val('Your Name').css('color','#f00');
          }
        }

        if($this.attr('id') === 'email') {
          if($this.val() === '' || $this.val().length === 0){
            $this.val('Email Address').css('color','#f00');
          }else if($this.val().search(/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i) === -1){
            $error.append('<div>Your email address appears to be invalid.</div>');
          }
        }

        if($this.attr('id') === 'phone') {
          var phoneNum = $this.val();
          phoneNum = phoneNum.replace(/\(|\)|-|\.|_/gi, '');

          if($this.val() === '' || $this.val().length === 0){
            $this.val('Phone Number w/ Area Code').css('color','#f00');
          }else if(phoneNum.search(/[0-9]{10,11}/ig) === -1){
            $error.append('<div>Your phone number appears to be invalid.</div>');
          }
        }
      });

      jQ('#contactForm').find('select').each(function(){
        var $this = jQ(this);

        $this.focus(function(){
          $this.css('color','#000');
        });
        if($this.val() === '0'){
          $this.css('color','#f00');
        }
      });

      if($error.text().length > 0){
        $error.slideDown();
        return false;
      }

      jQ('#contactForm').submit();

    }
  }

  site.moreThumbs();

  if(jQ('#contactForm').length >= 1){
    jQ('#contactForm').delegate('.buttons input', 'click', function(event){
      event.preventDefault;
      site.contactForm();
    });
  }

  jQ('.thumbNail a').on('click', function(event){
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

