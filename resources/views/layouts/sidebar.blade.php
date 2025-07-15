<!-- resources/views/layouts/sidebar.blade.php -->
<div id="app-sidepanel" class="app-sidepanel">
    <div id="sidepanel-drop" class="sidepanel-drop"></div>
    <div class="sidepanel-inner d-flex flex-column">
        
        <div class="app-branding">
            <a class="app-logo" href="{{ route('dashboard') }}">
                <img src="{{ asset('assets/img/logo esto Blue.jpg') }}" alt="EST Ouarzazate Logo" class="img-fluid">
            </a>
        </div>

        <nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
            <ul class="app-menu list-unstyled accordion" id="menu-accordion">
                <!-- Tableau de bord -->
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('dashboard') }}">
                        <span class="nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-house-door" viewBox="0 0 16 16">
                                <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z"/>
                            </svg>
                        </span>
                        <span class="nav-link-text">Tableau de bord</span>
                    </a>
                </li>

                <!-- Gestion de Stock -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('stock.index') ? 'active' : '' }}" href="{{ route('societes.index') }}">
                        <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-suitcase" viewBox="0 0 16 16">
    <path d="M6 3.5A1.5 1.5 0 0 1 7.5 2h1A1.5 1.5 0 0 1 10 3.5V4H6v-.5zM11 4v-.5A2.5 2.5 0 0 0 8.5 1h-1A2.5 2.5 0 0 0 5 3.5V4H1.5A1.5 1.5 0 0 0 0 5.5v7A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-7A1.5 1.5 0 0 0 14.5 4H11zm-9 1.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-7z"/>
</svg>
                        </span>
                        <span class="nav-link-text">Sociétés</span>
                    </a>
                </li>


                <!-- Affectation -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('reports.index') ? 'active' : '' }}" href="{{ route('affectations.index') }}">
                        <span class="nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-file-bar-graph" viewBox="0 0 16 16">
                                <path d="M4.5 12a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-1zm3 0a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1zm3 0a.5.5 0 0 1-.5-.5v-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-.5.5h-1z"/>
                                <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
                            </svg>
                        </span>
                        <span class="nav-link-text">Affectation</span>
                    </a>
                </li>

                <!-- Catégorie  -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('reports.index') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                        <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-folder" viewBox="0 0 16 16">
                            <path d="M9.828 4a.5.5 0 0 1 .354.146l.354.354H14a2 2 0 0 1 2 2v5.5a1.5 1.5 0 0 1-1.5 1.5H1.5A1.5 1.5 0 0 1 0 11.5V4.5A1.5 1.5 0 0 1 1.5 3H6l.354-.354A.5.5 0 0 1 6.707 2h3.121a.5.5 0 0 1 .354.146l.354.354H14a2 2 0 0 1 2 2v1H9.828z"/>
                        </svg>
                         </span>
                        <span class="nav-link-text">Catégories</span>
                    </a>
                </li>


                <!-- Produits -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('reports.index') ? 'active' : '' }}" href="{{ route('produits.index') }}">
                        <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-box" viewBox="0 0 16 16">
                            <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5 8.186 1.113zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.841V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
                        </svg>
                        </span>
                        <span class="nav-link-text">Produits</span>
                    </a>
                </li>

                 <!-- Mouvements -->
                 <li class="nav-item">
                    <a class="nav-link submenu-toggle {{ request()->routeIs('entrees.*') || request()->routeIs('sorties.*') ? 'active' : '' }}" href="{{ route('mouvements.index') }}">
                        <span class="nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 11.5a.5.5 0 0 0 .5.5h11.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 11H1.5a.5.5 0 0 0-.5.5zm14-7a.5.5 0 0 1-.5-.5H2.707l3.147-3.146a.5.5 0 1 1 .708.708l-4 4a.5.5 0 0 1 0 .708l4 4a.5.5 0 0 1-.708.708L2.707 5H14.5a.5.5 0 0 1 .5.5z"/>
                            </svg>
                        </span>
                        <span class="nav-link-text">Mouvements</span>
                    </a>
                    
                </li>

                <!-- Déconnexion 
                <li class="nav-item mt-auto">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <span class="nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                                <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                            </svg>
                        </span>
                        <span class="nav-link-text">Déconnexion</span>
                    </a>
                  
                </li>-->
            </ul>
        </nav>
    </div>
</div>

<style>
    /* Style principal */
.app-sidepanel {
    background: linear-gradient(180deg, #1a73e8, #0a5ab6); /* Dégradé pour une touche moderne */
    width: 260px;
    min-height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
    font-family: 'Roboto', sans-serif; /* Typographie moderne */
}

.app-branding {
    padding: 20px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.logo-text {
    color: #fff;
    font-size: 24px;
    font-weight: 600;
    letter-spacing: 0.5px;
}

/* Navigation \nNavigation */
.app-nav-main {
    padding: 15px;
}

.nav-link {
    color: rgba(255, 255, 255, 0.9);
    padding: 14px 20px; /* Augmentation du padding pour les cibles tactiles */
    margin: 6px 0;
    border-radius: 8px;
    display: flex;
    align-items: center;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.nav-link:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateX(5px); /* Effet subtil au survol */
}

.nav-link.active {
    background: #1557b0;
    color: #fff;
    font-weight: 500;
}

.nav-icon {
    width: 24px;
    height: 24px;
    margin-right: 15px;
}

/* Sous-menus */
.submenu {
    margin: 8px 0 8px 35px; /* Indentation accrue pour plus de clarté */
    padding-left: 10px;
    border-left: 2px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease; /* Transition fluide */
}

.submenu-link {
    color: rgba(255, 255, 255, 0.8);
    padding: 10px 15px;
    font-size: 14px;
    position: relative;
    display: block;
}

.submenu-link:hover {
    color: #fff;
}

.submenu-link.active {
    color: #fff;
    font-weight: 500;
}

.submenu-link.active:before {
    content: '';
    position: absolute;
    left: -12px;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 20px;
    background: #fff;
    border-radius: 2px;
}

/* Responsive */
@media (max-width: 1199px) {
    .app-sidepanel {
        transform: translateX(-100%);
        box-shadow: 3px 0 15px rgba(0, 0, 0, 0.2);
    }

    .app-sidepanel.open {
        transform: translateX(0);
    }

    .sidepanel-close {
        color: #fff;
        font-size: 28px;
        padding: 15px;
        display: block;
        text-align: right;
    }

    .sidepanel-drop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
        display: none;
    }

    .app-sidepanel.open ~ .sidepanel-drop {
        display: block;
    }
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Gestion des sous-menus actifs
    const currentPath = window.location.pathname;
    
    document.querySelectorAll('.submenu-link').forEach(link => {
        if (link.href === window.location.href) {
            link.classList.add('active');
            const submenu = link.closest('.submenu');
            if (submenu) {
                submenu.classList.add('show');
                const toggle = document.querySelector(`[data-bs-target="#${submenu.id}"]`);
                if (toggle) {
                    toggle.classList.add('active');
                    toggle.setAttribute('aria-expanded', 'true');
                }
            }
        }
    });

    // Fermeture mobile au clic sur les liens ou l'overlay
    document.querySelectorAll('.nav-link, .submenu-link').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 1200) {
                document.getElementById('app-sidepanel').classList.remove('open');
                document.getElementById('sidepanel-drop').style.display = 'none';
            }
        });
    });

    document.getElementById('sidepanel-drop').addEventListener('click', function() {
        document.getElementById('app-sidepanel').classList.remove('open');
        this.style.display = 'none';
    });
});
</script>