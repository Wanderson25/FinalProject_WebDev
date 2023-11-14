<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="./clean/common.css">
        <link rel="stylesheet" type="text/css" href="./clean/rainbow_text.css">
        <link rel="stylesheet" type="text/css" href="./clean/home_page.css">
    </head>
<body>
    <div class="content">
        <p id="rainbow-text" class="disable-select">Bocchi The MP3</p>
        
        <div class="the_portal" id="the_portal">
            <div class="white-box">
            <img src="Bocchi2.gif" class="portal_img" id="portal_img" alt="">
            <div class="login"></div>
            <div class="signup"></div>
            </div>
        </div>
        <div class="search_div">
            <input class="search" type="text" placeholder="bocchi za rokku" name="search">
            <div class="search-results-dropdown"></div>
        </div>
        <div class="footer">
            <button type="button" id="login_btn" onclick="toggleAnimation()"><span></span>Login</button>
            <button type="button" id="signup_btn" onclick="toggleAnimation()"><span></span>Create Account</button>
            <button type="button" id="ye" onclick="window.location.href='http:HomePaged.php?random'"><span></span>I feel bocchy</button>
        </div>
    </div>
</body>
<style>

</style>
<script src="./clean/search.js"></script>
<script>
initSearch();
</script>

<head>
    <title>Bocchi the MP3</title>
    
    
    <script type="text/javascript" src="./clean/rainbow_text.js"></script>
    <script type="text/javascript" src="./clean/home_page.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">
</head>
</html>
