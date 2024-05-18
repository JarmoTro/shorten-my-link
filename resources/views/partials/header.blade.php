<header>

    <div class="container header-container">

        <h1>
            <a href="/" title="Home page"><img class="logo" src="/images/logo.svg" alt="Shorten My Link logo"></a>
        </h1>

        <button type="button" aria-label="Open menu" id="mobile-menu-toggler">
            <img src="/images/mobile-menu-bars.svg" alt="">
        </button>

        <nav>

            <ul class="nav-links">

                @guest

                <li><a href="/login">Login/register</a></li>

                @endguest

                @auth

                <li><a href="/my-links">My links</a></li>

                @endauth

                <li><a href="/faq">FAQ</a></li>

            </ul>
            
        </nav>

    </div>

</header>