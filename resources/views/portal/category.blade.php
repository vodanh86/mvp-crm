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

    <div class="site-blocks-cover inner-page overlay" style="background-image: url(images/hero_bg_2.jpg);" data-aos="fade" data-stellar-background-ratio="0.5">
      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-7 text-center">
            <h1 class="mb-5">News &amp; <strong>Updates</strong></h1>
          </div>
        </div>
      </div>
    </div>  

    <div class="site-section">
      <div class="container">
        <div class="row mb-5">
		<?php foreach($pages as $page) { ?>
          <div class="col-md-6 col-lg-4 mb-4" >
            <div class="post-entry bg-white" style="height: 100%">
              <div class="image">
                <a href="{{url('detail/' . $page->id)}}"><img src="{{url($page->img)}}" alt="Image" class="img-fluid"></a>
              </div>
              <div class="text p-4">
                <h2 class="h5 text-black"><a href="{{url('detail/' . $page->id)}}">{!!$page->title!!}</a></h2>
                <span class="text-uppercase date d-block mb-3"><small>{{$page->created_at}}</small></span>
                <p class="mb-0">{!!$page->description!!}</p>
              </div>
            </div>
          </div>
		<?php } ?>
        
        </div>

        <div class="row">
          <div class="col-md-12 text-center">
		  <ul class="pagination justify-content-end">
				{{$pages->links("pagination::bootstrap-4")}}
			</ul>
          </div>
        </div>
      </div>
    </div>

    @include('includes.footer')	
   
   </div>
   @include('includes.js')	
  </body>
</html>