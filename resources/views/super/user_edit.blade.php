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
   <div data-page="user-edit" class="page">
      <div class="page-content">
         <form action="/super/user-edit" method="post" class="ajax-submit">
            {{ csrf_field() }}
            <div class="content-block-title">Customer Information</div>
            <div class="list-block">
               <ul>
                  <!-- Text inputs -->
                  <li>
                     <div class="item-content">
                        <div class="item-inner">
                           <div class="item-title label">First Name</div>
                           <div class="item-input">
                              <input name="first_name" type="text" placeholder="First Name" value="{{ $user->user_first_name }}">
                           </div>
                        </div>
                     </div>
                  </li>
                  <!-- Text inputs -->
                  <li>
                     <div class="item-content">
                        <div class="item-inner">
                           <div class="item-title label">Last Name</div>
                           <div class="item-input">
                              <input name="first_name" type="text" placeholder="First Name" value="{{ $user->user_last_name }}">
                           </div>
                        </div>
                     </div>
                  </li>
               </ul>
            </div>

            <div class="content-block-title">Action List</div>
            <div class="list-block">
               <ul>
                  <li><a href="" class="item-link list-button">Archive</a></li>
               </ul>
            </div>

            <p style="text-align: right; display: none"><button class="button-for-register-1" type="submit">Update</button></p>
         </form>
      </div>
   </div>
</div>