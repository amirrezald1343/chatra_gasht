<?php $__env->startSection('style'); ?>
    <link href="<?= url('css/admin/user.css')?>" rel="stylesheet" type="text/css"/>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-body overflow-auto">
                    <table class="table table-striped" style="min-width: 765px;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo e(__('admin.company')); ?></th>
                            <th><?php echo e(__('admin.domain')); ?></th>
                            <th><?php echo e(__('admin.username *')); ?></th>
                            <th><?php echo e(__('admin.status')); ?></th>
                            <th class="text-center"><?php echo e(__('admin.Options')); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e(($items->currentPage() - 1) * $items->perPage() + $key + 1); ?></td>
                                <td><?php echo e($item->company); ?></td>
                                <td><a href="<?php echo e($item->domain); ?>" title="<?php echo e($item->domain); ?>" target="_blank"
                                       class="btn bg-indigo-400"><i class="icon-link"></i> </a></td>
                                <td><?php echo e($item->email); ?></td>


                               
                                <td><?php echo $item->status == '1' ? '<span class="badge badge-flat border-success text-success-600">'.__('admin.enable').'</span>' : '<span class="badge badge-flat border-danger text-danger-600">'.__('admin.disable').'</span>'; ?></td>
                                <td class="text-center">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('show', [\App\User::class,$NAME])): ?>
                                        <a class="list-icons-item" href="" title="more details" data-toggle="modal"
                                           data-target="#detailsAgency<?php echo e($item->id); ?>"><i
                                                    class="icon-list ml-2"></i></a>
                                        <div id="detailsAgency<?php echo e($item->id); ?>" class="modal fade"
                                             tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"><?php echo e($item->domain); ?></h5>
                                                        <button type="button" class="close"
                                                                data-dismiss="modal">&times;
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-bordered table-hover">
                                                                <tr>
                                                                    <td><?php echo e(__('admin.national number')); ?></td>
                                                                    <td><?php echo e($item->nationalNumber); ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>شماره موبایل</td>
                                                                    <td><?php echo e($item->cellPhone); ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>شماره تلفن</td>
                                                                    <td><?php echo e($item->tellPhone); ?></td>
                                                                </tr>
                                                                <tr>
                                                                <tr>
                                                                    <td>کد داخلی</td>
                                                                    <td><?php echo e($item->internalCode); ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?php echo e(__('admin.email')); ?></td>
                                                                    <td><?php echo e($item->email); ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?php echo e(__('admin.address')); ?></td>
                                                                    <td><?php echo e($item->address); ?></td>
                                                                </tr>



                                                                <?php if(isset($item->media)): ?>
                                                                    <tr>
                                                                        <td><?php echo e(__('admin.attach')); ?></td>
                                                                        <td><a href="<?php echo e(url($item->media->path)); ?>"
                                                                               target="_blank"
                                                                               title="<?php echo e($item->media->name); ?>"
                                                                               type="button"
                                                                               class="btn bg-indigo-400 legitRipple"><?php echo e(__('admin.download')); ?>

                                                                                <i class="icon-link"></i></a></td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn bg-primary"
                                                                data-dismiss="modal"><?php echo e(__('admin.ok')); ?>!
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit', [\App\User::class,$NAME])): ?>
                                        <a href="<?php echo e(route('admin.'.$NAME.'.edit', ['id' => $item->id])); ?>"
                                           class="list-icons-item" title="edit">
                                            <i class="icon-quill4"></i>
                                        </a>
                                    <?php endif; ?>
                                    
                                    
                                    
                                    <div id="delete-<?php echo e($item->id); ?>" class="modal fade" tabindex="-1">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h6 class="font-weight-semibold mb-4"> <?php echo e(__('admin.Delete') .' '. __('admin.'.$NAME)); ?></h6>
                                                    <p><?php echo e(__('admin.Are you sure you want to delete this information?')); ?></p>
                                                    <hr>
                                                </div>
                                                <div class="modal-footer justify-content-center">
                                                    <button type="button" class="btn bg-slate"
                                                            data-dismiss="modal"><?php echo e(__('admin.No')); ?></button>
                                                    <form action="<?php echo e(route('admin.'.$NAME.'.destroy', ['id' => $item->id])); ?>"
                                                          method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo e(method_field('DELETE')); ?>

                                                        <button type="submit"
                                                                class="btn bg-danger"><?php echo e(__('admin.Yes')); ?> !
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="11">
                                    <div class="alert alert-warning border-0 alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span>
                                        </button>
                                        <span class="font-weight-semibold"><?php echo e(__('admin.not found anything')); ?></span>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php echo $items->links(); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src="<?= url('js/adminVue.js?version3')?>" type="text/javascript"></script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\clicksafar\resources\views/admin/Traveler/index.blade.php ENDPATH**/ ?>