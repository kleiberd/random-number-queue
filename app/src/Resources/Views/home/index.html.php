<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <title>Random number generator with RabbitMQ</title>
    <style>
        body {
            padding-top: 4.5rem;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="/">Random number generator with RabbitMQ</a>
</nav>

<main role="main" class="container">
    <div class="jumbotron">
        <button class="btn btn-lg btn-primary" id="generate">Generate number &raquo;</button>
    </div>
    <div id="table-container"></div>
</main>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
<script type="text/javascript">
    var number;
    var pollStarted = false;

    function doPoll(){
        pollStarted = true;
        if(typeof number !== "undefined") {
            jQuery.post('/log?number='+number, function(data) {
                jQuery('#table-container').html(data);
                setTimeout(doPoll, 2500);
            });
        }
    }

    jQuery(document).ready(function() {
        jQuery("#generate").click(function() {
            jQuery.ajax({
                method: "GET",
                url: "/generate",
                dataType: "json"
            })
            .done(function(msg) {
                number = msg.number;
                if (!pollStarted) {
                    doPoll();
                }
            });
        });
    });
</script>
</body>
</html>