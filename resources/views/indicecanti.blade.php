@extends('myapp')
@section('content')
<script type="text/javascript">
    $(document).ready(function () {

        var html_data = "";
        var status = "";

        $("#song-list-table").on("click", "button", function () {
            window.location = $("#b_url").val() + "/visualizza/" + $(this).attr("_song-id");
            //alert($(this).attr("_song-id"))
        });
    
        $.getJSON($("#b_url").val() + "/api/songlist/" + $("#param_url").val(), function (data) {
            //alert(JSON.stringify(data))
            //$("#result").html(data);
        })
                .done(function (data) {
                    data.forEach(function (entry) {
                        if (entry['status'] == "1") {
                            status = ' style="color:orange" ';
                        } else if (entry['status'] == "2") {
                            status = ' style="color:green" ';
                        } else {
                            status = ' style="color:red" ';
                        }
                        html_data += "<tr><td>" + parse(entry['title']) + "</td>";
                        html_data += "<td>" + parse(entry['numb']) + "</td>";
                        html_data += "<td>" + parse(entry['groups']) + "</td>";
                        html_data += "<td><button _song-id=\"" + entry['id'] + "\"" + status + ">Visualizza</button></td>";
                        html_data += "</tr>";

                        //alert(JSON.stringify(entry));
                    });

                    $("#song-list-table tbody").html(html_data)

                })
                .fail(function (xhr, textStatus, errorThrown) {
                    console.log(xhr.responseText);
                });

        function parse(value) {
            return value ? value : "";
        }


    });

</script>

<body>
    @include('cookieConsent::index')
    @include('mynavbar')
    <input type="hidden" id="b_url" value="{{ url('/') }}" />
     <input type="hidden" id="param_url" value="{{ collect(request()->segments())->last() }}" />
    <table id="song-list-table" class="pure-table pure-table-bordered">
        <thead>
            <tr>
                <th>Titolo</th>
                <th>Nr. canto</th>              
                <th>Uso</th>
                <th></th> 
              
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>


</body>
@endsection



