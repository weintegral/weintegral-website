<!-- ======= Header ======= -->
<header id="header" class="d-flex align-items-center">
    <div class="container d-flex justify-content-between align-items-center">

        <div class="logo">
            <h1><a href="/">WeIntegral</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="/"><img src="resources/img/logo.png" alt="" class="img-fluid"></a>-->
        </div>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="{{ (request()->is('/')) ? 'active' : '' }}" href="/">Home</a></li>
                <li><a class="{{ (request()->is('about')) ? 'active' : '' }}" href="/about">About</a></li>
                <li><a class="{{ (request()->is('services')) ? 'active' : '' }}" href="/services">Services</a></li>
                <li><a class="{{ (request()->is('clients')) ? 'active' : '' }}" href="/clients">Clients</a></li>
                {{--<li><a href="/industries">Industries</a></li>--}}
                {{--<li><a class="{{ (request()->is('team')) ? 'active' : '' }}" href="/team">Team</a></li>--}}
                <li><a class="{{ (request()->is('blog')) ? 'active' : '' }}" href="/blog" target="_blank">Blog</a></li>
                <li><a class="{{ (request()->is('career')) ? 'active' : '' }}" href="/career">Career</a></li>
                <li><a class="{{ (request()->is('contact')) ? 'active' : '' }}" href="/contact">Contact</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header>
<!-- End Header -->
