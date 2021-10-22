@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
         @include('includes.message')
                <div class="card pub_image pub_image_detail">

                    <div class="card-header">
                        @if($image->user->image)
                        
                            <div class="container-avatar">
                                <img src="{{route('user.avatar',['filename'=>$image->user->image])}}" alt="Foto de perfil" class="avatar">
                            </div>
                            
                        @endif
                        <div class="data-user">

                            {{ $image->user->name.' '.$image->user->surname }}
                            <span class="nickname">{{ ' | @'.$image->user->nick }}</span>
                            
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="image-container image-detail">
                            <img src="{{ route('image.file',['filename' => $image->image_path]) }}" alt="">
                        </div>
                        
                        <div class="description">
                            
                           <span class="nickname">{{'@'.$image->user->nick.' '}} </span> 
                           <span> {{' | '.\FormatTime::LongTimeFilter($image->created_at)}} </span> 

                           <p> {{$image->description}} </p>
                        
                        </div>

                        <div class="likes">

                            <!-- Comprobar si el usuario le dio like a la imagen -->
                            <?php $user_like = false; ?>

                            @foreach($image->likes as $like)

                                @if($like->user->id == Auth::user()->id)

                                    <?php $user_like = true; ?>

                                @endif

                            @endforeach

                            @if($user_like)
                                <img src="{{asset('img/heart-red.png')}}" data-id="{{$image->id}}" class="btn-dislike" alt="">
                            @else 
                                <img src="{{asset('img/heart-black.png')}}" data-id="{{$image->id}}" class="btn-like" alt="">
                            @endif

                            <span class="number_likes"> {{count($image->likes).' Likes'}} </span>

                        </div>
                        @if(Auth::user() && Auth::user()->id == $image->user->id)

                            <div class="actions">
                                <a href="{{ route('image.edit',['id' => $image->id]) }}" class="btn btn-sm btn-outline-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                    </svg>
                                </a>

                                <!-- <a href="" class="btn btn-sm btn-outline-danger"></a> -->

                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal" data-target="#exampleModal">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" 
                                                fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 
                                                .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 
                                                .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 
                                                2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 
                                                1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 
                                                1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg>

                                    </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">¿Estás seguro que desea eliminar esta imagen? </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        
                                        Si eliminas esta imagen nunca podrás recuperarla...

                                    </div>
                                    <div class="modal-footer">
                                        <a class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</a>

                                        <a href="{{ route('image.delete', ['id' => $image->id]) }}" class="btn btn-outline-danger">Borrar Definitivamente </a>
                                        
                                    </div>
                                    </div>
                                </div>
                                </div>

                            </div>
                        @endif    
                        <div class="clearfix"></div>

                        <div class="comments">

                            <h2> Comentarios ({{count($image->comments)}}) </h2>
                            @foreach($image->comments as $comment)
                            
                                <div class="comment">
                                
                                    <span class="nickname">{{'@'.$comment->user->nick.' '}} </span> 
                                    <span> {{' | '.\FormatTime::LongTimeFilter($comment->created_at)}} </span> 
            
                                    <p> {{$comment->content}} 
                                      
                                        
                                        @if (Auth::check() && ($comment->user_id == Auth::user()->id || $comment->image->user_id == Auth::user()->id)) 
                                        
                                            <a href="{{ route('comment.delete',['id' => $comment->id]) }}" class="btn btn-sm btn-outline-danger">

                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" 
                                                fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 
                                                .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 
                                                .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 
                                                2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 
                                                1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 
                                                1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                </svg>
                                                
                                            </a>
                                        
                                        @endif

                                    </p>
                                    
                                </div>

                            @endforeach
                            <hr>

                            <form action="{{ route('comment.save') }}" method="post">
                                @csrf
                                
                                <!-- Input de tipo hidden para guardar el id de la imagen, para saber en que id se guardará este comentario -->
                                
                                <input type="hidden" name="image_id" value="{{ $image->id }}">
                                <p>
                                    <textarea class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" name="content"></textarea>
                                    <p>
                                        @if ($errors->has('content'))
                                            
                                            <span class="alert alert-danger invalid-feeback" role="alert">
                                                <strong>{{ $errors->first('content') }}</strong>
                                            </span>

                                        @endif
                                    </p>
                                </p>

                                <button type="submit" class="btn btn-success">Enviar</button>
                              
                            </form>

                            

                        </div>

                    </div>
                </div>
        
    </div>
</div>
@endsection
