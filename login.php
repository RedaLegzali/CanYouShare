<?php
session_start();
if ( $_SESSION['logged'] == true ) {
  $redirection = 'Location: http://' . $_SERVER['HTTP_HOST'] . '/';
  header($redirection);
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CanYouWeb - Login</title>
    <link rel="stylesheet" href="css/bulma.min.css" />
    <link rel="stylesheet" href="css/all.min.css" />
    <style>
      .hero {
        background-image: url(images/background.jpg);
        background-size: cover;
      }
      img {
        margin-left: 50%;
        margin-right: 50%;
      }
      .button,
      .dropdown {
        display: block !important;
        width: 100% !important;
      }
      .message-container {
        display: none;
      }

      .hide {
        opacity: 0;
        transition: opacity 1000ms;
      }
    </style>
  </head>
  <body>
    <section class="hero is-primary is-fullheight">
      <div class="hero-body">
        <div class="container">
          <div class="columns is-centered">
            <div class="column is-5-tablet is-4-desktop is-3-widescreen">
              <div class="box">
                <figure class="image is-128x128">
                  <img class="is-rounded" src="images/logo.png" />
                </figure>

                <div class="message-container field">
                  <article class="message">
                    <div class="message-body"></div>
                  </article>
                </div>

                <div class="field">
                  <div class="dropdown">
                    <div class="dropdown-trigger">
                      <button
                        class="button dropdown-btn"
                        aria-haspopup="true"
                        aria-controls="dropdown-menu"
                      >
                        <span class="group">Your Team</span>
                        <span class="icon is-small">
                          <i class="fas fa-angle-down" aria-hidden="true"></i>
                        </span>
                      </button>
                    </div>
                    <div class="dropdown-menu" id="dropdown-menu" role="menu">
                      <div class="dropdown-content">
                        <a class="dropdown-item"> Team - Reda </a>
                        <hr class="dropdown-divider" />
                        <a class="dropdown-item"> Team - Samy </a>
                        <hr class="dropdown-divider" />
                        <a class="dropdown-item"> Team - Hamza </a>
                        <hr class="dropdown-divider" />
                        <a class="dropdown-item"> Team - Oumaima </a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <div class="control has-icons-left">
                    <input
                      type="password"
                      placeholder="*******"
                      class="input"
                      required
                    />
                    <span class="icon is-small is-left">
                      <i class="fa fa-lock"></i>
                    </span>
                  </div>
                </div>
                <div class="field block">
                  <button class="button submit is-success">Login</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <script type="module" src="js/login.js"></script>
  </body>
</html>
