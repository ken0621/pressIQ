<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
      <meta name="apple-mobile-web-app-capable" content="yes">
      <meta name="apple-mobile-web-app-status-bar-style" content="black">
      <title>Digima Web Solutions, Inc.</title>
      <!-- Path to Framework7 Library CSS-->
      <link rel="stylesheet" href="/assets/mobile/framework7/dist/css/framework7.ios.min.css">
      <!-- Path to your custom app styles-->
      <link rel="stylesheet" href="/assets/super/css/super.css">
      <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
   </head>
   <body>
      <div class="statusbar-overlay"></div>
      <div class="panel-overlay"></div>
      <div class="panel panel-left panel-reveal sidebar">
         <div class="sidebar-title">NAVIGATION</div>
         <div class="sidebar-link-container content-block">
            <p class="sidebar-link"><a class="close-panel" href="javascript: mainView.router.back({pageName:'index',force:true});  myApp.closePanel();">Dashboard</a></p>
            <p class="sidebar-link"><a class="close-panel" href="/super/client">Manage Clients</a></p>
            <p class="sidebar-link"><a class="close-panel" href="/super/admin">Manage Super Admin</a></p>
            <p class="sidebar-link"><a class="close-panel" href="javascript:" onclick="window.location.href='/super/logout'">Logout</a></p>
         </div>
      </div>
      <div class="views">
         <div class="view view-main">
            <div class="navbar">
               <div data-page="index" class="navbar-inner">
                  <div class="left">
                     <a data-panel="right" href="#" class="link icon-only open-panel"><i class="icon icon-bars"></i></a>
                  </div>
                  <div class="center sliding">ADMIN PANEL</div>
               </div>
            </div>
            <div class="pages navbar-through toolbar-through">
               <div data-page="index" class="page">
                  <div class="page-content">
                     <!-- PAGE CONTENT START -->
                     <div class="content-block-title">Customer Graph</div>
                     <div class="card">
                        <div class="card-content">
                           <div class="card-content-inner">This is simple card with plain text. But card could contain its own header, footer, list view, image, and any elements inside.</div>
                        </div>
                     </div>
                     <!-- PAGE CONTENT END -->
                  </div>
               </div>
            </div>

            <div class="toolbar tabbar tabbar-labels">
                <div class="toolbar-inner">
                    <a href="#" class="tab-link">
                        <i class="icon nav-icon fa fa-home"></i>
                        <span class="tabbar-label">Dashboard</span>
                    </a>
                    <a href="#" class="tab-link">
                        <i class="icon nav-icon fa fa-envelope">
                           <span class="badge bg-red">5</span>
                        </i>
                        <span class="tabbar-label">Message</span>
                    </a>
                    <a href="#" class="tab-link">
                        <i class="icon nav-icon fa fa-list"></i>
                        <span class="tabbar-label">My Task</span>
                    </a>
                    <a href="#" class="tab-link">
                        <i class="icon nav-icon fa fa-gear"></i>
                        <span class="tabbar-label">My Account</span>
                    </a>
                </div>
            </div>
         </div>
      </div>
      <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
      <script type="text/javascript" src="/assets/mobile/framework7/dist/js/framework7.min.js"></script>
      <script type="text/javascript" src="/assets/admin/super.js?v=2.0"></script>
   </body>
</html>