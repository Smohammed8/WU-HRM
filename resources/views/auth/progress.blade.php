<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Progress</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .overlay {
            display: flex;
            align-items: center;
            justify-content: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8); /* semi-transparent white background */
            z-index: 1000;
        }

        .loading-spinner {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #0067b8;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    <script src="{{ asset('assets/js/jquery-3.2.1.slim.min.js.js') }}"></script>
    <script src="{{ asset('assets/js/axios.min.js.js') }}"></script>


</head>
<body>

<div class="overlay" id="overlay">
    <div class="loading-spinner"></div>
</div>

<script>
    function checkLoginProgress() {
        axios.get('/login')
            .then(function (response) {
                const progress = response.data.progress;
                updateProgressBar(progress);
                if (progress < 100) {
                    setTimeout(checkLoginProgress, 5000);
                } else {
                    window.location.href = '/dashboard';
                }
            })
            .catch(function (error) {
                console.error(error);
                // Handle the error and provide a user-friendly message
            });
    }

    function updateProgressBar(progress) {
        $('#overlay').css('display', 'flex'); // Show the overlay
        if (progress < 100) {
            $('#overlay').css('background', 'rgba(255, 255, 255, 0.8)'); // Semi-transparent white background
        } else {
            $('#overlay').css('background', 'rgba(255, 255, 255, 0)'); // Fully transparent background
        }
    }

    $(document).ready(function () {
        checkLoginProgress();
    });
</script>

</body>

</html>






