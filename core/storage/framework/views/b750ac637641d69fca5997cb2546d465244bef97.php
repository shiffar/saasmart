<?php $__env->startSection('title'); ?>
    <?php echo $page_post->title; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-title'); ?>
    <?php echo $page_post->title; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('seo_data'); ?>
    <?php echo SEOMeta::generate(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if($page_post->page_builder === 1): ?>
        <?php if( $page_post->visibility === 1): ?>
            <?php if(auth('web')->check()): ?>
                <?php echo $__env->make('landlord.frontend.partials.pages-portion.dynamic-page-builder-part',['page_post' => $page_post], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php else: ?>
                <section class="padding-top-100 padding-bottom-100">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="alert alert-warning">
                                    <p><a class="text-primary" href="<?php echo e(route('landlord.user.login')); ?>"><?php echo e(__('Login')); ?></a> <?php echo e(__('to see this page')); ?> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
        <?php else: ?>
            <?php echo $__env->make('landlord.frontend.partials.pages-portion.dynamic-page-builder-part',['page_post' => $page_post], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    <?php else: ?>
        <?php echo $__env->make('landlord.frontend.partials.dynamic-content', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <?php if(Auth::guard('admin')->user()): ?>
        <?php echo $__env->make('tenant.frontend.partials.inpage-edit',['page_post' => $page_post], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('landlord.frontend.frontend-page-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\nazmart\core\resources\views/landlord/frontend/pages/dynamic-single.blade.php ENDPATH**/ ?>