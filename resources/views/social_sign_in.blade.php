<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Social Sign In</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
</head>

<body>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2 col-sm-12 mt-5">
                    <h1>
                        Stock Report Demo App
                    </h1>
                    <small>Please sign in using below link and move ahead!</small>
                    <br>
                    <fb:login-button scope="public_profile,email" onlogin="checkLoginState();"> </fb:login-button>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
</body>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>

<script>
    // window.fbAsyncInit = function() {
    //     FB.init({
    //         appId: '{your-app-id}',
    //         cookie: true,
    //         xfbml: true,
    //         version: '{api-version}'
    //     });

    //     FB.AppEvents.logPageView();

    // };

    // (function(d, s, id) {
    //     var js, fjs = d.getElementsByTagName(s)[0];
    //     if (d.getElementById(id)) {
    //         return;
    //     }
    //     js = d.createElement(s);
    //     js.id = id;
    //     js.src = "https://connect.facebook.net/en_US/sdk.js";
    //     fjs.parentNode.insertBefore(js, fjs);
    // }(document, 'script', 'facebook-jssdk'));

    // FB.getLoginStatus(function(response) {
    //     statusChangeCallback(response);
    // });
</script>

<script>
    function statusChangeCallback(response) { // Called with the results from FB.getLoginStatus().
        // console.log('statusChangeCallback');
        // console.log(JSON.stringify(response)); // The current login status of the person.
        var res = response;
        // alert( res.authResponse.accessToken);
        // console.log(res["accessToken"]);
        if (response.status === 'connected') { // Logged into your webpage and Facebook.
            moveToLogin( res.authResponse.accessToken, res.authResponse.userID);
        } else { // Not logged into your webpage or we are unable to tell.
            document.getElementById('status').innerHTML = 'Please log ' +
                'into this webpage.';
        }
    }


    function checkLoginState() { // Called when a person is finished with the Login Button.
        FB.getLoginStatus(function(response) { // See the onlogin handler
            statusChangeCallback(response);
        });
    }


    window.fbAsyncInit = function() {
        FB.init({
            appId: '1957701181107719',
            cookie: true, // Enable cookies to allow the server to access the session.
            xfbml: true, // Parse social plugins on this webpage.
            version: 'v14.0' // Use this Graph API version for this call.
        });


        FB.getLoginStatus(function(response) { // Called after the JS SDK has been initialized.
            statusChangeCallback(response); // Returns the login status.
        });
    };

    function moveToLogin(accessToken, userID) {
        window.location = '/handle-social-sign-in?accessToken=' + accessToken + '&id=' + userID;
    }
</script>

</html>
