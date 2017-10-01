<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
      <meta name="mobile-web-app-capable" content="yes">
      <meta name="apple-mobile-web-app-capable" content="yes">
      <meta name="apple-mobile-web-app-status-bar-style" content="black">
      <meta name="theme-color" content="#2196f3">
      <title>Brown</title>
      <link rel="stylesheet" href="/themes/{{ $shop_theme }}/assets/mobile/framework7/dist/css/framework7.material.css">
      <link rel="stylesheet" href="/themes/{{ $shop_theme }}/assets/mobile/framework7/dist/css/framework7.material.colors.css">
      <link href="http://fonts.googleapis.com/css?family=Roboto:400,300,500,700" rel="stylesheet" type="text/css">
      <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700" rel="stylesheet"> 
      <link rel="stylesheet" href="/themes/{{ $shop_theme }}/assets/mobile/framework7/kitchen-sink-material/css/material-icons.css">
      <link rel="stylesheet" href="/themes/{{ $shop_theme }}/assets/mobile/framework7/kitchen-sink-material/css/kitchen-sink.css">
      {{-- FONT AWESOME --}}
      <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/font-awesome/css/font-awesome.min.css">
      <!-- Brown Custom Icon -->
      <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/brown-icon/styles.css">
      <!-- GLOBAL CSS -->
      <link rel="stylesheet" type="text/css" href="/themes/{{ $shop_theme }}/assets/mobile/css/global.css">
   </head>
   <body>
      <input type="hidden" name="code" class="check_unused_code" value="{{ $check_unused_code or 0 }}">
      <input type="hidden" name="_token" class="_token" value="{{ csrf_token() }}">
      <div class="statusbar-overlay"></div>
      <div class="panel-overlay"></div>
      <div class="panel panel-left panel-cover">
         <div class="view navbar-fixed">
            <div class="pages">
               <div data-page="panel-left" class="page">
                  <div class="navbar sidebar-left">
                     <div class="navbar-inner">
                        <div class="title-holder">
                           <div class="title">{{ $customer->first_name }} {{ $customer->last_name }}</div>
                           <div class="sub">Member</div>
                        </div>
                        <div class="right">
                           <div class="dot"></div>
                        </div>
                     </div>
                  </div>
                  <div class="page-content sidebar-left">
                     <div class="image-profile">
                        <img style="border-radius: 100%;" src="{{ $profile_image }}">
                     </div>
                     <div class="list-block">
                        <ul>
                           <li>
                              <a href="/members" class="item-link close-panel">
                                 <div class="item-content">
                                    <div class="item-media"><i class="icon brown-icon-dashboard"></i></div>
                                    <div class="item-inner">
                                       <div class="item-title">Dashboard</div>
                                    </div>
                                 </div>
                              </a>
                           </li>
                           @if($mlm_member)
                           <li>
                              <a href="/members/profile" class="item-link close-panel">
                                 <div class="item-content">
                                    <div class="item-media"><i class="icon brown-icon-profile"></i></div>
                                    <div class="item-inner">
                                       <div class="item-title">Profile</div>
                                    </div>
                                 </div>
                              </a>
                           </li>
                           {{-- <li>
                              <a href="forms.html" class="item-link close-panel">
                                 <div class="item-content">
                                    <div class="item-media"><i class="icon brown-icon-flow-tree"></i></div>
                                    <div class="item-inner">
                                       <div class="item-title">Genealogy</div>
                                    </div>
                                 </div>
                              </a>
                           </li> --}}
                           <li>
                              <a href="/members/report" class="item-link close-panel">
                                 <div class="item-content">
                                    <div class="item-media"><i class="icon brown-icon-bar-chart"></i></div>
                                    <div class="item-inner">
                                       <div class="item-title">Reports</div>
                                    </div>
                                 </div>
                              </a>
                           </li>
                           <li>
                              <a href="/members/network" class="item-link close-panel">
                                 <div class="item-content">
                                    <div class="item-media"><i class="icon brown-icon-flow-tree"></i></div>
                                    <div class="item-inner">
                                       <div class="item-title">Network List</div>
                                    </div>
                                 </div>
                              </a>
                           </li>
                           <li>
                              <a href="/members/wallet-encashment" class="item-link close-panel">
                                 <div class="item-content">
                                    <div class="item-media"><i class="icon brown-icon-wallet"></i></div>
                                    <div class="item-inner">
                                       <div class="item-title">Wallet</div>
                                    </div>
                                 </div>
                              </a>
                           </li>
                           @endif
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
      <div class="panel panel-right panel-reveal">
         <div class="view view-right">
            <div class="pages navbar-fixed">
               <div data-page="panel-right1" class="page">
                  <div class="navbar">
                     <div class="navbar-inner">
                        <div class="center">Right Panel</div>
                     </div>
                  </div>
                  <div class="page-content">
                     <div class="content-block">
                        <p>This is a right side panel. You can close it by clicking outsite or on this link:<a href="#" class="close-panel">close me</a>. You can put here anything, even another isolated view, try it:</p>
                     </div>
                     <div class="list-block">
                        <ul>
                           <li>
                              <a href="panel-right2.html" class="item-link">
                                 <div class="item-content">
                                    <div class="item-inner">
                                       <div class="item-title">Right panel page 2</div>
                                    </div>
                                 </div>
                              </a>
                           </li>
                           <li>
                              <a href="panel-right3.html" class="item-link">
                                 <div class="item-content">
                                    <div class="item-inner">
                                       <div class="item-title">Right panel page 3</div>
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
                           <img src="/themes/{{ $shop_theme }}/assets/mobile/img/notification.png">
                        </div> --}}
                     </div>
                  </div>
                  <div class="page-content">
                     <div class="dashboard-view">
                        @if(!$mlm_member)
                           <div class="non-member">
                              <div class="row">
                                 <div class="col-100">
                                    <video autoplay="" controls="">
                                       <source src="/themes/{{ $shop_theme }}/img/intro2.mp4" type="video/mp4">
                                    </video>
                                 </div>
                                 <div class="col-100">
                                    <div class="join-container">
                                       <div class="text">
                                          <div class="text-header1">Join the Movement!</div>
                                          <div class="text-header2">Enroll now and become one of us!</div>
                                       </div>
                                       <div class="btn-container">
                                          <button class="product-add-cart btn-buy-a-kit" type="button" onClick="location.href='/cartv2/buy_kit_mobile/{{ $item_kit_id }}'">Buy a Kit</button><br>
                                          <img src="/themes/{{ $shop_theme }}/img/or-1.png"><br>
                                          <a href="#" data-popup=".popup-code" class="open-popup" id="btn-enter-a-code"><button class="btn-enter-a-code">Enter a Code</button></a>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        @else
                           <div class="profile-holder">
                              <table>
                                 <tr>
                                    <td class="img">
                                       <img src="{{ $profile_image }}">
                                    </td>
                                    <td class="text">
                                       <div class="name">{{ $customer->first_name }} {{ $customer->last_name }}</div>
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
                                             <div class="name">{{ $wallet->display_current_wallet }}</div>
                                          </div>
                                       </div>
                                       <div class="col-50">
                                          <div class="holder">
                                             <div class="color-name"><div class="color" style="background-color: #8E5EA2"></div><span>Total Pay-out</span></div>
                                             <div class="name">{{ $wallet->display_total_payout }}</div>
                                          </div>
                                       </div>
                                    </div>
                                    
                                    
                                    <!--<div class="chart-holder">-->
                                    <!--   <canvas id="income_summary" class="chart-income" wallet="{{ $wallet->current_wallet }}"  payout="{{ $wallet->total_payout }}" style="max-width: 150px;" width="150" height="150"></canvas>-->
                                    <!--</div>-->
                                    <div class="row">
                                       <!-- Each "cell" has col-[widht in percents] class -->
                                       <div class="col-50">
                                          <div class="holder">
                                             <div class="color-name"><div class="color"></div><span>Current Slot(s)</span></div>
                                             <div class="name">{{ $customer_summary["display_slot_count"] }}</div>
                                          </div>
                                       </div>
                                       <div class="col-50">
                                          <div class="holder">
                                             <div class="color-name"><div class="color"></div><span>Total Reward</span></div>
                                             <div class="name">{{ $wallet->display_total_earnings }}</div>
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
                                             <div class="name">{{ $wallet->display_complan_triangle }}</div>
                                          </div>
                                       </div>
                                       <div class="col-100">
                                          <div class="holder" style="text-align: center; display: inline-block;">
                                             <div class="color-name"><div class="color"></div><span>Direct Referral Bonus</span></div>
                                             <div class="name">{{ $wallet->display_complan_direct }}</div>
                                          </div>
                                       </div>
                                       <div class="col-50">
                                          <div class="holder">
                                             <div class="color-name"><div class="color"></div><span>Builder Reward</span></div>
                                             <div class="name">{{ $wallet->display_complan_builder }}</div>
                                          </div>
                                       </div>
                                       <div class="col-50">
                                          <div class="holder">
                                             <div class="color-name"><div class="color"></div><span>Leader Reward</span></div>
                                             <div class="name">{{ $wallet->display_complan_leader }}</div>
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
                                             <div class="name">{{ $points->display_brown_builder_points }}</div>
                                          </div>
                                       </div>
                                       <div class="col-50">
                                          <div class="holder">
                                             <div class="color-name"><div class="color"></div><span>Leader Point(s)</span></div>
                                             <div class="name">{{ $points->display_brown_leader_points }}</div>
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
                                    @foreach($_slot as $slot)
                                    <div class="holder">
                                       <div class="row">
                                          <div class="col-40 text-center">
                                             <div class="label2">{{ $slot->slot_no }}</div>
                                             <div class="label3">{{ $slot->display_total_earnings }}</div>
                                             <div class="label3">{{ $slot->current_direct }} / {{ $slot->brown_next_rank_current }}</div>
                                          </div>
                                          <div class="col-60 text-center" style="margin-bottom: 5px;">ROAD TO <b>{{ $slot->brown_next_rank }}</b></div>
                                          <div class="col-40">
                                             @if($slot->brown_next_rank != "NO NEXT RANK")
                                             @if($slot->current_direct >= $slot->required_direct)
                                             <div class="progress2" style="background: linear-gradient(to right, rgb(220, 220, 220) 100%, rgb(237, 237, 237) 100%);">DIRECT <b>QUALIFIED</b></div>
                                             @else
                                             <div class="progress2" style="background: linear-gradient(to right, rgb(220, 220, 220) {{ $slot->brown_direct_rank_percentage }}%, rgb(237, 237, 237) {{ $slot->brown_direct_rank_percentage }}%);">DIRECT ({{ $slot->current_direct }}/{{ $slot->required_direct }})</div>
                                             @endif
                                             @else
                                             <div class="progress2" style="background: linear-gradient(to right, rgb(220, 220, 220) 100%, rgb(237, 237, 237) 40%);">NO MORE <b> NEXT RANK</b></div>
                                             @endif
                                          </div>
                                          <div class="col-60">
                                             @if($slot->brown_next_rank != "NO NEXT RANK")
                                             @if($slot->brown_next_rank_current >= $slot->brown_next_rank_requirements)
                                             <div class="progress2" style="background: linear-gradient(to right, rgb(220, 220, 220) 100%, rgb(237, 237, 237) 100%);">GROUP <b>QUALIFIED</b></div>
                                             @else
                                             <div class="progress2" style="background: linear-gradient(to right, rgb(220, 220, 220) {{ $slot->brown_rank_rank_percentage }}%, rgb(237, 237, 237) {{ $slot->brown_rank_rank_percentage }}%);">GROUP ({{ $slot->brown_next_rank_current }}/{{ $slot->brown_next_rank_requirements }})</div>
                                             @endif
                                             @else
                                             <div class="progress2" style="background: linear-gradient(to right, rgb(220, 220, 220) 100%, rgb(237, 237, 237) 40%);">NO MORE <b> NEXT RANK</b></div>
                                             @endif
                                          </div>
                                       </div>
                                    </div>
                                    @endforeach
                                 </div>
                              </div>
                           </div>
                        @endif
                     </div>
                  </div>
                  <!-- Notification Popup -->
                  <div class="popup popup-notification">
                      <div class="congrats-holder">
                         <div class="title">CONGRATULATIONS!</div>
                         <div class="img">
                             <img src="/themes/{{ $shop_theme }}/assets/mobile/img/trophy.png">
                         </div>
                         <div class="desc">You are one step away from your membership!</div>
                         <div class="btn-container">
                             <button id="btn-notification" href="#" data-popup=".popup-code" class="btn-verify-notification btn-notification open-popup" type="button">Continue</button>
                         </div>
                     </div>
                  </div>
                  <!-- Code Popup -->
                  <div class="popup popup-code">
                      <form method="post" class="submit-verify-sponsor">
                         <div class="code-holder">
                            <div class="modal-header">
                                <div class="modal-title"><i class="fa fa-star"></i> SPONSOR</div>
                            </div>
                            <div class="labels">Enter <b>Nickname of Sponsor</b> or <b>Slot Number</b></div>
                            <input required="required" class="input-verify-sponsor text-center" name="verify_sponsor" type="text" placeholder="">
                            <div class="output-container">
                            </div>
                            <div class="btn-container">
                                <button id="btn-verify" class="btn-verify btn-verify-sponsor"><i class="fa fa-check"></i> VERIFY SPONSOR</button>
                            </div>
                         </div>
                     </form>
                  </div>
                  <!-- Verification Popup -->
                  <div class="popup popup-verification">
                      <div class="verification-holder">
                         <div class="modal-header">
                             <div class="modal-title"><i class="fa fa-shield"></i> CODE VERIFICATION</div>
                         </div>
                         <div class="modal-body">
                             <div class="message message-return-code-verify"></div>
                             <form method="post" class="code-verification-form">
                                 <div>
                                     <div class="labeld">Pin Code</div>
                                     <input class="input input-pin text-center" name="pin" type="text" value="{{$mlm_pin or ''}}">
                                 </div>
                                 <div>
                                     <div class="labeld">Activation</div>
                                     <input class="input input-activation text-center" name="activation" type="text" value="{{$mlm_activation or ''}}">
                                 </div>
                                 <div class="btn-container">
                                     <button id="btn-proceed-2" class="btn-proceed-2" type='submit'><i class="fa fa-angle-double-right"></i> Proceed</button>
                                 </div>
                             </form>
                         </div>
                      </div>
                  </div>
                  <!-- Final Verification Popup -->
                  <div class="popup final-popup-verification">
                      <form method="post" class="submit-verify-sponsor">
                         <div class="verification-holder">
                            <div class="load-final-verification"></div>
                         </div>
                     </form>
                  </div>
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
      <script type="text/javascript" src="/themes/{{ $shop_theme }}/assets/mobile/framework7/dist/js/framework7.js"></script>
      <script type="text/javascript" src="/themes/{{ $shop_theme }}/assets/mobile/framework7/kitchen-sink-material/js/kitchen-sink.js"></script>
      {{-- EXTERNAL JS --}}
      <script type="text/javascript" src='/assets/chartjs/Chart.bundle.min.js'></script>
      <!-- GLOBAL JS -->
      <script type="text/javascript" src="/themes/{{ $shop_theme }}/assets/mobile/js/global.js"></script>
      <script type="text/javascript">
         var myApp = new Framework7();
 
         var $$ = Dom7;
      	add_event_submit_verify_sponsor();
      	add_event_submit_verify_code();
      	add_event_process_slot_creation();
          
         /*Auto pop-up*/
      	if($('.check_unused_code').val() != 0)
      	{
      		myApp.popup('.popup-notification');
      	}
      	function add_event_submit_verify_sponsor()
      	{
      		$(".submit-verify-sponsor").submit(function(e)
      		{
      			if($(e.currentTarget).find(".btn-verify-sponsor").hasClass("use"))
      			{
      				myApp.popup('.popup-verification');
      				setTimeout(function()
      				{
      				   myApp.popup('.popup-verification');
      				}, 350);
      				
      				if($('.input-pin').val() != '')
      				{
      					$$('.btn-proceed-2').click();	
      				}
      			}
      			else
      			{
      				action_verify_sponsor();
      			}
      			
      			return false;
      		});
      	}	
      	function action_verify_sponsor()
      	{
      		$(".submit-verify-sponsor").find(".btn-verify-sponsor").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> VERIFYING SPONSOR').attr("disabled", "disabled");
      		$(".submit-verify-sponsor").find("input").attr("disabled", "disabled");
      
      		var form_data = {};
      		form_data._token = $("._token").val();
      		form_data.verify_sponsor = $(".input-verify-sponsor").val();
      
      		$.ajax(
      		{
      			url:"/members/verify-sponsor",
      			data:form_data,
      			type:"post",
      			success: function(data)
      			{
      				$(".submit-verify-sponsor").find(".output-container").html(data);
      				$(".card").hide().slideDown('fast');
      
      				if($(".card").length > 0)
      				{
      					$(".submit-verify-sponsor").find(".btn-verify-sponsor").html('<i class="fa fa-check"></i> USE THIS SPONSOR').removeAttr("disabled").addClass("use");
      				}	
      				else
      				{
      					$(".submit-verify-sponsor").find("input").removeAttr("disabled");
      					$(".submit-verify-sponsor").find(".btn-verify-sponsor").html('<i class="fa fa-check"></i> VERIFY SPONSOR').removeAttr("disabled").removeClass("use");
      				}
      			},
      			error: function()
      			{
      				alert("An ERROR occurred. Please contact administrator.");
      				$(".submit-verify-sponsor").find("input").removeAttr("disabled");
      				$(".submit-verify-sponsor").find(".btn-verify-sponsor").html('<i class="fa fa-check"></i> VERIFY SPONSOR').removeAttr("disabled").removeClass("use");
      			}
      		});
      	}
      	function add_event_submit_verify_code()
      	{
      		$(".code-verification-form").submit(function()
      		{
      			action_verify_code();
      			return false;
      		});
      	}
      	function action_verify_code()
      	{
      		var form_data = {};
      		form_data._token = $("._token").val();
      		form_data.pin = $(".input-pin").val();
      		form_data.activation = $(".input-activation").val();
      
      		/* START LOADING AND DISABLE FORM */
      		$(".code-verification-form").find(".btn-proceed-2").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> VERIFYING').attr("disabled", "disabled");
      		$(".code-verification-form").find("select").attr("disabled", "disabled");
      
      		$.ajax(
      		{
      			url:"/members/verify-code",
      			data:form_data,
      			type:"post",
      			success: function(data)
      			{
      				$(".message-return-code-verify").html(data);
      				$(".code-verification-form").find(".btn-proceed-2").html('<i class="fa fa-angle-double-right"></i> PROCEED').removeAttr("disabled");
      
      				if(data == "")
      				{
      					$(".code-verification-form").find("input").val("");
      			// 		$("#proceed-modal-2").modal('hide');
      					setTimeout(function()
      					{
      				      myApp.popup('.final-popup-verification');
      						$(".final-popup-verification").find(".load-final-verification").html('<div class="loading text-center" style="padding: 150px;"><i class="fa fa-spinner fa-pulse fa-fw fa-3x"></i></div>');
      						$(".load-final-verification").load("/members/final-verify");
      					}, 350);
      				}
      			},
      			error: function(data)
      			{
      				alert("An ERROR occurred. Please contact administrator.");
      				$(".code-verification-form").find(".btn-proceed-2").html('<i class="fa fa-angle-double-right"></i> PROCEED').removeAttr("disabled");
      			}
      		});
      
      	}
      	function add_event_process_slot_creation()
      	{
      		$("body").on("click", ".process-slot-creation", function()
      		{
      			var form_data = {};
      			form_data._token = $("._token").val();
      
      			$(".process-slot-creation").html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Processing');
      
      			$.ajax(
      			{
      				url:"/members/final-verify",
      				dataType:"json",
      				type:"post",
      				data: form_data,
      				success: function(data)
      				{
      					if(data == "success")
      					{
      						// $("#proceed-modal-1").modal('hide');
      						window.location.reload();
      					}
      					else
      					{
      						alert(data);
      						window.location.reload();
      					}
      				}
      			});
      		});
      	}
      </script>
   </body>
</html>