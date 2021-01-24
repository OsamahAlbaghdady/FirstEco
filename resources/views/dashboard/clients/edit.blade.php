@extends('layouts.dashboard.app')

@section('content')


    <section class="content-header">

        <h1>@lang('site.clients')</h1>

        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
            <li><a href="{{ route('dashboard.clients.index') }}"> @lang('site.clients')</a></li>
            <li class="active">@lang('site.edit')</li>
        </ol>
    </section>

    <section class="content">

        <div class="box box-primary">

            <div class="box-header">
                <h3 class="box-title">@lang('site.edit')</h3>
            </div><!-- end of box header -->

            <div class="box-body">

                @include('partials._errors')

                <form action="{{ route('dashboard.clients.update', $client->id) }}" method="post"
                    enctype="multipart/form-data">

                    {{ csrf_field() }}
                    {{ method_field('put') }}




                    <div class="form-group">
                        <label>@lang('site.ClientName') </label>
                        <input type="text" name="name" class="form-control" value="{{ $client->name }}">
                    </div>

                    @for ($i = 0; $i < 2; $i++)
                        <div class="form-group">
                            <label>@lang('site.phone') </label>
                            <input type="text" name="phone[]" class="form-control" value="{{ $client->phone[$i] }}">
                        </div>
                    @endfor


                    <div class="form-group">
                        <label>@lang('site.address') </label>
                        <input type="text" name="address" class="form-control" value="{{ $client->address }}">
                        <input type="hidden" name="id" value="{{ $client->id }}">
                    </div>





                    <div class="form-group">
                        <label>@lang('site.image')</label>
                        <input type="file" name="image" class="form-control image">
                    </div>

                    <div class="form-group">
                        <img src="{{ $client->image_path }}" style="width: 100px" class="img-thumbnail image-preview"
                            alt="">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.edit')</button>
                    </div>

                </form><!-- end of form -->

            </div><!-- end of box body -->

        </div><!-- end of box -->

    </section><!-- end of content -->


@endsection
