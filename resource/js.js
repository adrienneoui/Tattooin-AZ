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

      var formData = {};

      jQ('#contactForm').find('input[type=text], select').each(function(){
        var $this = jQ(this);
        formData[$this.attr('id')] = $this.val();
      });

      jQ.ajax({
        url: './includes/contact.php',
        type: 'POST',
        data: {data: JSON.stringify(formData)},
        dataType: 'html',
        success: function(data){
          jQ('#content').html(data);
          console.log('done');
        }
      });
    }
  }

  site.moreThumbs();

  if(jQ('#contactForm').length >= 1){
    jQ('#contactForm').find('.buttons input').on('click', function(event){
      event.preventDefault;
      site.contactForm();
    });
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

