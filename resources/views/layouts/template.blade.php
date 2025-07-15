
<!DOCTYPE html>
<html lang="en"> 
<head>
    <title>Gestion de Stock </title>
    
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta name="description" content="Portal - Bootstrap 5 Admin Dashboard Template For Developers">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">    
    <link rel="shortcut icon" href="favicon.ico"> 


    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/Logo_Ibn_Zohr-removebg-preview.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    
    <!-- FontAwesome JS-->
    <script defer src="{{asset('assets/plugins/fontawesome/js/all.min.js')}}"></script>
    <script src="https://kit.fontawesome.com/your-kit-id.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- App CSS -->  
    <link id="theme-style" rel="stylesheet" href="{{asset('assets/css/portal.css')}}">
    <!--chart.js-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <!-- Loader CSS -->
     <style>
        /* Loader container */
        .loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 1;
            transition: opacity 0.5s ease-out;
        }

        .loader-container.hidden {
            opacity: 0;
            pointer-events: none;
        }

        /* Loader animation */
        .loader {
            width: 50px;
            aspect-ratio: 1;
            display: grid;
            border: 4px solid transparent;
            border-radius: 50%;
            border-right-color:rgb(13, 114, 139);
            animation: l15 1s infinite linear;
        }

        .loader::before,
        .loader::after {    
            content: "";
            grid-area: 1/1;
            margin: 2px;
            border: inherit;
            border-radius: 50%;
            animation: l15 2s infinite;
        }

        .loader::after {
            margin: 8px;
            animation-duration: 3s;
        }

        @keyframes l15 { 
            100% { transform: rotate(1turn); }
        }
    </style>

</head> 

<body class="app">   
    
<div class="loader-container" id="loader">
        <div class="loader"></div>
    </div>

    <header class="app-header fixed-top">	   	            
     @include('layouts.topbar')
     @include('layouts.sidebar')
    </header><!--//app-header-->
    
    <div class="app-wrapper">
	    
	    <div class="app-content pt-3 p-md-3 p-lg-4">
		    <div class="container-xl">
			    @yield('content')
                @yield('scripts')

			    
		    </div><!--//container-fluid-->
	    </div><!--//app-content-->
	    
	    
	    
    </div><!--//app-wrapper-->    					

 
    <!-- Javascript -->          
    <script src="{{asset('assets/plugins/popper.min.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>  

    <!-- Charts JS -->
    <script src="{{asset('assets/plugins/chart.js/chart.min.js')}}"></script> 
    <script src="{{asset('assets/js/index-charts.js')}}"></script> 
    
    <!-- Page Specific JS -->
    <script src="{{asset('assets/js/app.js')}}"></script> 
       <!-- Loader JS -->
       <script>
        document.addEventListener('DOMContentLoaded', () => {
            const loader = document.getElementById('loader');

            // Hide loader when page is fully loaded
            window.addEventListener('load', () => {
                setTimeout(() => {
                    loader.classList.add('hidden');
                }, 200); // Delay for smooth transition
            });

            // Optional: Show loader during form submissions
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', () => {
                    loader.classList.remove('hidden');
                });
            });
        });
    </script>

</body>
</html> 

