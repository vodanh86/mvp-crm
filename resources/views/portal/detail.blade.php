<!DOCTYPE html>
<html lang="en">
  @include('includes.header')
  <body>
  
  <div class="site-wrap">

    <div class="site-mobile-menu">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div> <!-- .site-mobile-menu -->
    @include('includes.menu')	
    <div class="site-blocks-cover inner-page overlay" style="background-image: url(../images/hero_bg_2.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-7 text-center">
            <h1 class="mb-5">Tin tức</h1>
          </div>
        </div>
      </div>
    </div>  

    <div class="site-section bg-light">
      <div class="container">
        <div class="row">
       
          <div class="container">
            <div class="main-content">
              <div class="sidebar-left animate__animated animate__fadeInLeft" data-animate="animate__fadeInLeft">
                <div class="link-vector no-form">
                  <h1 class="page-title">{{$page->title}}</h1>
                </div>
                <div class="blog-detail-author">
                  <div class="img-avatar"><img src="images/blog/author.png" alt="" /></div>
                  <div class="blog-detail-author-info">
                    <span class="name">Nguyễn Văn An</span>
                    <span class="date">{{$page->created_at}}</span>
                  </div>
                </div>
                <div class="blog-description">
                  <img class="img-fluid" alt="" src="{{ URL::asset($page->img) }}"/>
                {!!$page->content!!}
                </div>
              </div>
            </div>
          </div>


        </div>
      </div>
    </div>
    @include('includes.footer')	
   
   </div>
   @include('includes.js')	
  </body>
</html>