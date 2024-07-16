<?php $__env->startSection('title'); ?>
    <?php echo e(__('Payment Success For:')); ?> <?php echo e($payment_details->package_name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e($payment_details->package_name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('style'); ?>
    <style>
        .store-icon {
            font-size: 20px;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $site_domain = DB::table('domains')->where('tenant_id', $payment_details->tenant_id)->first();
    ?>

    <div class="error-page-content" data-padding-bottom="100">
        <div class="container">
            <?php if(empty($domain)): ?>
                <div class="alert alert-danger text-bold text-center mt-2">
                    <i class="las la-info-circle"></i>
                    <?php echo e(__('Your website is not ready yet, you will get notified by email when it is ready.')); ?>

                </div>
            <?php endif; ?>

            <?php if($domain): ?>
                <div class="alert alert-success text-bold text-center mt-2">
                    <i class="las la-info-circle"></i>
                    <?php echo e(__('An email has been sent to your email with credentials and instructions for you shop.')); ?>

                </div>
            <?php endif; ?>


            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="order-success-area margin-bottom-80 text-center pt-5">
                        <h1 class="title"><?php echo e(get_static_option('site_order_success_page_title')); ?></h1>
                        <p class="order-page-description"><?php echo e(get_static_option('site_order_success_page_description')); ?></p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="single-billing-items">
                        <h2 class="billing-title"><?php echo e(__('Order Details')); ?></h2>
                        <ul class="billing-details mt-4">
                            <li><strong><?php echo e(__('Order ID:')); ?></strong> #<?php echo e($payment_details->id); ?></li>
                            <li class="text-capitalize">
                                <strong><?php echo e(__('Payment Package:')); ?></strong> <?php echo e($payment_details->package_name); ?></li>
                            <li class="text-capitalize">
                                <strong><?php echo e(__('Payment Package Type:')); ?></strong> <?php echo e(\App\Enums\PricePlanTypEnums::getText(optional($payment_details->package)->type)); ?>

                            </li>
                            <li class="text-capitalize"><strong><?php echo e(__('Payment Gateway:')); ?></strong>
                                <?php
                                    $gateway = str_replace('_', ' ',$payment_details->package_gateway);
                                ?>
                                <?php echo e($gateway); ?>

                            </li>
                            <li class="text-capitalize">
                                <strong><?php echo e(__('Payment Status:')); ?></strong> <?php echo e($payment_details->payment_status); ?></li>
                            <li><strong><?php echo e(__('Transaction ID:')); ?></strong> <?php echo e($payment_details->transaction_id); ?></li>

                            <?php if(!empty($site_domain)): ?>
                                <li><strong><?php echo e(__('Shop URL:')); ?></strong> <a
                                        href="<?php echo e(tenant_url_with_protocol($site_domain->domain)); ?>"
                                        target="_blank"><?php echo e($site_domain->domain); ?></a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="single-billing-items mt-4">
                        <h2 class="billing-title"><?php echo e(__('Billing Details')); ?></h2>
                        <ul class="billing-details mt-4">
                            <li><strong><?php echo e(__('Name')); ?></strong> <?php echo e($payment_details->name); ?></li>
                            <li><strong><?php echo e(__('Email')); ?></strong> <?php echo e($payment_details->email); ?></li>
                        </ul>
                    </div>
                    <div class="btn-wrapper mt-5">
                        <a href="<?php echo e(route('landlord.homepage')); ?>"
                           class="cmn-btn cmn-btn-bg-1 "><?php echo e(__('Back To Home')); ?></a>

                        <?php if(!empty($site_domain)): ?>
                            <a href="<?php echo e(tenant_url_with_protocol($site_domain->domain)); ?>" class="cmn-btn cmn-btn-bg-4"
                               target="_blank"><?php echo e(__('Open Shop')); ?> <i class="store-icon las la-store-alt"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single-price-plan-item">
                        <div class="price-header">
                            <h3 class="title"><?php echo e($payment_details->package_name); ?></h3>
                            <div class="price-wrap mt-4"><span
                                    class="price"><?php echo e(amount_with_currency_symbol($payment_details->package_price)); ?></span><?php echo e($payment_details->type ?? ''); ?>

                            </div>
                            <h5 class="title text-primary mt-2"><?php echo e(__('Start Date :')); ?><?php echo e($payment_details->start_date ?? ''); ?></h5>
                            <h5 class="title text-danger mt-2"><?php echo e(__('Expire Date :')); ?><?php echo e($payment_details->expire_date?->format('d-m-Y H:m:s') ?? 'Life Time'); ?></h5>
                        </div>
                        <div class="price-body mt-4">
                            <ul class="features">
                                <?php if(!empty(optional($payment_details->package)->page_permission_feature)): ?>
                                    <li class="check"> <?php echo e(sprintf(__('Page Create %d'),optional($payment_details->package)->page_permission_feature )); ?></li>
                                <?php endif; ?>

                                <?php if(!empty(optional($payment_details->package)->blog_permission_feature)): ?>
                                    <li class="check"> <?php echo e(sprintf(__('Blog Create %d'),optional($payment_details->package)->blog_permission_feature )); ?></li>
                                <?php endif; ?>

                                <?php if(!empty(optional($payment_details->package)->service_permission_feature)): ?>
                                    <li class="check"> <?php echo e(sprintf(__('Service Create %d'),optional($payment_details->package)->service_permission_feature )); ?></li>
                                <?php endif; ?>

                                <?php $__currentLoopData = optional($payment_details->package)->plan_features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="check"> <?php echo e(str_replace('_', ' ',ucfirst($item->feature_name)) ?? ''); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                        <div class="price-footer pb-0">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('landlord.frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\nazmart\core\resources\views/landlord/frontend/payment/payment-success.blade.php ENDPATH**/ ?>