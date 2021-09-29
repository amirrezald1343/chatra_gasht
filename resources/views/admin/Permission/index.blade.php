@extends('admin.layout.admin')
@section('style')
    <link href="<?= url('css/admin/user.css')?>" rel="stylesheet" type="text/css"/>

@endsection
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body overflow-auto">
                    <table class="table table-striped" style="min-width: 765px;">
                        <thead>
                        <tr>
                            <th>نام</th>
                            <th>جزئیات</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($items as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <button type="button" class="btn bg-indigo-400" data-toggle="modal"
                                            data-target="#modal_default{{$item->id}}">نمایش<i
                                                class="icon-eye ml-2"></i></button>
                                    <div id="modal_default{{$item->id}}" class="modal fade"
                                         tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"></h5>
                                                    <button type="button" class="close"
                                                            data-dismiss="modal">&times;
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-bordered table-hover bg-white">
                                                            <thead>
                                                            <tr>
                                                                <td>نام بخش</td>
                                                                <td>دسترسی</td>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @forelse($item->sections as $section)
                                                                <tr>
                                                                    <td>
                                                                        <span class="icon-indent-decrease2"></span> {{ $section->name }}
                                                                    </td>
                                                                    <td class="text-small">
                                                                        @if($section->pivot->x)
                                                                            <span><span class="icon-check text-small"></span> قابل دیدن</span>
                                                                        @else
                                                                            <span class="text-secondary"><span
                                                                                        class="icon-cross3 text-small"></span> قابل دیدن</span>
                                                                        @endif
                                                                        @if($section->pivot->w)
                                                                            <span><span class="icon-check text-small"></span> قابل نوشتن</span>
                                                                        @else
                                                                            <span class="text-secondary"><span
                                                                                        class="icon-cross3 text-small"></span> قابل نوشتن</span>
                                                                        @endif
                                                                        @if($section->pivot->d)
                                                                            <span><span class="icon-check text-small"></span> قابل حذف کردن</span>
                                                                        @else
                                                                            <span class="text-secondary"><span
                                                                                        class="icon-cross3 text-small"></span>قابل حذف کردن</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="2">
                                                                        <div class="alert alert-warning border-0 alert-dismissible">
                                                                            <button type="button" class="close"
                                                                                    data-dismiss="alert">
                                                                                <span>&times;</span></button>
                                                                            <span class="font-weight-semibold">موردی یافت نشد</span>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn bg-primary"
                                                            data-dismiss="modal"> بستن
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @can('edit', [\App\User::class,$NAME])
                                        <a href="{{ route('admin.'.$NAME.'.edit', ['id' => $item->id]) }}"
                                           class="list-icons-item" title="edit">
                                            <i class="icon-quill4"></i>
                                        </a>
                                    @endcan
                                    @can('destroy', [\App\User::class,$NAME])
                                        {{--<a href="#" @click.prevent="" class="list-icons-item" data-toggle="modal" data-target="#delete-{{ $item->id }}"><i class="icon-trash"></i></a>--}}
                                    @endcan
                                    <div id="delete-{{ $item->id }}" class="modal fade" tabindex="-1">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h6 class="font-weight-semibold mb-4"> {{ __('admin.Delete') .' '. __('admin.'.$NAME) }}</h6>
                                                    <p>{{ __('admin.Are you sure you want to delete this information?') }}</p>
                                                    <hr>
                                                </div>
                                                <div class="modal-footer justify-content-center">
                                                    <button type="button" class="btn bg-slate"
                                                            data-dismiss="modal">{{ __('admin.No') }}</button>
                                                    <form action="{{ route('admin.'.$NAME.'.destroy', ['id' => $item->id]) }}"
                                                          method="POST">
                                                        @csrf
                                                        {{ method_field('DELETE') }}
                                                        <button type="submit"
                                                                class="btn bg-danger">{{ __('admin.Yes') }} !
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10">
                                    <div class="alert alert-warning border-0 alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span>
                                        </button>
                                        <span class="font-weight-semibold">{{ __('admin.not found anything') }}</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            {!! $items->render() !!}
        </div>
    </div>
@endsection
@section('scripts')



@endsection