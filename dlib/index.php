<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Library</title>
    <link rel="stylesheet" href="css/1style.css">
</head>
<body>

    <!-- Splash Screen -->
    <div id="splash">
        <h1 id="splash-text"></h1>
    </div>

    <!-- Main Welcome Section -->
    <div id="welcome" class="hidden">
        <div class="container">
            <div class="welcome-text">
                <h2>Welcome to</h2>
                <h1>Digital Library</h1>
            </div>
            <div class="buttons">
               <a href="loginnout/login.php" class="btn">Login</a>
               <a href="loginnout/register.php" class="btn">Register</a>

            </div>
        </div>
    </div>

    <script>
        const splashText = "DIGITAL LIBRARY";
        const splashElement = document.getElementById("splash-text");
        let index = 0;

        function typeEffect() {
            if (index < splashText.length) {
                splashElement.innerHTML += splashText.charAt(index);
                index++;
                setTimeout(typeEffect, 150);
            } else {
                setTimeout(() => {
                    document.getElementById('splash').style.opacity = '0';
                    setTimeout(() => {
                        document.getElementById('splash').style.display = 'none';
                        document.getElementById('welcome').classList.remove('hidden');
                    }, 800);
                }, 1500);
            }
        }

        typeEffect();
    </script>

</body>
</html>
