<div class="card">

    <div class="card-header">
        <ul class="nav nav-pills card-header-pills">
            @if(!count(request()->all()))
                <li class="nav-item">
                    <a class="nav-link active fw-bold" href="/">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 d-none d-sm-block" width="24"
                             height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M0 0h24v24H0z" stroke="none"/>
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M12 7v5l3 3"/>
                        </svg>
                        {{__('app.latest')}}</a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="/">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1 d-none d-sm-block" width="24"
                             height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M0 0h24v24H0z" stroke="none"/>
                            <circle cx="12" cy="12" r="9"/>
                            <path d="M12 7v5l3 3"/>
                        </svg>
                        {{__('app.latest')}}</a>
                </li>
            @endif
            @foreach($topic_menu as $data)
                @if(\Hyperf\Utils\Str::contains(core_http_url(),$data['parameter']))
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" href="{{$data['url']}}">
                            {!!$data['icon']!!}{{$data['name']}}</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{$data['url']}}">
                            {!!$data['icon']!!}{{$data['name']}}</a>
                    </li>
                @endif
            @endforeach
            <li class="nav-item d-none d-md-flex d-lg-none ms-auto">
                <a href="/topic/create" class="btn btn-primary btn-pill shadow-sm py-1" role="button" rel="noreferrer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="24"
                         height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M0 0h24v24H0z" stroke="none"/>
                        <path d="M4 20h4L18.5 9.5a1.5 1.5 0 0 0-4-4L4 16v4M13.5 6.5l4 4"/>
                    </svg>
                    发表</a>
            </li>
        </ul>
    </div>

    @if($page->count())
        @foreach($page as $data)
            <article class="col-md-12 p-3 border-bottom hoverable">
                <div class="d-flex justify-content-between border-0 card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-auto">
                                    <a href="/users/{{$data->user->username}}.html" class="avatar avatar-rounded"
                                       style="background-image: url({{super_avatar($data->user)}})">

                                    </a>
                                </div>
                                <div class="col">
                                    <a href="/users/{{$data->user->username}}.html"
                                       style="margin-bottom:0;text-decoration:none;"
                                       class="text-reset me-1"><strong>{{$data->user->username}}</strong></a>
                                    <a data-bs-toggle="tooltip" data-bs-placement="right"
                                       title="{{$data->user->class->name}}"
                                       href="/users/group/{{$data->user->class->id}}.html"
                                       style="color:{{$data->user->class->color}}">
                                        <span>{!! $data->user->class->icon !!}</span>
                                    </a>
                                    <div style="margin-top:1px">{{__("app.Published on")}}
                                        :{{format_date($data->created_at)}}</div>
                                </div>
                                <div class="col-auto">
                                    @if($data->essence>0)
                                        <div class="ribbon bg-green text-h3">
                                            {{__("app.essence")}}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12 markdown home-article">
                                    <a href="/{{$data->id}}.html" class="text-reset">
                                        <h2>
                                            @if($data->topping>0)
                                                <span class="text-red">
                                                    {{__('app.top')}}
                                                </span>
                                            @endif
                                            {{$data->title}}</h2>
                                    </a>
                                    <span class="home-summary">{!! content_brief($data->post->content,get_options("topic_brief_len",250)) !!}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top: 5px">
                            <div class="d-flex align-items-center">
                                <div class="col-auto bottomLine">
                                    <a href="/tags/{{$data->tag->id}}.html" style="text-decoration:none">
                                        <div class="card-circle">
                                            <img src="{{$data->tag->icon}}" alt="">
                                            <span>{{$data->tag->name}}</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="ms-auto">
                                    <span class="text-muted" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                          title="{{__("app.pageviews")}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                             stroke-linecap="round" stroke-linejoin="round"><path stroke="none"
                                                                                                  d="M0 0h24v24H0z"
                                                                                                  fill="none"/><circle
                                                    cx="12" cy="12" r="2"/><path
                                                    d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"/></svg>
                                        {{$data->view}}
                                    </span>
                                    <a style="text-decoration:none;" href="/{{$data->id}}.html#topic-comment"
                                       class="ms-3 text-muted cursor-pointer" data-bs-toggle="tooltip"
                                       data-bs-placement="bottom" title="{{__("app.comment")}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M3 20l1.3 -3.9a9 8 0 1 1 3.4 2.9l-4.7 1"></path>
                                            <line x1="12" y1="12" x2="12" y2="12.01"></line>
                                            <line x1="8" y1="12" x2="8" y2="12.01"></line>
                                            <line x1="16" y1="12" x2="16" y2="12.01"></line>
                                        </svg>
                                        <span core-show="topic-likes">{{$data->comments->count()}}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        @endforeach
    @else
        <div class="col-md-12">
            <div class="border-0 card card-body">
                <div class="text-center card-title">{{__("app.No more results")}}</div>
            </div>
        </div>
    @endif
    <div class="mt-2">
        {!! make_page($page) !!}
    </div>
</div>