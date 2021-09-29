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
                            <th>#</th>
                            <th>{{ __('admin.company') }}</th>
                            <th>{{ __('admin.domain') }}</th>
                            <th>{{ __('admin.username *') }}</th>
                            <th>{{ __('admin.status') }}</th>
                            <th class="text-center">{{ __('admin.Options') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($items as $key=>$item)
                            <tr>
                                <td>{{ ($items->currentPage() - 1) * $items->perPage() + $key + 1 }}</td>
                                <td>{{ $item->company }}</td>
                                <td><a href="{{ $item->domain }}" title="{{ $item->domain }}" target="_blank"
                                       class="btn bg-indigo-400"><i class="icon-link"></i> </a></td>
                                <td>{{ $item->email }}</td>


                               {{-- <td>
                                    <button type="button" class="btn bg-indigo-400" data-toggle="modal"
                                            data-target="#permissionShow{{$item->permission->id}}">{{ __('admin.'.$item->permission->name) }}</button>
                                    <div id="permissionShow{{$item->permission->id}}" class="modal fade"
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
                                                                <td>{{ __('admin.section name') }}</td>
                                                                <td>{{ __('admin.permission') }}</td>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @forelse($item->permission->sections as $section)
                                                                <tr>
                                                                    <td>
                                                                        <span class="icon-indent-decrease2"></span> {{ $section->name }}
                                                                    </td>
                                                                    <td class="text-small">
                                                                        @if($section->pivot->x)
                                                                            <span><span class="icon-check text-small"></span> {{ __('admin.Readable') }}</span>
                                                                        @else
                                                                            <span class="text-secondary"><span
                                                                                        class="icon-cross3 text-small"></span> {{ __('admin.Readable') }}</span>
                                                                        @endif
                                                                        @if($section->pivot->w)
                                                                            <span><span class="icon-check text-small"></span> {{ __('admin.Writable') }}</span>
                                                                        @else
                                                                            <span class="text-secondary"><span
                                                                                        class="icon-cross3 text-small"></span> {{ __('admin.Writable') }}</span>
                                                                        @endif
                                                                        @if($section->pivot->d)
                                                                            <span><span class="icon-check text-small"></span> {{ __('admin.Deletable') }}</span>
                                                                        @else
                                                                            <span class="text-secondary"><span
                                                                                        class="icon-cross3 text-small"></span> {{ __('admin.Deletable') }}</span>
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
                                                                            <span class="font-weight-semibold">{{ __('admin.not found anything') }}</span>
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
                                                            data-dismiss="modal"> {{ __('admin.close') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>--}}
                                <td>{!! $item->status == '1' ? '<span class="badge badge-flat border-success text-success-600">'.__('admin.enable').'</span>' : '<span class="badge badge-flat border-danger text-danger-600">'.__('admin.disable').'</span>' !!}</td>
                                <td class="text-center">
                                    @can('show', [\App\User::class,$NAME])
                                        <a class="list-icons-item" href="" title="more details" data-toggle="modal"
                                           data-target="#detailsAgency{{$item->id}}"><i
                                                    class="icon-list ml-2"></i></a>
                                        <div id="detailsAgency{{$item->id}}" class="modal fade"
                                             tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">{{ $item->domain }}</h5>
                                                        <button type="button" class="close"
                                                                data-dismiss="modal">&times;
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-bordered table-hover">
                                                                <tr>
                                                                    <td>{{ __('admin.national number') }}</td>
                                                                    <td>{{ $item->nationalNumber }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>شماره موبایل</td>
                                                                    <td>{{ $item->cellPhone }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>شماره تلفن</td>
                                                                    <td>{{ $item->tellPhone }}</td>
                                                                </tr>
                                                                <tr>
                                                                <tr>
                                                                    <td>کد داخلی</td>
                                                                    <td>{{ $item->internalCode }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>{{ __('admin.email') }}</td>
                                                                    <td>{{ $item->email }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>{{ __('admin.address') }}</td>
                                                                    <td>{{ $item->address }}</td>
                                                                </tr>



                                                                @isset($item->media)
                                                                    <tr>
                                                                        <td>{{ __('admin.attach') }}</td>
                                                                        <td><a href="{{ url($item->media->path) }}"
                                                                               target="_blank"
                                                                               title="{{ $item->media->name }}"
                                                                               type="button"
                                                                               class="btn bg-indigo-400 legitRipple">{{__('admin.download')}}
                                                                                <i class="icon-link"></i></a></td>
                                                                    </tr>
                                                                @endisset
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn bg-primary"
                                                                data-dismiss="modal">{{ __('admin.ok') }}!
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endcan
                                    @can('edit', [\App\User::class,$NAME])
                                        <a href="{{ route('admin.'.$NAME.'.edit', ['id' => $item->id]) }}"
                                           class="list-icons-item" title="edit">
                                            <i class="icon-quill4"></i>
                                        </a>
                                    @endcan
                                    {{--@can('destroy', [\App\User::class,$NAME])--}}
                                    {{--<a href="#" @click.prevent="" class="list-icons-item" data-toggle="modal" data-target="#delete-{{ $item->id }}"><i class="icon-trash"></i></a>--}}
                                    {{--@endcan--}}
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
                                <td colspan="11">
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
            {!! $items->links() !!}
        </div>
    </div>
@endsection
@section('scripts')
<script src="<?= url('js/adminVue.js?version3')?>" type="text/javascript"></script>


@endsection
