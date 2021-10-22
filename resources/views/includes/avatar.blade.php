<div class="container-avatar">

    @if(Auth::user()->image) 

        <img src="{{route('user.avatar',['filename'=>Auth::user()->image])}}" alt="Foto de perfil" class="avatar">

    @endif

</div>