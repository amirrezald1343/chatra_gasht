@extends('admin.layout.admin')
@section('style')

@endsection
@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header mb-3">
                    <i class="icon-link"></i> <span>لینک های مرتبط :  </span>
                    <a href="{{ route('admin.'.$NAME.'.index') }}"
                       class="btn bg-slate text-small">{{ ' لیست '.$FANAME }}</a>
                </div>
                <div class="card-body">
                    @if(isset($model))
                        {{ Form::model($model,['route'=>['admin.'.$NAME.'.update',$model->id],'files'=>true,'method'=>'put','class'=>'form-horizontal']) }}
                    @else
                        {{ Form::open(['route'=>['admin.'.$NAME.'.store'],'files'=>true,'method'=>'post','class'=>'form-horizontal']) }}
                    @endif
                    <div class="form-group col-md-6">
                        <label for="name">نام:</label>
                        {{ Form::text('name',null,['class'=>'form-control','placeholder'=> 'نام را وارد کنید']) }}
                        {!! getError($errors,'name') !!}
                    </div>
                    <div class="row">
                        @forelse($items as $key=>$item)
                            @if(($item->permissions[0]->pivot->x ?? 0) == 1 || ($item->permissions[0]->pivot->w ?? 0) == 1 || ($item->permissions[0]->pivot->d ?? 0) == 1 || \Auth::user()->permission->invisible)
                            <div class="col-md-4">
                                <div class="card-header">
                                    <h6 class="card-title">{{ (session()->get('direction') == 'ltr') ? $item->model : $item->name }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        @if(isset($item->permissions[0]->pivot->x) && $item->permissions[0]->pivot->x == 1 || \Auth::user()->permission->invisible)
                                            <div class="custom-control custom-checkbox">
                                                {{ Form::checkbox('section_id['.$item->id.'][x]',true,collect($model->sections ?? [])->where('id',$item->id)->first()->pivot->x ?? 0,['class'=>'custom-control-input','id'=>'showData'.$item->id]) }}
                                                <label class="custom-control-label text-small text-grey-700"
                                                       for="showData{{ $item->id }}">نمایش اطلاعات</label>
                                            </div>
                                        @endif
                                        @if(isset($item->permissions[0]->pivot->w) && $item->permissions[0]->pivot->w == 1 || \Auth::user()->permission->invisible)
                                            <div class="custom-control custom-checkbox">
                                                {{ Form::checkbox('section_id['.$item->id.'][w]',true,collect($model->sections ?? [])->where('id',$item->id)->first()->pivot->w ?? 0,['class'=>'custom-control-input','id'=>'editData'.$item->id]) }}
                                                <label class="custom-control-label text-small text-grey-700"
                                                       for="editData{{ $item->id }}">ثبت و ویرایش اطلاعات</label>
                                            </div>
                                        @endif
                                        @if(isset($item->permissions[0]->pivot->d) && $item->permissions[0]->pivot->d == 1 || \Auth::user()->permission->invisible)
                                            <div class="custom-control custom-checkbox">
                                                {{ Form::checkbox('section_id['.$item->id.'][d]',true,collect($model->sections ?? [])->where('id',$item->id)->first()->pivot->d ?? 0,['class'=>'custom-control-input','id'=>'deleteData'.$item->id]) }}
                                                <label class="custom-control-label text-small text-grey-700"
                                                       for="deleteData{{ $item->id }}">حذف اطلاعات</label>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                        @empty
                        @endforelse
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary"
                               value="{{ isCreate() ? 'ایجاد' : 'ویرایش'  }} {{ $FANAME }} "/>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/uniform.min.js') ?>"></script>
    <script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/switchery.min.js') ?>"></script>
    <script type="text/javascript" src="<?= url('global_assets/js/plugins/forms/styling/switch.min.js') ?>"></script>
    <script type="text/javascript" src="<?= url('global_assets/js/pages/form_checkboxes_radios.js') ?>"></script>
@endsection