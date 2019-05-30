<ul class="nav nav-pills flex-column">
    <li class="nav-item">
        <a class="nav-link {{ request()->is('home*') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('contato*') ? 'active' : '' }}" href="{{ route('contato.index') }}">Contato</a>
    </li>
</ul>
