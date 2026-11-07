@extends('myapp')
@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        var html_data = "";
        var free_indexes = Array();
        var out_config = Array();
        var btn_value = "";
        $("#song-list-table").on("click", "button", function () {
            var id = $(this).attr("_song-id");
            var value = parseInt($(this).html());
            if (isNaN(value)) {
                var index = get_next_freeindex();
                value = index + 1;
                set_outconfig(index, id);
                $(this).html(value.toString());
            } else {
                unset_outconfig(value - 1);
                $(this).html("...");
            }
            save();
        });
        $.getJSON($("#b_url").val() + "/api/songlist", function (data) {

        })
                .done(function (data) {
                    data.forEach(function (entry) {
                        //logica di controllo pulsanti
                        if (entry['position'] == 0) {
                            btn_value = "...";
                        } else {
                            btn_value = entry['position'];
                            set_outconfig(entry['position'] - 1, entry['id']);
                        }

                        html_data += "<tr><td>" + parse(entry['title']) + "</td>";
                        html_data += "<td>" + parse(entry['numb']) + "</td>";
                        html_data += "<td>" + parse(entry['groups']) + "</td>";
                        html_data += "<td style=\"text-align:center;\">" +
                                "<button class=\"pure-button\" _song-id=\"" +
                                entry['id'] + "\">" + btn_value + "</button></td>";
                        html_data += "<td>&nbsp;" + entry['id'] + "</td>";
                        html_data += "</tr>";
                    });
                    $("#song-list-table tbody").html(html_data)

                })
                .fail(function (xhr, textStatus, errorThrown) {
                    console.log(xhr.responseText);
                });


        function save() {
            $.ajax({
                method: "POST",
                url: $("#b_url").val() + "/api/songschoice",
                data: {ids: out_config.toString()}
                //dataType: 'json'
            })
                    .fail(function (xhr, status, error) {
                        //alert('error: ' + xhr.status + ': ' + xhr.statusText)
                    })
                    .done(function (msg) {
                        //alert(msg);
                    });
        }
        

        $("#rst").click(function (e) {
            e.preventDefault();
            free_indexes = Array();
            out_config = Array();
            $("#song-list-table").find("button").each(function () {
                $(this).html("...");
            });
            save();
        });
        function parse(value) {
            return value ? value : "";
        }

        function get_next_freeindex() {
            var index = 0;
            if (free_indexes.length === 0) {
                index = out_config.length;
            } else {
                free_indexes.sort(function (a, b) {
                    return b - a;
                });
                index = free_indexes.pop();
            }

            return index;
        }

        function set_outconfig(index, id) {
            out_config.splice(index, 0, id);
        }

        function unset_outconfig(index) {
            out_config.splice(index, 1);
            free_indexes.push(index);
        }

        //Anteprima
        $("#preview-btn").click(function (e) {
            e.preventDefault();
            $("#preview").get_songs();
            $("#main-view").hide();
            $("#preview-btn").hide();
            $("#preview-close-btn").show();
            $("#preview").show();
        });
        $("#preview-close-btn").click(function (e) {
            e.preventDefault();
            $("#main-view").show();
            $("#preview-btn").show();
            $("#preview-close-btn").hide();
            $("#preview").hide();
        });
    });
</script>

<body>




    <form method="POST" action="{{ route('logout') }}">
        <div class="pure-button-group" role="toolbar" aria-label="...">  
            <a class="pure-button" href="{{ route('lista') }}"> Dashboard</a>
            <button class="pure-button" id="rst"> Azzerra selezione</button>
            <button id="preview-btn" class="pure-button">Mostra Anteprima</button>
            <button id="preview-close-btn" class="pure-button" style="display:none;">Chiudi Anteprima</button>
            @csrf
            <a class="pure-button" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                       this.closest('form').submit();">
                {{ __('Logout') }}
            </a>  
        </div>
    </form>



    <input type="hidden" id="b_url" value="{{ url('/') }}" />
    <div id="main-view" style="width:100%; border:none;">
        <table id="song-list-table" class="pure-table pure-table-bordered">
            <thead>
                <tr>
                    <th>Titolo</th>
                    <th>Nr. canto</th>                
                    <th>Uso</th>     
                    <th>Selezione</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div id="preview" style="width:100%; border:none; display:none;">
        <div id="txt"></div>
    </div>
</body>
@endsection