<!-- Top Navbar-->
<div class="navbar">
   <div class="navbar-inner">
      <div class="left">
         <a href="#" class="back link">
            <i class="icon icon-back"></i>
            <span>Back</span>
         </a>
      </div>
      <div class="center sliding">Edit Customer</div>
      <div class="right">
         <a type="submit" href="javascript: $$('.button-for-register-1').click()" class="link">
           Update
         </a>
      </div>
   </div>
</div>
<div class="pages">
   <div data-page="customer-edit" class="page">
      <div class="page-content">

         <form action="/super/customer-edit" method="post" class="ajax-submit">
            {{ csrf_field() }}
            <div class="content-block-title">Customer Information</div>
            <div class="list-block">
               <ul>
                  <!-- Text inputs -->
                  <li>
                     <div class="item-content">
                        <div class="item-inner">
                           <div class="item-title label">Key</div>
                           <div class="item-input">
                              <input name="first_name" type="text" placeholder="Shop Key" value="{{ $shop->shop_key }}">
                           </div>
                        </div>
                     </div>
                  </li>
                  <!-- Text inputs -->
                  <li>
                     <div class="item-content">
                        <div class="item-inner">
                           <div class="item-title label">Contact</div>
                           <div class="item-input">
                              <input name="first_name" type="text" placeholder="Shop Key" value="{{ $shop->shop_contact }}">
                           </div>
                        </div>
                     </div>
                  </li>
                  <!-- Text inputs -->
                  <li>
                     <div class="item-content">
                        <div class="item-inner">
                           <div class="item-title label">Domain</div>
                           <div class="item-input">
                              <input name="first_name" type="text" placeholder="Customer Domain" value="{{ ($shop->shop_domain == "unset_yet" ? "" : $shop->shop_domain) }}">
                           </div>
                        </div>
                     </div>
                  </li>
               </ul>
            </div>


            @if($developer)
            <div class="content-block-title">Developer Access</div>
            <div class="list-block">
               <ul>
                  <!-- CREATE DATE -->
                  <li>
                     <div class="item-content">
                        <div class="item-inner">
                           <div class="item-title label">Username</div>
                           <div class="item-input">
                              <input readonly type="text" value="{{ $developer->user_email }}">
                           </div>
                        </div>
                     </div>
                  </li>

                  <!-- LAST UPDATE -->
                  <li>
                     <div class="item-content">
                        <div class="item-inner">
                           <div class="item-title label">Password</div>
                           <div class="item-input">
                              <input readonly type="text" value="{{ $user_password }}">
                           </div>
                        </div>
                     </div>
                  </li>
               </ul>
            </div>
            @endif

            <div class="content-block-title">Action List</div>
            <div class="list-block">
               <ul>
                  <li><a href="" class="item-link list-button">Archive</a></li>
                  <li><a href="/super/user?shop_id={{ $shop_id }}" class="item-link list-button">View Users ({{ $user_count }})</a></li>
                  <li><a href="" class="item-link list-button">Force Login</a></li>
               </ul>
            </div>

            <p style="text-align: right; display: none"><button class="button-for-register-1" type="submit">Update</button></p>
         </form>
      </div>
   </div>
</div>