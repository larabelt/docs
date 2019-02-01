@php
    $can['attachments'] = $auth->can(['create','update','delete'], Belt\Content\Attachment::class);
    $can['blocks'] = $auth->can(['create','update','delete'], Belt\Content\Block::class);
    $can['handles'] = $auth->can(['create','update','delete'], Belt\Content\Handle::class);
    $can['lists'] = $auth->can(['create','update','delete'], Belt\Content\Lyst::class);
    $can['pages'] = $auth->can(['create','update','delete'], Belt\Content\Page::class);
    $can['posts'] = $auth->can(['create','update','delete'], Belt\Content\Post::class);
    $can['terms'] = $auth->can(['create','update','delete'], Belt\Content\Term::class);
    $can['translation_strings'] = $auth->can(['create','update','delete'], Belt\Content\TranslatableString::class);
@endphp

@if($can['attachments'] || $can['blocks'] || $can['handles'] || $can['lists'] || $can['pages'] || $can['posts'] || $can['terms'])
    <li id="content-admin-sidebar-left" class="treeview">
        <a href="#">
            <i class="fa fa-file-o"></i> <span>Content</span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            @if($can['attachments'])
                <li id="content-admin-sidebar-left-attachments"><a href="/admin/belt/content/attachments"><i class="fa fa-paperclip"></i> <span>Attachments</span></a></li>
            @endif
            @if($can['blocks'])
                <li id="content-admin-sidebar-left-blocks"><a href="/admin/belt/content/blocks"><i class="fa fa-code"></i> <span>Blocks</span></a></li>
            @endif
            @if($can['handles'])
                <li id="content-admin-sidebar-left-handles"><a href="/admin/belt/content/handles?orderBy=-handles.hits&is_active=0"><i class="fa fa-signing"></i> <span>Handles</span></a></li>
            @endif
            @if($can['lists'])
                <li id="content-admin-sidebar-left-lists"><a href="/admin/belt/content/lists"><i class="fa fa-list"></i> <span>Lists</span></a></li>
            @endif
            @if($can['pages'])
                <li id="content-admin-sidebar-left-pages"><a href="/admin/belt/content/pages"><i class="fa fa-files-o"></i> <span>Pages</span></a></li>
            @endif
            @if($can['posts'])
                <li id="content-admin-sidebar-left-posts"><a href="/admin/belt/content/posts"><i class="fa fa-thumb-tack"></i> <span>Posts</span></a></li>
            @endif
            @if($can['terms'])
                <li id="content-admin-sidebar-left-terms"><a href="/admin/belt/content/terms"><i class="fa fa-sitemap"></i> <span>Terms</span></a></li>
            @endif
            @if($can['translation_strings'])
                <li id="content-admin-sidebar-left-terms"><a href="/admin/belt/content/translatable-strings"><i class="fa fa-keyboard-o"></i> <span>Strings</span></a></li>
            @endif
        </ul>
    </li>
@endif