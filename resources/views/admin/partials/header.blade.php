<header class="bg-dark">
    <nav class="navbar navbar-dark">
        <div class="container-fluid">
          <a href="{{ route('home') }}" target="_blank" class="navbar-brand">Vai al sito</a>

          <div class="d-flex">
            <form class="me-3" action="{{ route('admin.search') }}" method="GET">
                <input name="toSearch" class="form-control mr-sm-2" type="search" placeholder="Cerca" aria-label="Search">
            </form>
            <a href="{{ route('profile.edit') }}" class="text-white text-decoration-none me-3">{{ Auth::user()->name }}</a>
            <form action="{{ route('logout') }}" method="POST" class="d-flex" role="search">
                @csrf
                <button class="btn btn-light " type="submit"><i class="fa-solid fa-right-from-bracket"></i></button>
              </form>
          </div>

        </div>
      </nav>
</header>
