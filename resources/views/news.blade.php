<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>News Around the World</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body>
        <div id="newsapi">
            <nav class="navbar navbar-light bg-info">
                    <p class="navbarText">News Around the World</p>
            </nav>

            <!-- Select news source -->
            <div class="container mt-4">
                <form action="" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="category">Select a News Source:</label>
                        <select name="newsSources" class="form-control" id="newsSources">
                            <option value="{{@$source_id}} : {{@$source_name}}">{{ $response['sourceName'] }}</option>
                            @foreach ($response['newsSources'] as $newsSource)
                                <option value="{{ $newsSource['id'] }} : {{ $newsSource['name'] }}">{{$newsSource['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </form>

                <!-- Display news -->
                <p class="newsSource"> News Source: <strong>{{ $response['sourceName'] }}</strong></p>
                <div class="card-columns justify-center">
                    @foreach($response['news'] as $selected_news)
                        <div class="card my-2 cardBox">
                            <img class="card-img-top" src="{{$selected_news['urlToImage']}}" alt="">
                            <div class="card-body">
                                <h4 class="card-title">{{$selected_news['title']}}</h4>
                                <p class="card-text">
                                    {{$selected_news['description']}}
                                    <a href="{{$selected_news['url']}}" target="_blank"><small>read more...</small></a>
                                </p>
                                <p class="card-text">
                                    <small>
                                        Author: {{ $selected_news['author'] }} <br>
                                        Date Published: {{ $selected_news['publishedAt'] }}
                                    </small>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script>
            $('select').on('change', function() {
                let source =  this.value ;  //gets the selected news source from the news source dropdown menu
                let _token = $('input[name="_token"]').val();

                $.ajax({
                    type: "POST",
                    url: "/source",
                    data: { source: source, _token : _token }, //posts the selected option to our ApiController file
                    success:function(result){
                        // On success it gets `result`, which is a full html page that displays topnews from the news source selected.
                        $('#newsapi').html(result);
                    },

                    error:function(){
                        alert("An error occoured, please try again!")
                    }
                });
            })
        </script>
    </body>
</html>
