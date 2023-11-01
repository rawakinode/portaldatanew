<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main/app-dark.css') }}">

    <style>
        .containerXY {
            position: absolute;
            top: 50%;
            left: 50%;
            -moz-transform: translateX(-50%) translateY(-50%);
            -webkit-transform: translateX(-50%) translateY(-50%);
            transform: translateX(-50%) translateY(-50%);
        }
    </style>
</head>

<title>Login | Portal Data Untad</title>
</head>

<body style="background-color: #f2f7ff">
    <div class="containerXY">
      <div class="card">
        <div class="card-body">
            <center class="mb-3"><img src="/images/untadlogo.png" alt="" height="50px"></center>
          <h3 class="mb-4"><center>Portaldata.</center></h3>
          <p>Please login to continue</p>
        <form action="/auth/login" method="post" class="mb-2">
          @csrf
          <div class="form-group position-relative has-icon-left mb-4">
              <input type="text" class="form-control" placeholder="Username" name="username" id="username" required>
              <div class="form-control-icon">
                  <i class="bi bi-person"></i>
              </div>
          </div>
          <div class="form-group position-relative has-icon-left mb-4">
              <input type="password" class="form-control" placeholder="Password" name="password" id="password" required>
              <div class="form-control-icon">
                  <i class="bi bi-shield-lock"></i>
              </div>
          </div>
          
          <button class="btn btn-primary btn-block shadow-lg mt-1">Log in</button>
      </form>
      <a href="/"><center><small>Back to home</small></center></a>
        </div>
      </div>
        
    </div>

</body>

<script src="{{ asset('assets/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>

</html>