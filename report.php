<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECOncern</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="reportstyles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="favicon.png">
</head>
<body>
    <header class="header-1">
        <div class="headerlogo">
            <img src="header-title.png" alt="Logo" class="logo">
        </div>
        <nav class="navbar">
            <div class="burger-menu" id="burger-menu">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
            
            <div class="navbar-buttons" id="navbar-buttons">
                <button>Home</button>
                <button>About</button>
                <button>Services</button>
                <button>Contact</button>
            </div>
        </nav>
    </header>  

    <div class="loading-screen" id="loader">
        <div class="loader">
          <span class="item"></span>
          <span class="item"></span>
          <span class="item"></span>
          <span class="item"></span>
        </div>
    </div>

    <div class="container">
        <form id="report-form">
            <input type="file" accept="image/*" capture="camera" name="image" id="image-upload">
            <div id="image-preview-container">
        <img id="image-preview" src="#" alt="Image Preview">
    </div>
                <div class ="input">
            <textarea name="report" id="report" rows="5" placeholder="Enter your detailed report"></textarea>
                </div>
            <select name="company" id="company">
                <option value="company1">DENR</option>
                <option value="company2">OWO</option>
                <option value="company3">QWQ</option>
            </select>
            <button type="submit">Submit</button>
        </form>
    </div>

    <footer>
    </footer>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a560976b07.js" crossorigin="anonymous"></script>
    <script>
        window.addEventListener('load', function(){
            setTimeout(function(){
                var loadingScreen = document.getElementById('loader');
                loadingScreen.classList.add('fade-out'); // Apply fade-out animation
                setTimeout(function() {
                    loadingScreen.classList.add('hidden'); // Hide the loading screen after animation
                }, 200);
            }, 2000);
        });

        document.getElementById("burger-menu").addEventListener("click", function() {
            this.classList.toggle("active"); // Toggle active class on burger menu icon
            document.querySelector(".navbar-buttons").classList.toggle("active"); // Toggle active class on navbar buttons
            document.querySelector(".container").classList.toggle("pushed-down"); // Toggle pushed-down class on container
        });
        
        document.getElementById('image-upload').addEventListener('change', function(event) {
    var file = event.target.files[0];
    var reader = new FileReader();
    
    reader.onload = function(e) {
        document.getElementById('image-preview').setAttribute('src', e.target.result);
        document.getElementById('image-preview-container').style.display = 'block'; // Show the image preview container
    }
    
    reader.readAsDataURL(file);
    });

    document.getElementById('camera-button').addEventListener('click', function() {
    document.getElementById('image-upload').click();
    });
    </script>
</body>
</html>
