<!DOCTYPE html>
<html lang="en">
 <head>
   @include('includes.head')
 </head>
 <body>
    @include('includes.nav')
    
    <div class="container">
        @yield('content')
    </div>
    
    @include('includes.footer')

    @include('includes.footer-scripts')
 </body>
</html>