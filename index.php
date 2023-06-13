<!DOCTYPE html>
<html>
  <head>
    <title>jQuery Form Example</title>
    <link
      rel="stylesheet"
      href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css"
          />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
</head>
  <body>
    <div class="col-sm-6 col-sm-offset-3">
      <h1>Processing an AJAX Form</h1>
        <div id="success" class="alert alert-success" style="display:none">
            Success! New user just added.
        </div>
        <div id="reject" class="alert alert-danger" style="display:none">

        </div>
      <form action="process.php" method="POST">
        <div id="name-form" class="form-group">
          <label for="name">Name</label>
          <input
                type="text"
                class="form-control"
                id="name"
                name="name"
                placeholder="Full Name"
                required
                />
        </div>

        <div id="lastName-form" class="form-group">
          <label for="lastName">LastName</label>
          <input
                type="text"
                class="form-control"
                id="lastName"
                name="LastName"
                placeholder="Last Name"
                required
                />
        </div>

          <div id="email-form" class="form-group">
              <label for="email">Email</label>
              <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    placeholder="email@example.com"
                    required
              />
          </div>

          <div id="password-form" class="form-group">
              <label for="password">Password</label>
              <input
                    type="password"
                    class="form-control"
                    id="password"
                    name="password"
                    placeholder="Password"
                    required
              />
          </div>
          <div id="password-confirm-form" class="form-group">
              <label for="passwordConfirm">Password-confirm</label>
              <input
                    type="password"
                    class="form-control"
                    id="passwordConfirm"
                    name="password-confirm"
                    placeholder="Password-confirm"
                    required
              />
              <span id='message'></span>
          </div>

        <button type="submit" class="btn btn-success">Submit</button>
      </form>
    </div>

  <script>
      var confirmPassword = false;
      var base = [];
      $(document).ready(function () {
          $("form").submit(function (event) {
              event.preventDefault();
              if(confirmPassword) {
                  var formData = {
                      name: $("#name").val(),
                      lastName: $("#lastName").val(),
                      email: $("#email").val(),
                      password: $("#password").val(),
                      passwordConfirm: $("#passwordConfirm").val(),
                      newBase: typeof(base) != "undefined" && base !== null ? base : '',
                  };

                  $.ajax({
                      type: "POST",
                      url: "process.php",
                      data: formData,
                      dataType: "json",
                      encode: true,
                  }).done(function (data) {
                      if(data['newBase']){
                          base = data['newBase'];
                      }

                      if(data['success']){
                          $('#success').show();
                      }else{
                          $('#reject').html('Danger! ' + JSON.stringify(data['errors']));
                          $('#reject').show();
                      }
                  });
              }
          });
      });

      $('#password, #passwordConfirm').on('keyup', function () {
          if ($('#password').val() == $('#passwordConfirm').val()) {
              confirmPassword = true;
              $('#message').html('Matching').css('color', 'green');
          } else {
              confirmPassword = false;
              $('#message').html('Not Matching').css('color', 'red');
          }
      });
  </script>
  </body>
</html>