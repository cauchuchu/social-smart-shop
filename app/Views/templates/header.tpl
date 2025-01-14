<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="..\assets\img\logo-fav.png">
  <title>Socbay</title>
  <link rel="stylesheet" type="text/css" href="..\assets\lib\perfect-scrollbar\css\perfect-scrollbar.css">
  <link rel="stylesheet" type="text/css"
    href="..\assets\lib\material-design-icons\css\material-design-iconic-font.min.css">
  <link rel="stylesheet" type="text/css" href="..\assets\lib\jquery.vectormap\jquery-jvectormap-1.2.2.css">
  <link rel="stylesheet" type="text/css" href="..\assets\lib\jqvmap\jqvmap.min.css">
  <link rel="stylesheet" type="text/css" href="..\assets\lib\datetimepicker\css\bootstrap-datetimepicker.min.css">
  <link rel="stylesheet" href="..\assets\css\app.css" type="text/css">
  <link rel="stylesheet" href="..\assets\css\base.css" type="text/css">
  <link rel="stylesheet" href="..\assets\css\notify.css" type="text/css">
  <script src="..\assets\lib\jquery\jquery.min.js" type="text/javascript"></script>
  <link rel="stylesheet" type="text/css" href="..\assets\lib\select2\css\select2.min.css">
  {* <link rel="stylesheet" type="text/css" href="..\assets\lib\bootstrap-slider\css\bootstrap-slider.min.css">
   *}
</head>

<body>
  <div class="be-wrapper be-fixed-sidebar">
    <nav class="navbar navbar-expand fixed-top be-top-header">
      <div class="container-fluid">
        <div class="be-navbar-header"><a class="navbar-brands" href=""><img style="width:100%;" src="../assets/img/sb-logo-04.png"></a>
        </div>
        <div class="page-title"><span>Dashboard</span></div>
        <div class="be-right-navbar">
          <ul class="nav navbar-nav float-right be-user-nav">
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                role="button" aria-expanded="false"><img src="assets\img\avatar.png" alt="Avatar"><span
                  class="user-name">Túpac Amaru</span></a>
              <div class="dropdown-menu" role="menu">
                <div class="user-info">
                  <div class="user-name">Túpac Amaru</div>
                  <div class="user-position online">Available</div>
                </div><a class="dropdown-item" href="pages-profile.html"><span
                    class="icon mdi mdi-face"></span>Account</a><a class="dropdown-item" href="#"><span
                    class="icon mdi mdi-settings"></span>Settings</a><a class="dropdown-item"
                  href="pages-login.html"><span class="icon mdi mdi-power"></span>Logout</a>
              </div>
            </li>
          </ul>
          <ul class="nav navbar-nav float-right be-icons-nav">
            <li class="nav-item dropdown"><a class="nav-link be-toggle-right-sidebar" href="#" role="button"
                aria-expanded="false"><span class="icon mdi mdi-settings"></span></a></li>
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                role="button" aria-expanded="false"><span class="icon mdi mdi-notifications"></span><span
                  class="indicator"></span></a>
              <ul class="dropdown-menu be-notifications">
                <li>
                  <div class="title">Notifications<span class="badge badge-pill">3</span></div>
                  <div class="list">
                    <div class="be-scroller-notifications">
                      <div class="content">
                        <ul>
                          <li class="notification notification-unread"><a href="#">
                              <div class="image"><img src="assets\img\avatar2.png" alt="Avatar"></div>
                              <div class="notification-info">
                                <div class="text"><span class="user-name">Jessica Caruso</span> accepted your invitation
                                  to join the team.</div><span class="date">2 min ago</span>
                              </div>
                            </a></li>
                          <li class="notification"><a href="#">
                              <div class="image"><img src="assets\img\avatar3.png" alt="Avatar"></div>
                              <div class="notification-info">
                                <div class="text"><span class="user-name">Joel King</span> is now following you</div>
                                <span class="date">2 days ago</span>
                              </div>
                            </a></li>
                          <li class="notification"><a href="#">
                              <div class="image"><img src="assets\img\avatar4.png" alt="Avatar"></div>
                              <div class="notification-info">
                                <div class="text"><span class="user-name">John Doe</span> is watching your main
                                  repository</div><span class="date">2 days ago</span>
                              </div>
                            </a></li>
                          <li class="notification"><a href="#">
                              <div class="image"><img src="assets\img\avatar5.png" alt="Avatar"></div>
                              <div class="notification-info"><span class="text"><span class="user-name">Emily
                                    Carter</span> is now following you</span><span class="date">5 days ago</span></div>
                            </a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="footer"> <a href="#">View all notifications</a></div>
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"
                role="button" aria-expanded="false"><span class="icon mdi mdi-apps"></span></a>
              <ul class="dropdown-menu be-connections">
                <li>
                  <div class="list">
                    <div class="content">
                      <div class="row">
                        <div class="col"><a class="connection-item" href="#"><img src="assets\img\github.png"
                              alt="Github"><span>GitHub</span></a></div>
                        <div class="col"><a class="connection-item" href="#"><img src="assets\img\bitbucket.png"
                              alt="Bitbucket"><span>Bitbucket</span></a></div>
                        <div class="col"><a class="connection-item" href="#"><img src="assets\img\slack.png"
                              alt="Slack"><span>Slack</span></a></div>
                      </div>
                      <div class="row">
                        <div class="col"><a class="connection-item" href="#"><img src="assets\img\dribbble.png"
                              alt="Dribbble"><span>Dribbble</span></a></div>
                        <div class="col"><a class="connection-item" href="#"><img src="assets\img\mail_chimp.png"
                              alt="Mail Chimp"><span>Mail Chimp</span></a></div>
                        <div class="col"><a class="connection-item" href="#"><img src="assets\img\dropbox.png"
                              alt="Dropbox"><span>Dropbox</span></a></div>
                      </div>
                    </div>
                  </div>
                  <div class="footer"> <a href="#">More</a></div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Hiển thị flashdata nếu có -->

<div class="be-content">