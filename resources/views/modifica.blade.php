@extends('myapp')

@section('content')

    <script type="text/javascript" xmlns="http://www.w3.org/1999/html">
        $(document).ready(function () {

            ClassicEditor.defaultConfig = {
                toolbar: {
                    items: [
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        '|',
                        'bulletedList',
                        'numberedList',
                        '|',
                        'insertTable',
                        '|',
                        'imageUpload',
                        '|',
                        'undo',
                        'redo'
                    ]
                },
                image: {
                    toolbar: [
                        'imageStyle:full',
                        'imageStyle:side',
                        '|',
                        'imageTextAlternative'
                    ]
                },
                table: {
                    contentToolbar: [ 'tableColumn', 'tableRow', 'mergeTableCells' ]
                },

            };

            $.get($("#b_url").val() + "/api/song/" + $("#song_id").val(), function (data) {
                //alert(JSON.stringify(data));

                $('input[name="numb"]').val(data['numb']);
                $('input[name="title"]').val(data['title']);
                $('#autor').html(data['autor']);
                $('input[name="video"]').val(data['video']);
                $('input[name="groups"]').val(data['groups']);
                $('input[name="description"]').val(data['description']);
                $('select[name="status"]').val(data['status']);

                //CKEDITOR.instances.editor1.setData(data['txt'])

                $("#editor1").html(data['txt']);
                ClassicEditor
                    .create( document.querySelector( '#editor1' ), {
                        language: 'it'
                })
                    .then( newEditor => {
                        editor = newEditor;
                    } )
                    .catch( error => {
                        console.error( error );
                    } );
            });


            $("#save-btn").click(function (ev) {
                ev.preventDefault();
                var data = $('#form1').serializeArray();

                data.push({
                    name: 'txt', value: editor.getData()    //CKEDITOR.instances.editor1.getData()
                });

                //alert(JSON.stringify(data))
                $.ajax({
                    method: "PUT",
                    url: $("#b_url").val() + "/api/song/" + $("#song_id").val(),
                    data: data
                }).done(function (msg) {

                });
            });

            //Anteprima
            $("#preview-btn").click(function (e) {
                e.preventDefault();
                $("#preview").get_song();
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
    <input type="hidden" id="b_url" value="{{ url('/') }}"/>
    <form method="POST" action="{{ route('logout') }}">
        <div class="pure-button-group" role="toolbar" aria-label="...">
            <a class="pure-button" href="{{ route('lista') }}"> << Torna alla lista canti</a>
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

    <div id="main-view" style="width:100%; border:none;">
        <form id="form1" class="pure-form pure-form-aligned">
            <fieldset>
                <div class="pure-control-group ">
                    <label for="aligned-numb">Nr. canto</label>
                    <input type="text" name="numb" id="aligned-numb" value="" class="pure-input-1-5"/>
                    <input type="hidden" name="id" id="song_id" value="{{ Request::segment(2) }}"/>
                </div>
                <div class="pure-control-group">
                    <label for="aligned-title">Titolo</label>
                    <input type="text" name="title" id="aligned-title" value="" class="pure-input-1-2"/>
                </div>
                <div class="pure-control-group">
                    <label for="autor">Autore</label>
                    <textarea id="autor" name="autor" class="pure-input-1-2" rows="5"></textarea>
                </div>
                <div class="pure-control-group">
                    <label for="aligned-link">Link video</label>
                    <input type="text" name="video" id="aligned-link" value="" class="pure-input-1-2"/>
                </div>
                <div class="pure-control-group">
                    <label for="aligned-use">Uso</label>
                    <input type="text" name="groups" id="aligned-use" value="" class="pure-input-1-2"/>
                </div>
                <div class="pure-control-group">
                    <label for="description">Commenti</label>
                    <input type="text" name="description" id="description" value="" class="pure-input-1-2"/>
                </div>
                <div class="pure-control-group">
                    <label for="multi-state">Stato</label>
                    <select name="status" id="multi-state" class="pure-input-1-5">
                        <option value="0">Non controllato</option>
                        <option value="1">In lavorazione</option>
                        <option value="2">Completato</option>
                    </select>
                    <button id="save-btn" class="pure-button">Salva pagina</button>
                </div>


                <textarea name="txt" id="editor1"></textarea>

            </fieldset>

        </form>
    </div>
    <div id="preview" style="width:100%; border:none; display:none;">
        <iframe id="video_iframe" src="" width="100%" frameborder="0" allowfullscreen="1" mozallowfullscreen="1"
                webkitallowfullscreen="1" allow="autoplay"></iframe>
        <div id="txt"></div>
    </div>

    </body>

@endsection



