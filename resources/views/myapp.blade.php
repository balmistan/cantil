<!DOCTYPE html>
<html>
    <head>
        <title>{{ config('app.name', 'Laravel') }}</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" type="image/png" href="favicon.ico" />
        <link rel="stylesheet" href="https://unpkg.com/purecss@2.0.3/build/pure-min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>$.ajaxSetup({headers: {"X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")}});</script>
        <!--<script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>-->
        <script src="https://cdn.ckeditor.com/ckeditor5/29.1.0/classic/ckeditor.js"></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/29.1.0/classic/translations/de.js"></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/29.1.0/classic/translations/it.js"></script>
    </head>


    <style type="text/css">
        body{
            overscroll-behavior-y: contain;
        }
        #txt{
            padding-left: 10px;
        }
        button{
            min-width: 50px;
            border-radius: 4px;
        }
        .footer{
            position: fixed;
            bottom:0;
            left:0;
            background-color: #ccc;
            width:100%;
            padding: 10px;

        }
        table{
            width:100%;
        }

        details{
            font-size: 1.3em;
        }

        .autor{
            font-weight: bold;
            font-style: oblique;
            font-size: 0.7em !important;
            color:gray;
        }
        .title{
            font-weight: bold;
        }
        #bottom-space{
            height: 60px;
        }
    </style>

    <script type="text/javascript">
        (function ($) {

            var old_lk = "";


            $.fn.get_song = function () {
                var numb = "";
                $.get($("#b_url").val() + "/api/song/" + $("#song_id").val(), function (data) {
                    if (data != undefined) {
                        var lk = data['video'];
                        var newlink = "youtube.com"
                        lk = lk.trim();
                         //lk = lk.replace("youtube.com", newlink);
                        lk = lk.replace("watch?v=", "embed/");
                        lk = lk.replace("youtu.be", newlink + "/embed/");

                        if (lk.indexOf('&') !== -1) {
                            lk = lk.substring(0, lk.indexOf('&'));
                        }
                        if (lk.indexOf(' ') !== -1) {
                            lk = lk.substring(0, lk.indexOf(' '));
                        }
                        console.log(lk)
                        if (lk != old_lk) {
                            $("#video_iframe").attr("src", lk);
                            old_lk = lk;
                        }
                        //alert(lk)
                        numb = data['numb'] ? "&nbsp;&nbsp;" + data['numb'] : '';
                        var head = "<details><summary><span class=\"title\">" + data['title'] + numb + "</span></summary><span class=\"autor\">" + nl2br(data['autor'], true) + "</span></details><br>";
                        $("#txt").html(head + data['txt']);
                    }
                });
            };

            $.fn.get_songs = function () {
                var numb = "";
                $.get($("#b_url").val() + "/api/songsheet/", function (data) {
                    var lyrics = "";

                    var head = "";
                    var txt = "";
                    if (data !== undefined) {
                        for (var i = 0; i < data.length; i++) {
                            txt = data[i]['txt'] ? data[i]['txt'] : "";
                            numb = data[i]['numb'] ? "&nbsp;&nbsp;" + data[i]['numb'] : '';
                            head = "<details><summary><span class=\"title\">" + data[i]['title'] + numb + "</span></summary><span class=\"autor\">" + nl2br(data[i]['autor'], true) + "</span></details><br>";
                            lyrics += head + txt + '<br>';
                        }
                    }
                    $("#txt").html(lyrics);
                });
            };

            /**
             * This function is same as PHP's nl2br() with default parameters.
             *
             * @param {string} str Input text
             * @param {boolean} replaceMode Use replace instead of insert
             * @param {boolean} isXhtml Use XHTML
             * @return {string} Filtered text
             */
            function nl2br(str, replaceMode, isXhtml) {
                str = (str === null || str === undefined) ? '' : str;
                var breakTag = (isXhtml) ? '<br />' : '<br>';
                var replaceStr = (replaceMode) ? '$1' + breakTag : '$1' + breakTag + '$2';
                return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, replaceStr);
            }

        }(jQuery));
    </script>
    @yield('content')
<div id="bottom-space"></div>
    <div class="footer">
        <small>&copy; Copyright 2021 - <b>Email:</b>sangiovanni.daniele@gmail.com</small>
    </div>
</html>
