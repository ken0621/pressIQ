<ul>
    @foreach($_page as $page)
        <li>
            <a href="{{ isset($page['url']) ? $page['url'] : 'javascript:' }}" 
            class="{{ isset($page['type']) ? '' : 'subnav-text' }}">
                @if(!isset($page['url']))
                    <i class="fa fa-{{ $page['icon'] or '' }} nav-icon"></i>
                        <span class="nav-text">
                            {{ $page["name"] }}
                        </span>
                    <i class="icon-angle-right"></i>
                @else
                    {{ $page["label"] }}
                @endif
            </a>
            @if(isset($page['submenu']))
                @include('member.page', ['_page' => $page['submenu']])
            @endif
        </li>
    @endforeach
</ul>