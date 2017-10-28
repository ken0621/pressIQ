<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
      <meta name="mobile-web-app-capable" content="yes">
      <meta name="apple-mobile-web-app-capable" content="yes">
      <meta name="apple-mobile-web-app-status-bar-style" content="black">
      <meta name="theme-color" content="#2196f3">
      <title>DIGIMA</title>
      <link rel="stylesheet" href="/themes/payroll_employee/assets/mobile/framework7/dist/css/framework7.material.css">
      <link rel="stylesheet" href="/themes/payroll_employee/assets/mobile/framework7/dist/css/framework7.material.colors.css">
      <link href="http://fonts.googleapis.com/css?family=Roboto:400,300,500,700" rel="stylesheet" type="text/css">
      <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700" rel="stylesheet"> 
      <link rel="stylesheet" href="/themes/payroll_employee/assets/mobile/framework7/kitchen-sink-material/css/material-icons.css">
      <link rel="stylesheet" href="/themes/payroll_employee/assets/mobile/framework7/kitchen-sink-material/css/kitchen-sink.css">
      {{-- FONT AWESOME --}}
      <link rel="stylesheet" type="text/css" href="/themes/payroll_employee/assets/font-awesome/css/font-awesome.min.css">
      <!-- Brown Custom Icon -->
      <link rel="stylesheet" type="text/css" href="/themes/payroll_employee/assets/brown-icon/styles.css">
      <!-- GLOBAL CSS -->
      <link rel="stylesheet" type="text/css" href="/themes/payroll_employee/assets/mobile/css/global.css">

  <!-- Bootstrap core CSS-->
  <link href="assets/employee/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="assets/employee/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="assets/employee/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="assets/employee/css/sb-admin.css" rel="stylesheet">
  <link href="assets/employee/css/employee_profile.css" rel="stylesheet">

   </head>
   <body>
      <input type="hidden" class="mobile-mode">
      <input type="hidden" name="code" class="check_unused_code" value="  $check_unused_code or 0 }}">
      <input type="hidden" name="_token" class="_token" value="  csrf_token() }}">
      <input type="hidden" name="not_placed_yet" cla0ss="not_placed_yet" value="  $not_placed_yet or 0 }}" link="/members/enter-placement?slot_no=  Crypt::encrypt($not_placed_slot->slot_id) }}&key=  md5($not_placed_slot->slot_id . $not_placed_slot->slot_no) }}">
      <div class="statusbar-overlay"></div>
      <div class="panel-overlay"></div>
      
      <div class="panel panel-left panel-cover">
         <div class="view navbar-fixed">
            <div class="pages">
               <div data-page="panel-left" class="page">
                  <div class="navbar sidebar-left">
                     <div class="navbar-inner">
                        <div class="title-holder">
                           <div class="title"> {{ $page }}</div>
                           <div class="sub">-</div>
                        </div>
                        <div class="right">
                           <div class="dot"></div>
                        </div>
                     </div>
                  </div>
                  <div class="page-content sidebar-left">
                     <div class="image-profile">
                        <img style="border-radius: 100%;" src="">
                     </div>
                     <div class="list-block">
                        <ul>
                           <li>
                              <a href="/employee" class="item-link close-panel">
                                 <div class="item-content">
                                    <div class="item-media"><i class="icon brown-icon-dashboard"></i></div>
                                    <div class="item-inner">
                                       <div class="item-title">Dashboard</div>
                                    </div>
                                 </div>
                              </a>
                           </li>
                            <!-- if($mlm_member) -->
                           <li> 
                              <a href="/employee_profile" class="item-link close-panel">
                                 <div class="item-content">
                                    <div class="item-media"><i class="icon brown-icon-profile"></i></div>
                                    <div class="item-inner">
                                       <div class="item-title">Profile</div>
                                    </div>
                                 </div>
                              </a>
                           </li>
                           <li>
                              <a href="/employee_time_keeping" class="item-link close-panel">
                                 <div class="item-content">
                                    <div class="item-media"><i class="icon brown-icon-flow-tree"></i></div>
                                    <div class="item-inner">
                                       <div class="item-title">Time Keeping</div>
                                    </div>
                                 </div>
                              </a>
                           </li>
                           <li>
                              <a href="/company_details" class="item-link close-panel">
                                 <div class="item-content">
                                    <div class="item-media"><i class="icon brown-icon-bar-chart"></i></div>
                                    <div class="item-inner">
                                       <div class="item-title">Company Details</div>
                                    </div>
                                 </div>
                              </a>
                           </li>
                           <li>
                              <a href="/employee_leave_management" class="item-link close-panel">
                                 <div class="item-content">
                                    <div class="item-media"><i class="icon brown-icon-flow-tree"></i></div>
                                    <div class="item-inner">
                                       <div class="item-title">Leave Management</div>
                                    </div>
                                 </div>
                              </a>
                           </li>
                           <li>
                              <a href="/employee_overtime_management" class="item-link close-panel">
                                 <div class="item-content">
                                    <div class="item-media"><i class="icon brown-icon-wallet"></i></div>
                                    <div class="item-inner">
                                       <div class="item-title">Overtime Management</div>
                                    </div>
                                 </div>
                              </a>
                           </li>
                           <li>
                              <a href="/employee_official_business_management" class="item-link close-panel">
                                 <div class="item-content">
                                    <div class="item-media"><i class="icon brown-icon-wallet"></i></div>
                                    <div class="item-inner">
                                       <div class="item-title">OB Management</div>
                                    </div>
                                 </div>
                              </a>
                           </li>
                           <li>
                              <a href="#" class="item-link close-panel">
                                 <div class="item-content">
                                    <div class="item-media"><i class="icon brown-icon-wallet"></i></div>
                                    <div class="item-inner">
                                       <div class="item-title">RFP</div>
                                    </div>
                                 </div>
                              </a>
                           </li>
                           <li>
                              <a href="/employee_official_business_management" class="item-link close-panel">
                                 <div class="item-content">
                                    <div class="item-media"><i class="icon brown-icon-wallet"></i></div>
                                    <div class="item-inner">
                                       <div class="item-title">Authorized Access</div>
                                    </div>
                                 </div>
                              </a>
                           </li>
                           <li>
                              <a href="javascript:" onClick="location.href='/members/logout'" class="item-link close-panel">
                                 <div class="item-content">
                                    <div class="item-media"></div>
                                    <div class="item-inner">
                                       <div class="item-title">Logout</div>
                                    </div>
                                 </div>
                              </a>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="views">
         <div class="view view-main">
            <div class="pages navbar-fixed">
               <div data-page="index" class="page">
                  <div class="navbar">
                     <div class="navbar-inner">
                        <div class="left"><a href="#" class="open-panel link icon-only"><i class="icon icon-bars"></i></a></div>
                        <div class="left">Dashboard</div>
                        
                         {{-- <div class="right">
                           <div class="text">3</div>
                           <img src="/themes/payroll_employee/assets/mobile/img/notification.png">
                        </div> --}}
                     </div>
                  </div>
                  <div class="page-content">
                     <div class="dashboard-view">
                           <div class="profile-holder">
                              <table>
                                 <tr>
                                    <td class="img">
                                       <img src="  $profile_image }}">
                                    </td>
                                    <td class="text">
                                       <div class="name">$customer->first_name }}   $customer->last_name }}</div>
                                       <div class="sub">Member</div>
                                    </td>
                                 </tr>
                              </table>
                           </div>
                           <div class="summary-holder">
                              <div class="title"><i class="align-icon brown-icon-bar-chart"></i> Wallet Summary</div>
                              <div class="body">
                                 <div class="chart-legend">
                                    <div class="row">
                                       <!-- Each "cell" has col-[widht in percents] class -->
                                       <div class="col-50">
                                          <div class="holder">
                                             <div class="color-name"><div class="color" style="background-color: #76b6ec"></div><span>Current Wallet</span></div>
                                             <div class="name"> $wallet->display_current_wallet }}</div>
                                          </div>
                                       </div>
                                       <div class="col-50">
                                          <div class="holder">
                                             <div class="color-name"><div class="color" style="background-color: #8E5EA2"></div><span>Total Pay-out</span></div>
                                             <div class="name"> $wallet->display_total_payout }}</div>
                                          </div>
                                       </div>
                                    </div>
                                    
                                    
                                    <!--<div class="chart-holder">-->
                                    <!--   <canvas id="income_summary" class="chart-income" wallet="  $wallet->current_wallet }}"  payout="  $wallet->total_payout }}" style="max-width: 150px;" width="150" height="150"></canvas>-->
                                    <!--</div>-->
                                    <div class="row">
                                       <!-- Each "cell" has col-[widht in percents] class -->
                                       <div class="col-50">
                                          <div class="holder">
                                             <div class="color-name"><div class="color"></div><span>Current Slot(s)</span></div>
                                             <div class="name"> $customer_summary["display_slot_count"] }}</div>
                                          </div>
                                       </div>
                                       <div class="col-50">
                                          <div class="holder">
                                             <div class="color-name"><div class="color"></div><span>Total Reward</span></div>
                                             <div class="name">$wallet->display_total_earnings }}</div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="summary-holder">
                              <div class="title"><i class="fa fa-table"></i> Reward Summary</div>
                              <div class="body">
                                 <div class="chart-legend">
                                    <div class="row" style="text-align: center;">
                                       <div class="col-100">
                                          <div class="holder" style="text-align: center; display: inline-block;">
                                             <div class="color-name"><div class="color"></div><span>Pairing Reward</span></span></div>
                                             <div class="name"> $wallet->display_complan_triangle }}</div>
                                          </div>
                                       </div>
                                       <div class="col-100">
                                          <div class="holder" style="text-align: center; display: inline-block;">
                                             <div class="color-name"><div class="color"></div><span>Direct Referral Bonus</span></div>
                                             <div class="name"> $wallet->display_complan_direct }}</div>
                                          </div>
                                       </div>
                                       <div class="col-50">
                                          <div class="holder">
                                             <div class="color-name"><div class="color"></div><span>Builder Reward</span></div>
                                             <div class="name"> $wallet->display_complan_builder }}</div>
                                          </div>
                                       </div>
                                       <div class="col-50">
                                          <div class="holder">
                                             <div class="color-name"><div class="color"></div><span>Leader Reward</span></div>
                                             <div class="name"> $wallet->display_complan_leader }}</div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="summary-holder">
                              <div class="title"><i class="align-icon brown-icon-bar-chart"></i> Reward Points</div>
                              <div class="body">
                                 <div class="chart-legend">
                                    <div class="row">
                                       <div class="col-50">
                                          <div class="holder">
                                             <div class="color-name"><div class="color"></div><span>Builder Point(s)</span></div>
                                             <div class="name">  $points->display_brown_builder_points }}</div>
                                          </div>
                                       </div>
                                       <div class="col-50">
                                          <div class="holder">
                                             <div class="color-name"><div class="color"></div><span>Leader Point(s)</span></div>
                                             <div class="name">  $points->display_brown_leader_points }}</div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="summary-holder">
                              <div class="title"><i class="align-icon brown-icon-star"></i> My Slot(s)</div>
                              <div class="body">
                                 <div class="unilevel-holder">
                                     foreach($_slot as $slot)
                                    <div class="holder">
                                       <div class="row">
                                          <div class="col-40 text-center">
                                             <div class="label2">  $slot->slot_no }}</div>
                                             <div class="label3">  $slot->display_total_earnings }}</div>
                                             <div class="label3">  $slot->current_direct }} /   $slot->brown_next_rank_current }}</div>
                                          </div>
                                          <div class="col-60 text-center" style="margin-bottom: 5px;">ROAD TO <b>  $slot->brown_next_rank }}</b></div>
                                          <div class="col-40">
                                              if($slot->brown_next_rank != "NO NEXT RANK")
                                              if($slot->current_direct >= $slot->required_direct)
                                             <div class="progress2" style="background: linear-gradient(to right, rgb(220, 220, 220) 100%, rgb(237, 237, 237) 100%);">DIRECT <b>QUALIFIED</b></div>
                                              else
                                             <div class="progress2" style="background: linear-gradient(to right, rgb(220, 220, 220)   $slot->brown_direct_rank_percentage }}%, rgb(237, 237, 237)   $slot->brown_direct_rank_percentage }}%);">DIRECT (  $slot->current_direct }}/  $slot->required_direct }})</div>
                                              endif
                                              else
                                             <div class="progress2" style="background: linear-gradient(to right, rgb(220, 220, 220) 100%, rgb(237, 237, 237) 40%);">NO MORE <b> NEXT RANK</b></div>
                                              endif
                                          </div>
                                          <div class="col-60">
                                              if($slot->brown_next_rank != "NO NEXT RANK")
                                              if($slot->brown_next_rank_current >= $slot->brown_next_rank_requirements)
                                             <div class="progress2" style="background: linear-gradient(to right, rgb(220, 220, 220) 100%, rgb(237, 237, 237) 100%);">GROUP <b>QUALIFIED</b></div>
                                              else
                                             <div class="progress2" style="background: linear-gradient(to right, rgb(220, 220, 220)   $slot->brown_rank_rank_percentage }}%, rgb(237, 237, 237)   $slot->brown_rank_rank_percentage }}%);">GROUP (  $slot->brown_next_rank_current }}/  $slot->brown_next_rank_requirements }})</div>
                                              endif
                                              else
                                             <div class="progress2" style="background: linear-gradient(to right, rgb(220, 220, 220) 100%, rgb(237, 237, 237) 40%);">NO MORE <b> NEXT RANK</b></div>
                                              endif
                                          </div>
                                       </div>
                                    </div>
                                     endforeach
                                 </div>
                              </div>
                           </div>
                         endif
                     </div>
                  </div>
                  <!-- Code Popup -->
                  <!--<div class="popup popup-code">-->
                  <!--    <form method="post" class="submit-verify-sponsor">-->
                  <!--       <div class="code-holder">-->
                  <!--          <div class="modal-header">-->
                  <!--              <div class="modal-title"><i class="fa fa-star"></i> SPONSOR</div>-->
                  <!--          </div>-->
                  <!--          <div class="labels">Enter <b>Nickname of Sponsor</b> or <b>Slot Number</b></div>-->
                  <!--          <input required="required" class="input-verify-sponsor text-center" name="verify_sponsor" type="text" placeholder="">-->
                  <!--          <div class="output-container">-->
                  <!--          </div>-->
                  <!--          <div class="btn-container">-->
                  <!--              <button id="btn-verify" class="btn-verify btn-verify-sponsor"><i class="fa fa-check"></i> VERIFY SPONSOR</button>-->
                  <!--          </div>-->
                  <!--       </div>-->
                  <!--   </form>-->
                  <!--</div>-->
                  <!-- Verification Popup -->
                  <!--<div class="popup popup-verification">-->
                  <!--    <div class="verification-holder">-->
                  <!--       <div class="modal-header">-->
                  <!--           <div class="modal-title"><i class="fa fa-shield"></i> CODE VERIFICATION</div>-->
                  <!--       </div>-->
                  <!--       <div class="modal-body">-->
                  <!--           <div class="message message-return-code-verify"></div>-->
                  <!--           <form method="post" class="code-verification-form">-->
                  <!--               <div>-->
                  <!--                   <div class="labeld">Pin Code</div>-->
                  <!--                   <input class="input input-pin text-center" name="pin" type="text" value=" $mlm_pin or ''}}">-->
                  <!--               </div>-->
                  <!--               <div>-->
                  <!--                   <div class="labeld">Activation</div>-->
                  <!--                   <input class="input input-activation text-center" name="activation" type="text" value=" $mlm_activation or ''}}">-->
                  <!--               </div>-->
                  <!--               <div class="btn-container">-->
                  <!--                   <button id="btn-proceed-2" class="btn-proceed-2" type='submit'><i class="fa fa-angle-double-right"></i> Proceed</button>-->
                  <!--               </div>-->
                  <!--           </form>-->
                  <!--       </div>-->
                  <!--    </div>-->
                  <!--</div>-->
                  <!-- Final Verification Popup -->
                  <!--<div class="popup final-popup-verification">-->
                  <!--    <form method="post" class="submit-verify-sponsor">-->
                  <!--       <div class="verification-holder">-->
                  <!--          <div class="load-final-verification"></div>-->
                  <!--       </div>-->
                  <!--   </form>-->
                  <!--</div>-->
               </div>
            </div>
         </div>
      </div>
      <div class="popup demo-popup">
         <div class="view navbar-fixed">
            <div class="pages">
               <div class="page">
                  <div class="navbar">
                     <div class="navbar-inner">
                        <div class="center">Popup Title</div>
                        <div class="right"><a href="#" class="link close-popup">Done</a></div>
                     </div>
                  </div>
                  <div class="page-content">
                     <div class="content-block">
                        <p>Here comes popup. You can put here anything, even independent view with its own navigation. Also not, that by default popup looks a bit different on iPhone/iPod and iPad, on iPhone it is fullscreen.</p>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse faucibus mauris leo, eu bibendum neque congue non. Ut leo mauris, eleifend eu commodo a, egestas ac urna. Maecenas in lacus faucibus, viverra ipsum pulvinar, molestie arcu. Etiam lacinia venenatis dignissim. Suspendisse non nisl semper tellus malesuada suscipit eu et eros. Nulla eu enim quis quam elementum vulputate. Mauris ornare consequat nunc viverra pellentesque. Aenean semper eu massa sit amet aliquam. Integer et neque sed libero mollis elementum at vitae ligula. Vestibulum pharetra sed libero sed porttitor. Suspendisse a faucibus lectus.</p>
                        <p>Duis ut mauris sollicitudin, venenatis nisi sed, luctus ligula. Phasellus blandit nisl ut lorem semper pharetra. Nullam tortor nibh, suscipit in consequat vel, feugiat sed quam. Nam risus libero, auctor vel tristique ac, malesuada ut ante. Sed molestie, est in eleifend sagittis, leo tortor ullamcorper erat, at vulputate eros sapien nec libero. Mauris dapibus laoreet nibh quis bibendum. Fusce dolor sem, suscipit in iaculis id, pharetra at urna. Pellentesque tempor congue massa quis faucibus. Vestibulum nunc eros, convallis blandit dui sit amet, gravida adipiscing libero.</p>
                        <p>Morbi posuere ipsum nisl, accumsan tincidunt nibh lobortis sit amet. Proin felis lorem, dictum vel nulla quis, lobortis dignissim nunc. Pellentesque dapibus urna ut imperdiet mattis. Proin purus diam, accumsan ut mollis ac, vulputate nec metus. Etiam at risus neque. Fusce tincidunt, risus in faucibus lobortis, diam mi blandit nunc, quis molestie dolor tellus ac enim. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse interdum turpis a velit vestibulum pharetra. Vivamus blandit dapibus cursus. Aenean lorem augue, vehicula in eleifend ut, imperdiet quis felis.</p>
                        <p>Duis non erat vel lacus consectetur ultricies. Sed non velit dolor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin vel varius mi, a tristique ante. Vivamus eget nibh ac elit tempor bibendum sit amet vitae velit. Proin sit amet dapibus nunc, non porta tellus. Fusce interdum vulputate imperdiet. Sed faucibus metus at pharetra fringilla. Fusce mattis orci et massa congue, eget dapibus ante rhoncus. Morbi semper sed tellus vel dignissim. Cras vestibulum, sapien in suscipit tincidunt, lectus mi sodales purus, at egestas ligula dui vel erat. Etiam cursus neque eu lectus eleifend accumsan vitae non leo. Aliquam scelerisque nisl sed lacus suscipit, ac consectetur sapien volutpat. Etiam nulla diam, accumsan ut enim vel, hendrerit venenatis sem. Vestibulum convallis justo vitae pharetra consequat. Mauris sollicitudin ac quam non congue.</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="popover popover-menu">
         <div class="popover-inner">
            <div class="list-block">
               <ul>
                  <li><a href="modals.html" class="list-button item-link">Modals</a></li>
                  <li><a href="popover.html" class="list-button item-link">Popover</a></li>
                  <li><a href="tabs.html" class="list-button item-link">Tabs</a></li>
                  <li><a href="panels.html" class="list-button item-link">Side Panels</a></li>
                  <li><a href="list-view.html" class="list-button item-link">List View</a></li>
                  <li><a href="forms.html" class="list-button item-link">Forms</a></li>
               </ul>
            </div>
         </div>
      </div>
      <div class="popover popover-music">
         <div class="popover-inner">
            <div class="list-block media-list">
               <ul>
                  <li>
                     <a href="#" class="item-link item-content">
                        <div class="item-media"><img src="http://lorempixel.com/88/88/people/1" width="44"></div>
                        <div class="item-inner">
                           <div class="item-title-row">
                              <div class="item-title">Yellow Submarine</div>
                           </div>
                           <div class="item-subtitle">Beatles</div>
                        </div>
                     </a>
                  </li>
                  <li>
                     <a href="#" class="item-link item-content">
                        <div class="item-media"><img src="http://lorempixel.com/88/88/people/2" width="44"></div>
                        <div class="item-inner">
                           <div class="item-title-row">
                              <div class="item-title">Don't Stop Me Now</div>
                           </div>
                           <div class="item-subtitle">Queen</div>
                        </div>
                     </a>
                  </li>
                  <li>
                     <a href="#" class="item-link item-content">
                        <div class="item-media"><img src="http://lorempixel.com/88/88/people/3" width="44"></div>
                        <div class="item-inner">
                           <div class="item-title-row">
                              <div class="item-title">Billie Jean</div>
                           </div>
                           <div class="item-subtitle">Michael Jackson</div>
                        </div>
                     </a>
                  </li>
               </ul>
            </div>
         </div>
      </div>
      <div class="popover popover-contacts">
         <div class="popover-inner">
            <div class="list-block media-list">
               <ul>
                  <li class="item-content">
                     <div class="item-media"><img src="http://lorempixel.com/88/88/people/1" width="40"></div>
                     <div class="item-inner">
                        <div class="item-title-row">
                           <div class="item-title">Ali Connors</div>
                        </div>
                     </div>
                  </li>
                  <li class="item-content">
                     <div class="item-media"><img src="http://lorempixel.com/88/88/people/2" width="40"></div>
                     <div class="item-inner">
                        <div class="item-title-row">
                           <div class="item-title">Sandra Adams</div>
                        </div>
                     </div>
                  </li>
                  <li class="item-content">
                     <div class="item-media"><img src="http://lorempixel.com/88/88/people/3" width="40"></div>
                     <div class="item-inner">
                        <div class="item-title-row">
                           <div class="item-title">Trevor Hansen</div>
                        </div>
                     </div>
                  </li>
                  <li>
                     <a href="#" class="item-link item-content bg-purple color-white ripple-white">
                        <div class="item-media"><i class="icon material-icons">mode_edit</i></div>
                        <div class="item-inner">
                           <div class="item-title-row">
                              <div class="item-title">Add New</div>
                           </div>
                        </div>
                     </a>
                  </li>
               </ul>
            </div>
         </div>
      </div>
      <div class="login-screen">
         <div class="view">
            <div class="page">
               <div class="page-content login-screen-content">
                  <div class="login-screen-title">Framework7</div>
                  <form>
                     <div class="list-block inputs-list">
                        <ul>
                           <li class="item-content">
                              <div class="item-inner">
                                 <div class="item-title label">Username</div>
                                 <div class="item-input">
                                    <input type="text" name="username" placeholder="Your username">
                                 </div>
                              </div>
                           </li>
                           <li class="item-content">
                              <div class="item-inner">
                                 <div class="item-title label">Password</div>
                                 <div class="item-input">
                                    <input type="password" name="password" placeholder="Your password">
                                 </div>
                              </div>
                           </li>
                        </ul>
                     </div>
                     <div class="content-block"><a href="#" class="button button-big">Sign In</a></div>
                     <div class="content-block">
                        <div class="list-block-label">Some text about login information.<br>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
      <div class="picker-modal picker-modal-demo">
         <div class="toolbar">
            <div class="toolbar-inner">
               <div class="left"></div>
               <div class="right"><a href="#" class="link close-picker">Done</a></div>
            </div>
         </div>
         <div class="picker-modal-inner">
            <div class="content-block">Integer mollis nulla id nibh elementum finibus. Maecenas eget fermentum ipsum. Sed sagittis condimentum nisl at tempus. Duis lacus libero, laoreet vitae ligula a, aliquet eleifend sapien. Nullam sodales viverra sodales.</div>
         </div>
      </div>
      <!-- JQUERY -->
      <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
      <script type="text/javascript" src="/themes/payroll_employee/assets/mobile/framework7/dist/js/framework7.js"></script>
      <script type="text/javascript" src="/themes/payroll_employee/assets/mobile/framework7/kitchen-sink-material/js/kitchen-sink.js"></script>
       -- EXTERNAL JS --}}
      <script type="text/javascript" src='/assets/chartjs/Chart.bundle.min.js'></script>
      <!-- GLOBAL JS -->
      <script type="text/javascript" src="/themes/payroll_employee/assets/mobile/js/global.js"></script>
      <script type="text/javascript" src="/themes/payroll_employee/js/non_member.js?version=2.1"></script>
      <script type="text/javascript">
         var myApp = new Framework7();
         var $$ = Dom7;
      </script>
      <!-- BEGIN JIVOSITE CODE -->
      <script type='text/javascript'>
      (function(){ var widget_id = 'OcvyPjoHBr';var d=document;var w=window;function l(){ var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
      </script>
      <!-- END JIVOSITE CODE -->
   </body>
</html>