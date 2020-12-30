<!DOCTYPE html>
<html lang="en">
 <head>
   @include('includes.head')
 </head>
 <body>
    @include('includes.mainnav')
    
    <div class="container">
        @yield('content')
    </div>
    
    @include('includes.footer')

    @include('includes.footer-scripts')
 </body>
</html>