<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register</title>
</head>
<body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>

    <div class="container mt-5">
        <div id="error" class="alert alert-danger"></div>

        <div class="card">
            <div class="card-header">
                <div class="card-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input id="name" class="form-control" type="text" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input id="password" type="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input id="password_confirmation" type="password" class="form-control" placeholder="Confirm Password">
                    </div>

                    <button id="btn-submit" class="btn btn-primary" onClick="submitForm()"> Join Now </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        var alert = document.getElementById("error");
        alert.style.display = "none";

        function submitForm(){
            var name = document.getElementById("name");
            var password = document.getElementById("password");
            var password_confirmation = document.getElementById("password_confirmation");
            var button = document.getElementById("btn-submit");
            var data = { 
                name: name.value,
                password: password.value,
                password_confirmation: password_confirmation.value
            };
            var arr = window.location.pathname.split("/");

            name.disabled = true;
            password.disabled = true;
            password_confirmation.disabled = true;
            button.disabled = true;

            axios.post("/register/" + arr[2], data)
            .then(function(res){
                alert.style.display = "block";
                alert.classList.remove("alert-danger");
                alert.classList.add("alert-success");

                alert.innerHTML = "Success! Please wait while we redirect the page... ";

                window.location = "/register/success"
            }).catch(function(err){
                var status = err.response.status;
                var message = err.response.data.status;

                name.disabled = false;
                password.disabled = false;
                password_confirmation.disabled = false;
                button.disabled = false;
                
                alert.style.display = "block";
                alert.innerHTML = message;
            });
        }
    </script>
</body>
</html>