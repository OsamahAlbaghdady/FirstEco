@extends('layouts.dashboard.app')

@section('content')


    <section class="content-header">

        <h1>@lang('site.products')</h1>

        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
            <li><a href="{{ route('dashboard.products.index') }}"> @lang('site.products')</a></li>
            <li class="active">@lang('site.add')</li>
        </ol>
    </section>

    <section class="content">

        <div class="box box-primary">

            <div class="box-header">
                <h3 class="box-title">@lang('site.add')</h3>
            </div><!-- end of box header -->

            <div class="box-body">

                @include('partials._errors')

                <form action="{{ route('dashboard.products.store') }}" method="post" enctype="multipart/form-data">

                    {{ csrf_field() }}
                    {{ method_field('post') }}


                    <div class="form-group">
                        <label>{{ __('site.categories') }}</label>
                        <select name="category_id" class="form-control">
                            <option class="form-control" value="">{{ __('site.all_catergories') }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{old('category_id') == $category->id ? 'selected':''}}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>


                    @foreach (config('translatable.locales') as $locale)
                        <div class="form-group">
                            <label>@lang('site.'.$locale.'.name') </label>
                            <input type="text" name="{{ $locale }}[name]" class="form-control"
                                value="{{ old($locale . '.name') }}">
                        </div>
                    @endforeach

                    @foreach (config('translatable.locales') as $locale)
                        <div class="form-group">
                            <label>@lang('site.'.$locale.'.description') </label><br>
                            <textarea name="{{ $locale }}[description]" cols="174"
                                rows="5">{{ old($locale . '.description') }}</textarea>
                        </div>
                    @endforeach

                    <div class="form-group">
                        <label>@lang('site.'.'purchase_price') </label>
                        <input type="text" name="purchase_price" class="form-control" value="{{ old('purchase_price') }}">
                    </div>
                    <div class="form-group">
                        <label>@lang('site.'.'sale_price') </label>
                        <input type="text" name="sale_price" class="form-control" value="{{ old('sale_price') }}">
                    </div>
                    <div class="form-group">
                        <label>@lang('site.'.'stock') </label>
                        <input type="text" name="stock" class="form-control" value="{{ old('stock') }}">
                    </div>





                    <div class="form-group">
                        <label>@lang('site.image')</label>
                        <input type="file" name="image" class="form-control image">
                    </div>

                    <div class="form-group">
                        <img src="{{ asset('assets/dashboard/ProductImage/default.png') }}" style="width: 200px"
                            class="img-thumbnail image-preview" alt="">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</button>
                    </div>

                </form><!-- end of form -->

            </div><!-- end of box body -->

        </div><!-- end of box -->

    </section><!-- end of content -->


@endsection
