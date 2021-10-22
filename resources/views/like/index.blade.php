@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <h1>Mis imágenes favoritas</h1>
            <hr>
            
            @foreach($likes as $like)

                <!-- Mostrar tarjetas de una imágen -->
                @include('includes.image',['image'=> $like->image])
            
            @endforeach
           
            <!-- PAGINACION -->
            <div class="clearfix"></div>
            {{$likes->links()}}
            
        </div>
    </div>
</div>
@endsection
