<!-- Top Navbar-->
<div class="navbar">
   <div class="navbar-inner">
      <div class="left">
         <a href="#" class="back link">
            <i class="icon icon-back"></i>
            <span>Back</span>
         </a>
      </div>
      <div class="center sliding">{{ $page }}</div>

      @if($page == "Customer List")
         <div class="right">
            <a href="#" class="action-sheet-customer"><i class="fa fa-bars"></i></a>
         </div>
      @endif

   </div>
</div>
<div class="pages">
   <div data-page="customer-list" class="page">
      <form data-search-list=".customer-list-search" data-search-in=".item-title" class="searchbar searchbar-init">
         <div class="searchbar-input">
            <input type="search" placeholder="Search">
            <a href="#" class="searchbar-clear"></a>
         </div>
         <a href="#" class="searchbar-cancel">Cancel</a>
      </form>
      <div class="searchbar-overlay"></div>
      <div class="page-content">
         <div class="content-block searchbar-not-found">
            <div class="content-block-inner">Nothing found</div>
         </div>
         
         <div class="list-block media-list searchbar-found customer-list-search">
            <ul>
               @foreach($_shop as $shop)
               <li>
                  <a href="/super/customer-edit?id={{ $shop->shop_id }}" class="item-link item-content">
                     <div class="item-inner">
                        <div class="item-title-row">
                           <div class="item-title">{{ $shop->shop_name }}</div>
                        </div>
                        <div class="item-subtitle">{!! $shop->user_count !!}</div>
                     </div>
                  </a>
               </li>
               @endforeach
            </ul>
         </div>
         <!-- Filter Popup -->
{{--          <div class="popup popup-filter">
            <div class="content-block-title">Action List</div>
            <div class="list-block">
               <ul>
                  <li>
                     <a href="/super/customer-add" class="close-popup item-content">
                        <div class="item-inner">
                           <div class="item-title"><i class="fa fa-plus"></i> Create Customer</div>
                        </div>
                     </a>
                  </li>
                  <li>
                     <a href="/super/customer?filter=archive" class="close-popup item-content">
                        <div class="item-inner">
                           <div class="item-title"><i class="fa fa-trash"></i> Archive List</div>
                        </div>
                     </a>
                  </li>
                  <li>
                     <a href="#" class="close-popup item-content">
                        <div class="item-inner">
                           <div class="item-title"><i class="fa fa-close"></i> Closes Popup</div>
                        </div>
                     </a>
                  </li>
               </ul>
            </div>            
         </div> --}}
      </div>
   </div>
</div>