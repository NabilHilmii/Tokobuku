<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Login</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
                <div>

                    <h1 class="logo-name">MI</h1>

                </div>
                <h3>Welcome to MI Book Store</h3>
                <p>Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.
                </p>
                <p>Login in. To see it in action.</p>
                <form class="m-t" action="aksi_register.php" role="form" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="col-lg-15 control-label">Upload Image:</label>
                        <input type="file"  class="form-control" name="image" required onchange="previewImage(this);">
                    </div>
                    <div class="form-group">
                        <img id="preview" src="#" alt="Book Cover Preview" style="max-width: 100%; height: auto; display: none;">
                    </div>
                    <div class="text-center">
                        <label class="col-sm-15 control-label">Username</label>
                    </div>
                    <div class="form-group">
                        <input type="text" placeholder="Username" class="form-control" name="username">
                    </div>
                    <div class="text-center">
                        <label class="col-sm-15 control-label">Email</label>
                    </div>
                    <div class="form-group">
                        <input type="email" placeholder="Email" class="form-control" name="email">
                    </div>
                    <div class="text-center">
                        <label class="col-sm-15 control-label">Password</label>
                    </div>
                    <div class="form-group">
                        <input type="password" placeholder="Password" class="form-control" name="password">
                    </div>
                    <div class="text-left">
                        Have An Account ? <a href="login.php">Login</a> <!-- Link to login.php -->
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary block full-width m-b">
                            Register
                        </button>
                    </div>
                </form>
                <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>
            </div>



        </div>


    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                    document.getElementById('preview').style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

</body>

</html>
