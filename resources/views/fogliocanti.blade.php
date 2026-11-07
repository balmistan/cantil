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
        
        $(this).get_songs();

       /* $.get($("#b_url").val() + "/api/songsheet/", function (data) {

            //alert(JSON.stringify(data));

            var txt = "";

            if (data != undefined) {

                for (var i = 0; i < data.length; i++) {
                    txt += parse(data[i]['txt']) + '<br>';
                }
            }
            $("#txt").html(txt);
        });
        function parse(value) {
            return value ? value : "";
        }
*/
    });

</script>
<body>
    @include('mynavbar')
    <input type="hidden" id="b_url" value="{{ url('/') }}" />
    <div id="txt"></div>
</body>

@endsection
