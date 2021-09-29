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
                            <th>عنوان</th>
                            <th>{{ __('admin.Icon') }}</th>
                            <th>{{ __('admin.status') }}</th>
                            <th class="text-center">{{ __('admin.Options') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($items as $key=>$item)
                            <tr>
                                <td>{{ ($items->currentPage() - 1) * $items->perPage() + $key + 1 }}</td>
                                <td>{{ $item->title }}</td>
                                <td><img src="{{ url($item->icon) }}" class="rounded-circle" width="35"></td>
                                <td>{!! $item->status == '1' ? '<span class="badge badge-flat border-success text-success-600">'.__('admin.enable').'</span>' : '<span class="badge badge-flat border-danger text-danger-600">'.__('admin.disable').'</span>' !!}</td>
                                <td class="text-center">
                                    @can('edit', [\App\User::class,$NAME])
                                        <a href="{{ route('admin.'.$NAME.'.edit', ['id' => $item->id]) }}"
                                           class="list-icons-item" title="edit">
                                            <i class="icon-quill4"></i>
                                        </a>
                                    @endcan
                                    @can('destroy', [\App\User::class,$NAME])
                                        <a href="#" @click.prevent="" class="list-icons-item" data-toggle="modal" data-target="#delete-{{ $item->id }}"><i class="icon-trash"></i></a>
                                    @endcan
                                    <div id="delete-{{ $item->id }}" class="modal fade" tabindex="-1">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <h6 class="font-weight-semibold mb-4"> {{ __('admin.Delete') .' '. $FANAME }}</h6>
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



@endsection