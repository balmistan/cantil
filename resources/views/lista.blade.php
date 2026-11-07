@extends('myapp')
@section('content')
<script type="text/javascript">
    $(document).ready(function () {

        var html_data = "";
        var status = "";
        var btn_value = ""; //for choice buttons
        $("#song-list-table").on("click", ".viewbutton", function () {
            window.location = $("#b_url").val() + "/visualizza/" + $(this).attr("_song-id");
            //alert($(this).attr("_song-id"))
        });
        $("#song-list-table").on("click", ".modbutton", function () {
            window.location = $("#b_url").val() + "/modifica/" + $(this).attr("_song-id");
            //alert($(this).attr("_song-id"))
        })

        $.getJSON($("#b_url").val() + "/api/songlist", function (data) {
            //alert(JSON.stringify(data))
            //$("#result").html(data);
        })
                .done(function (data) {
                    data.forEach(function (entry) {

                        if (entry['status'] == "1") {
                            status = '<span style="color:orange">in lavorazione</span>';
                        } else if (entry['status'] == "2") {
                            status = '<span style="color:green">completato</span>';
                        } else {
                            status = '<span style="color:red">non esaminato</span>';
                        }
//logica di controllo pulsanti selezione
                        if (entry['position'] == 0) {
                            btn_value = "...";
                        } else {
                            btn_value = entry['position'];
                            set_outconfig(entry['position'] - 1, entry['id']);
                        }

                        html_data += "<tr><td style=\"text-align:center;\">" +
                                "<button class=\"pure-button choiche\" _song-id=\"" +
                                entry['id'] + "\">" + btn_value + "</button></td>"
                        html_data += "<td>" + parse(entry['title']) + "</td>";
                        html_data += "<td>" + parse(entry['numb']) + "</td>";
                        //html_data += "<td>" + parse(entry['video']) + "</td>";
                        html_data += "<td>" + parse(entry['groups']) + "</td>";
                        html_data += "<td>" + status + "</td>";
                        html_data += "<td><button class=\"modbutton\" _song-id=\"" + entry['id'] + "\">Modifica</button></td>";
                        html_data += "<td><button class=\"viewbutton\" _song-id=\"" + entry['id'] + "\">Visualizza</button></td>";
                        html_data += "<td>" + parse(entry['description']) + "</td>";
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

        ///////////////////////////////////////////// Scelta canti ////////////////////////////////
        //var html_data = "";
        var free_indexes = Array();
        var out_config = Array();

        $("#song-list-table").on("click", ".choiche", function () {
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


        $("#rst").click(function () {
            $(".choiche").each(function () {
                $(this).html("...");
            });
            free_indexes = Array();
            out_config = Array();

            save();
        });
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
        ///////////////////////////////////////////////////////////////////////////////////////////


    });</script>

<body>

    @include('mynavbar')


<input type="hidden" id="b_url" value="{{ url('/') }}" />
<table id="song-list-table" class="pure-table pure-table-bordered">
    <thead>
        <tr>
            <th style="text-align: center;"><button class="pure-button" id="rst"> Azzera selezione</button><br>Scelta canti</th>
            <th>Titolo</th>
            <th>Nr. canto</th>
            <!--<th>Link Youtube</th>-->
            <th>Uso</th>
            <th>Stato</th>
            <th></th>
            <th></th>
            <th>Commenti</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>


</body>





@endsection

