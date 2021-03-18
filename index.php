<?php
session_start();
if ( $_SESSION['logged'] == false ) {
  $redirection = 'Location: http://' . $_SERVER['HTTP_HOST'] . '/login';
  header($redirection);
  exit;
}
$team = ucfirst($_SESSION['team']);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CanYouShare</title>
    <link rel="stylesheet" href="css/bulma.min.css" />
    <link rel="stylesheet" href="css/all.min.css" />
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <section class="section">
      <div class="container">
        <nav
          class="navbar is-white has-shadow"
          role="navigation"
          aria-label="main navigation"
        >
          <div class="navbar-brand">
            <a class="ynov" class="navbar-item" href="/">
              <img class="ynov" src="images/ynov.png" alt="logo" />
            </a>
            <div
              class="mr-5 ml-5"
              style="height: 80%; border-right: 1px solid #bbb"
            ></div>
            <a class="canyouweb" class="navbar-item" href="/">
              <img class="canyouweb" src="images/logo.png" alt="logo" />
            </a>
            <a
              role="button"
              class="navbar-burger"
              aria-label="menu"
              aria-expanded="false"
              data-target="navbarBasicExample"
            >
              <span aria-hidden="true"></span>
              <span aria-hidden="true"></span>
              <span aria-hidden="true"></span>
            </a>
          </div>
          <div class="navbar-menu">
            <div class="navbar-end">
              <div class="navbar-item">
                <input class="inputfile" type="file" />
                <button class="inputbtn button is-outlined is-primary mr-6">
                  Upload
                </button>
              </div>
              <div class="navbar-item">
                <div class="dropdown is-right">
                  <div class="dropdown-trigger">
                    <button class="dropdown-btn button is-outlined is-info" aria-haspopup="true" aria-controls="dropdown-menu">
                      <span>
                        Team <?php echo $team; ?> 
                      </span>
                      <span class="icon is-small">
                        <i class="fas fa-angle-down" aria-hidden="true"></i>
                      </span>
                    </button>
                  </div>
                  <div class="dropdown-menu" id="dropdown-menu" role="menu">
                    <div class="dropdown-content">
                      <a href="/logout" class="dropdown-item">
                        Logout
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </nav>
      </div>

      <div class="message-container container mt-6">
        <article class="message">
          <div class="message-body"></div>
        </article>
      </div>

      <div class="container mt-6">
        <h1 class="subtitle">Shared</h1>
        <div class="shared"></div>
      </div>
      <div class="container">
        <hr class="solid">
      </div>
      <div class="container mt-6">
        <h1 class="subtitle">Uploaded</h1>
        <div class="files"></div>
      </div>
    </section>
    <script type="module" src="js/app.js"></script>
  </body>
</html>
