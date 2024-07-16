<?php $__env->startSection('title'); ?>
   <?php echo e(__('Payment Logs')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Payment Logs')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('section'); ?>
    <?php if(count($package_orders) > 0): ?>
        <div class="custom_domain_table">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col"><?php echo e(__('Package Order Info')); ?></th>
                    <th scope="col"><?php echo e(__('Payment Status')); ?></th>
                    <th scope="col"><?php echo e(__('Action')); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $package_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <div class="user-dahsboard-order-info-wrap">
                                <h5 class="title"><?php echo e($data->package_name); ?></h5>
                                <div class="div package_order_details_data">
                                    <small class="d-block"><strong><?php echo e(__('Order ID:')); ?></strong> #<?php echo e($data->id); ?></small>
                                    <small class="d-block"><strong><?php echo e(__('Order Name:')); ?></strong> <?php echo e($data->tenant_id.'.'.env('CENTRAL_DOMAIN')); ?></small>
                                    <small class="d-block"><strong><?php echo e(__('Package Price:')); ?></strong> <?php echo e(amount_with_currency_symbol($data->package_price)); ?></small>

                                    <small class="d-block"><strong><?php echo e(__('Order Status:')); ?></strong>
                                        <?php if($data->status == 'pending'): ?>
                                            <span class="alert_status_single alert alert-warning text-capitalize alert-sm alert-small"><?php echo e(__($data->status)); ?></span>
                                        <?php elseif($data->status == 'cancel'): ?>
                                            <span class="alert_status_single alert alert-danger text-capitalize alert-sm alert-small"><?php echo e(__($data->status)); ?></span>
                                        <?php elseif($data->status == 'in_progress'): ?>
                                            <span class="alert_status_single alert alert-info text-capitalize alert-sm alert-small"><?php echo e(__(str_replace('_',' ',$data->status))); ?></span>
                                        <?php elseif($data->status == 'trial'): ?>
                                            <span class="alert_status_single lert alert-primary text-capitalize alert-sm alert-small"><?php echo e(__(str_replace('_',' ',$data->status))); ?></span>
                                        <?php else: ?>
                                            <span class="alert_status_single alert alert-success text-capitalize alert-sm alert-small"><?php echo e(__($data->status)); ?></span>
                                        <?php endif; ?>
                                    </small>

                                    <small class="d-block"><strong><?php echo e(__('Start Date:')); ?></strong> <?php echo e(date('d-m-Y',strtotime($data->start_date))); ?></small>
                                    <small class="d-block"><strong><?php echo e(__('Expire Date:')); ?></strong> <?php echo e($data->expire_date != null ? date('d-m-Y',strtotime($data->expire_date)) : __('Lifetime')); ?></small>
                                    <small class="d-block"><strong><?php echo e(__('Renew Taken :')); ?></strong> <?php echo e($data->renew_status ?? 0); ?></small>

                                    <?php if($data->payment_status == 'complete'): ?>
                                        <form action="<?php echo e(route(route_prefix().'frontend.package.invoice.generate')); ?>"  method="post">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="id" id="invoice_generate_order_field" value="<?php echo e($data->id); ?>">
                                            <button class="btn btn-secondary btn-xs btn-small margin-top-10" type="submit"><?php echo e(__('Invoice')); ?></button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php if($data->payment_status != 'complete' && $data->status != 'cancel'): ?>
                                <span class="alert_status_single alert alert-warning text-capitalize alert-sm"><?php echo e(__($data->payment_status)); ?></span>
                                <a href="<?php echo e(route(route_prefix().'frontend.order.confirm',$data->package_id)); ?>" class="btn btn-success btn-sm"><?php echo e(__('Pay Now')); ?></a>
                                <form action="<?php echo e(route(route_prefix().'user.dashboard.package.order.cancel')); ?>" method="post">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="order_id" value="<?php echo e($data->id); ?>">
                                    <button type="submit" class="btn btn-danger btn-sm margin-top-10"><?php echo e(__('Cancel')); ?></button>
                                </form>
                            <?php else: ?>
                                <?php
                                    $payment_status_color = match ($data->payment_status) {
                                        'complete' => 'alert-success',
                                        'pending' => 'alert-warning',
                                        'cancel' => 'alert-danger'
                                    }
                                ?>
                                <span class="alert_status_single alert <?php echo e($payment_status_color); ?> text-capitalize alert-sm" style="display: inline-block"><?php echo e(__($data->payment_status)); ?></span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php if($data->payment_status != 'complete'): ?>
                                <div class="btn-wrapper">
                                    <a href="<?php echo e(route(route_prefix().'frontend.order.confirm',$data->package_id)); ?>" class="cmn-btn btn-success cmn-btn-small text-white" target="_blank"><?php echo e(__('Renew Now')); ?></a>
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="blog-pagination">
            <?php echo e($package_orders->links()); ?>

        </div>
    <?php else: ?>
        <div class="alert alert-warning"><?php echo e(__('No Order Found')); ?></div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        $('.close-bars, .body-overlay').on('click', function() {
            $('.dashboard-close, .dashboard-close-main, .body-overlay').removeClass('active');
        });
        $('.sidebar-icon').on('click', function() {
            $('.dashboard-close, .dashboard-close-main, .body-overlay').addClass('active');
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('landlord.frontend.user.dashboard.user-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\nazmart\core\resources\views/landlord/frontend/user/dashboard/package-order.blade.php ENDPATH**/ ?>