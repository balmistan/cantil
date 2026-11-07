
<div class="pure-button-group" role="toolbar" aria-label="...">
    <form method="POST" action="{{ route('logout') }}">
        <!--<a class="pure-button" href="{{ route('indicecanti') }}/0">Indice completo</a>
        <a class="pure-button" href="{{ route('indicecanti') }}/1">Indice parziale</a>
        <a class="pure-button" href="{{ route('fogliocanti') }}">Foglio canti</a>-->
        <a class="pure-button" href="{{ route('lista') }}">Dashboard</a>
        @auth
        @csrf    
        <a class="pure-button" href="{{ route('logout') }}"
           onclick="event.preventDefault();
                   this.closest('form').submit();">
            {{ __('Logout') }}
        </a>
        @endauth
    </form>

</div>
