<div class="app-header-inner">  
    <div class="container-fluid py-2">
        <div class="app-header-content"> 
            <div class="row justify-content-between align-items-center">
            
            <div class="col-auto">
                <a id="sidepanel-toggler" class="sidepanel-toggler d-inline-block d-xl-none" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" role="img"><title>Menu</title><path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" d="M4 7h22M4 15h22M4 23h22"></path></svg>
                </a>
            </div>
            <div class="col-auto">
                <div id="currentTime" class="current-time"></div>
            </div>

            <div class="app-utilities col-auto">
                
                <div class="app-utility-item app-user-dropdown dropdown">
                    <a class="dropdown-toggle" id="user-dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                        <img src="{{asset('assets/img/default-avatar.png')}}" alt="user profile">
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">
                        <!-- Update the link to point to the profile page -->
                        <li><a class="dropdown-item" href="{{route('profile.show')}}">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Déconnecter
                            </a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </ul>
                </div><!--//app-user-dropdown--> 
            </div><!--//app-utilities-->
        </div><!--//row-->
        </div><!--//app-header-content-->
        <script>
            function updateTime() {
                const timeElement = document.getElementById('currentTime');
                const now = new Date();
                const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', hour12: false, timeZone: 'Europe/Paris' };
                timeElement.textContent = now.toLocaleString('fr-FR', options); // Set locale to French
            }
            setInterval(updateTime, 1000);
            updateTime();
        </script>
    </div><!--//container-fluid-->
</div><!--//app-header-inner-->