<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
    	<!-- Google Tag Manager -->
    	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    	})(window,document,'script','dataLayer','GTM-5GQV33K');</script>
    	<!-- End Google Tag Manager -->
    	
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

        <link rel="shortcut icon" href="/libs/comvex-template/img/favicon.ico">
        <meta name="description" content="Comvex">
        <meta name="keywords" content="doutorhoje saúde consulta médico sus plano de saúde">
        <meta name="author" content="Theogenes Ferreira Duarte">

        <title>@yield('title', 'DoutorHJ')</title>

        @push('style')
        <!-- Google fonts -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">

        <!-- Template css -->
        <link type="text/css" rel="stylesheet" href="/libs/home-template/css/bootstrap.min.css"/>
        <link type="text/css" rel="stylesheet" href="/libs/font-awesome-4.7.0/css/font-awesome.min.css"/>

        
        <link type="text/css" rel="stylesheet" href="/libs/home-template/css/style.css"/>

        <!-- DoutorHJ Reset CSS -->
        <link rel="stylesheet" href="/css/doutorhj.style.css">

        <!--[if lt IE 10]>
        <div style="background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;">
            <a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="/libs/home-template/img/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a>
        </div>
        <script src="js/html5shiv.min.js"></script>
        <![endif]-->
        @endpush

        @stack('style')
    </head>
    <body>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5GQV33K" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->

        <div class="tudo terms">
            @yield('content')
        </div>
    </body>
</html>