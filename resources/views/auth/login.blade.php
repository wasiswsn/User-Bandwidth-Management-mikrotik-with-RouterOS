<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Gmedia.net - Login</title>
        <link rel="shortcut icon" type="image/jpeg" href="{{ asset('template-dashboard') }}/assets/img/favicon.png">
        <link href="{{ asset('template-dashboard') }}/css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-dark bg-gradient">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main> 
                    <div class="container mb-4">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-4">

                                 <!--  Alert Session -->

                                     @if(Session::has('alert'))
                                          <script type="text/javascript">
                                            alert("Tidak Dapat Terhubung");
                                          </script>
                                        @endif

                                    <!--  Alert Session --> 

                                    <div class="card-header bg-info bg-gradient">
                                        <img src="{{ asset('template-dashboard') }}/assets/img/logo.png" class="mx-auto d-block" width="210px">
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('login') }}" method="POST" >
                                          @csrf
                                            <div class="form-floating mb-3"> 
                                                <input type="email" class="form-control" name="email" placeholder="Masukkan Email" required>
                                                <label class="form-label">Email</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="password" class="form-control" name="password" placeholder="Password ">
                                                <label for="exampleInputPassword1" class="form-label">Password</label>
                                                <div class="form-text">*Masukkan email dan password dengan benar</div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a href="/" class="btn btn-link btn-lg"><i class="fa-sharp fa-solid fa-arrow-left"></i></a>
                                                <button type="submit" class="btn btn-primary mb-2">Masuk</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
          @include('layout.footer')
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('template-dashboard') }}/js/scripts.js"></script>
    </body>
</html>