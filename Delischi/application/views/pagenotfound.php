<!DOCTYPE html>
<html>

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 Page Not Found</title>
    <script src="<?php echo base_url(); ?>public/js/pace.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="shortcut icon" href="<?php echo base_url() ?>favicon.ico" />
    <link href="<?php echo base_url(); ?>public/css/normalize.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>public/css/skeleton.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>public/css/custom.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Cabin|Raleway:400,600,700" rel="stylesheet">

  </head>

  <body style="background-color:#fff">

    <section>

      <div class="div-404">

        <div class="row">
          <div class="six columns" style="padding:30px;">
            <center>
              <img class="img-404" src="<?php echo base_url();?>public/images/404.gif" />
            </center>
          </div>
          <div class="six columns" style="padding:30px;">
            <div class="msg-404">
              <h1>Oops!</h1>
              <h4>The page you requested cannot be found.</h4>
              <br>
              <button class="button-primary" type="button" onclick='history.go(-1)' id="btn-404" name="btn-404">Go Back</button>
            </div>
          </div>
        </div>

      </div>

    </section>

  </body>

</html>
