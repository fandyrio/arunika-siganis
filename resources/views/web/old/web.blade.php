<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="{!! asset('../resources/views/web/assets/paper_img/favicon.ico') !!}">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Paper Kit by Creative Tim</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <link href="{!! asset('../resources/views/web/bootstrap3/css/bootstrap.css') !!}" rel="stylesheet" />
    <link href="{!! asset('../resources/views/web/assets/css/ct-paper.css') !!}" rel="stylesheet"/>
    <link href="{!! asset('../resources/views/web/assets/css/demo.css') !!}" rel="stylesheet" />
    <link href="{!! asset('../resources/views/web/assets/css/style_me.css') !!}" rel="stylesheet" />
    
    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>

</head>
<body>
<nav class="navbar navbar-ct-transparent" role="navigation-demo" id="demo-navbar" style='background-color:#141D38'>
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="{!! url('/home') !!}">
           <div class="logo-container" style='width:400px'>
                <div class="logo" style='width:60px;float:left;'>
                    <img src="{!! asset('../resources/upload/config/20241113095557-arunika.jpg') !!}" alt="Creative Tim Logo">
                </div>
                <div class="brand" style="float:left;line-height:1.2rem;font-family:Poppins, Helvetica, 'sans-serif'">
                  <h5 style='line-height:0.1rem;float:left;font-family:Poppins, Helvetica, "sans-serif" !important'>ARUNIKA</h5>
                  <span style='font-size:1rem;font-weight:bold;line-height:1rem;float:left;font-family:Poppins, Helvetica, "sans-serif" !important;width:150px;'>Artikel Hukum Hakim <br /> <span style='color:#EB5E28;float:left;font-family:Poppins, Helvetica, "sans-serif" !important'>Indonesia</span></span>
                </div>
            </div>
      </a>
    </div>
    
<!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navigation-example-2">
    <ul class="nav navbar-nav navbar-left">
      
    </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
          <!--                                  You can add classes for different colours on the next element -->
              <ul class="dropdown-menu dropdown-menu-right">
                <li class="dropdown-header">Dropdown header</li>
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li><a href="#">Separated link</a></li>
                <li class="divider"></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
          <li>
            <a href="documentation/tutorial-components.html" class="btn btn-danger btn-simple">Components</a>
          </li>
          <!-- <li>
            <a href="tutorial.html" class="btn btn-danger btn-simple">Tutorial</a>
          </li> -->
          <li>
            @if(isset(Auth::user()->name))
            <a href="dashboard" target="_blank" class="btn btn-danger btn-fill">{!! Auth::user()->name !!}</a>
            @else
              <a href="login" target="_blank" class="btn btn-danger btn-fill">Login</a>
            @endif

          </li>
       </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-->
</nav>


<div class="wrapper">
    

    <div class="main">
        <div class="section" style='min-height:700px;background-color:white;'>
         <div class="container tim-container">
          @yield('content')
        </div>
    </div>

    <footer class="footer-demo section-dark" style=''>
    <div class="container">
        <nav class="pull-left">
            <ul>

                <li>
                    <a href="http://www.creative-tim.com">
                        Creative Tim
                    </a>
                </li>
                <li>
                    <a href="http://blog.creative-tim.com">
                       Blog
                    </a>
                </li>
                <li>
                    <a href="http://www.creative-tim.com/product/rubik">
                        Licenses
                    </a>
                </li>
            </ul>
        </nav>
        <div class="copyright pull-right">
            &copy; 2015, made with <i class="fa fa-heart heart"></i> by Creative Tim
        </div>
    </div>
</footer>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth. Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar. </p>
      </div>
      <div class="modal-footer">
        <div class="left-side">
            <button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Never mind</button>
        </div>
        <div class="divider"></div>
        <div class="right-side">
            <button type="button" class="btn btn-danger btn-simple">Delete</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!--    end modal -->


</body>

    <script src="{!! asset('../resources/views/web/assets/js/jquery-1.10.2.js') !!}" type="text/javascript"></script>
	<script src="{!! asset('../resources/views/web/assets/js/jquery-ui-1.10.4.custom.min.js') !!}" type="text/javascript"></script>

	<script src="{!! asset('../resources/views/web/bootstrap3/js/bootstrap.js') !!}" type="text/javascript"></script>

	<!--  Plugins -->
	<script src="{!! asset('../resources/views/web/assets/js/ct-paper-checkbox.js') !!}"></script>
	<script src="{!! asset('../resources/views/web/assets/js/ct-paper-radio.js') !!}"></script>
	<script src="{!! asset('../resources/views/web/assets/js/bootstrap-select.js') !!}"></script>
	<script src="{!! asset('../resources/views/web/assets/js/bootstrap-datepicker.js') !!}"></script>

	<script src="{!! asset('../resources/views/web/assets/js/ct-paper.js') !!}"></script>
  <script src="{!! asset('../resources/views/web/assets/js/services.js') !!}"></script>
  <script>
</script>
</html>
