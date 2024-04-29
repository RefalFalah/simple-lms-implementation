<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="{{ route('home') }}">Refal Courses</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" aria-current="page" href="{{ route('home') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->is('create-user') ? 'active' : '' }}" aria-current="page" href="{{ route('create-user') }}">Create User</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->is('create-courses') ? 'active' : '' }}" aria-current="page" href="{{ route('create-courses') }}">Create Course</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->is('list-all-courses') ? 'active' : '' }}" aria-current="page" href="{{ route('list-all-courses') }}">All Courses</a>
          </li>
        </ul>
      </div>
    </div>
</nav>
