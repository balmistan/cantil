
@extends('myapp')

@section('content')

<style type="text/css">
    body{
       overscroll-behavior-y: contain;
    }
    #txt{
        padding-left: 10px;
    }
</style>

<script type="text/javascript">
    $(document).ready(function () { 
        $(this).get_song();
    });

</script>

<body>
     @include('mynavbar')
    <input type="hidden" id="b_url" value="{{ url('/') }}" />
    <input type="hidden" name="id" id="song_id" value="{{ Request::segment(2) }}" />

    <iframe id="video_iframe" src="" width="100%" frameborder="0" allowfullscreen="1" mozallowfullscreen="1" webkitallowfullscreen="1" allow="autoplay"></iframe>
    
    <div id="txt"></div>

</body>

@endsection




