<!-- Top Navbar-->
<div class="navbar">
   <div class="navbar-inner">
      <div class="left">
         <a href="#" class="back link">
            <i class="icon icon-back"></i>
            <span>Back</span>
         </a>
      </div>
      <div class="center sliding">Customer List</div>
   </div>
</div>
<div class="pages">
   <div data-page="customer-list" class="page">
      <div class="page-content">
         <!-- CONTENT -->
         <div class="content-block-title">List of Customers</div>
         <div class="list-block media-list">
            <ul>
               @foreach($_shop as $shop)
               <li>
                  <a href="#" class="item-link item-content">
                     <div class="item-inner">
                        <div class="item-title-row">
                           <div class="item-title">{{ $shop->shop_name }}</div>
                        </div>
                        <div class="item-subtitle">{!! $shop->domain !!}</div>
                     </div>
                  </a>
               </li>
               @endforeach
            </ul>
         </div>
      </div>
   </div>
</div>