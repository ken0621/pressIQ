<ul>
    @foreach($_page as $page)

        @if($_for_pis_only == true && isset($page['code']) == 'item-pis-unit-measurement')
            <li>
                <a href="{{ isset($page['url']) ? $page['url'] : 'javascript:' }}" 
                class="{{ isset($page['name']) ? '' : 'subnav-text' }}">
                    
                    @if(!isset($page['code']))
                        <i class="fa fa-{{ $page['icon'] or '' }} nav-icon"></i>
                        <span class="nav-text">{{ $page["name"] }}</span>
                        <i class="{{isset($page['url']) ? '' : 'icon-angle-right'}}"></i>
                    @else
                        {!! $page["label"] !!}
                    @endif
                </a>
                @if(isset($page['submenu']))
                    @include('member.page', ['_page' => $page['submenu']])
                @endif
            </li>
        @endif
    @endforeach
</ul>
