<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('User Home')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    <?php echo e(__('User Home')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('style'); ?>
    <style>
        .badge {
            font-size: 15px;
        }
    </style>
    <style>
        .payment_getway_image ul {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            align-items: stretch;
        }
        .payment_getway_image ul li {
            width: calc(100% / 5 - 8px);
            transition: 0.3s;
            border: 2px solid transparent;
            cursor: pointer;
            box-sizing: border-box;
            display: flex;
            align-items: center;
            border-color: #ddd;
            overflow: hidden;
            height: 50px;
        }
        .payment_getway_image ul li:is(:hover, .selected){
            border: 2px solid red;
        }
    </style>

    <style>
        .text-center .confirm-details--icon {
            margin-inline: auto;
        }
        .confirm-details--icon {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 50px;
            width: 50px;
            border-radius: 50%;
            background-color: var(--main-color-three);
            color: #fff;
            font-size: 24px;
        }
        .confirm-details--title {
            font-size: 24px;
            font-weight: 600;
            line-height: 1.2;
            color: var(--heading-color);
        }
        .confirm-details--para {
            font-size: 16px;
            font-weight: 400;
            line-height: 24px;
            color: var(--paragraph-color);
            text-align: left;
        }
        .confirm-details--para span:first-child{
            font-weight: 800;
        }
    </style>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('section'); ?>
    <?php
        $auth_user = Auth::guard('web')->user();
    ?>
    <div class="row g-4">
        <div class="col-md-12">
            <div class="btn-wrapper mb-3 mt-2" style="float: right">
                <a href="javascript:void(0)" class="cmn-btn cmn-btn-bg-1 cmn-btn-small mx-2"
                   data-bs-toggle="modal"
                   data-bs-target="#user_add_subscription"
                ><?php echo e(__('Create Shop')); ?></a>
            </div>
        </div>
        <div class="col-xl-6 col-md-6 orders-child">
            <div class="single-orders">
                <div class="orders-flex-content">
                    <div class="icon">
                        <i class="las la-tasks"></i>
                    </div>
                    <div class="contents">
                        <h2 class="order-titles"> <?php echo e($package_orders ?? ''); ?> </h2>
                        <span class="order-para"><?php echo e(__('Total Orders')); ?> </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6 orders-child">
            <div class="single-orders">

                <div class="orders-flex-content">
                    <div class="icon">
                        <i class="las la-tasks"></i>
                    </div>
                    <div class="contents">
                        <h2 class="order-titles"> <?php echo e($support_tickets ?? ''); ?> </h2>
                        <span class="order-para"><?php echo e(__('Support Tickets')); ?> </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="subdomains custom_domain_wrap mt-4">
                <h4 class="custom_domain_title"><?php echo e(__('Your Shops')); ?></h4>
                <div class="payment custom_domain_table mt-4">
                    <table class="table table-bordered recent_payment_table">
                        <thead>
                        <th><?php echo e(__('ID')); ?></th>
                        <th><?php echo e(__('Site')); ?></th>
                        <th><?php echo e(__('Browse')); ?></th>
                        </thead>
                        <tbody class="w-100">
                        <?php
                            $user = Auth::guard('web')->user();
                        ?>

                        <?php $__currentLoopData = $user->tenant_details ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $url = '';
                                $central = '.'.env('CENTRAL_DOMAIN');

                                if(!empty($data->custom_domain?->custom_domain) && $data->custom_domain?->custom_domain_status == 'connected'){
                                    $custom_url = $data->custom_domain?->custom_domain ;
                                    $url = tenant_url_with_protocol($custom_url);
                                }else{
                                    $local_url = $data->id .$central ;
                                    $url = tenant_url_with_protocol($local_url);
                                }

                                $hash_token = hash_hmac('sha512',$user->username.'_'.$data->id, $data->unique_key);
                            ?>

                            <tr>
                                <td><?php echo e($key +1); ?></td>
                                <td><?php echo e($url); ?></td>
                                <td>
                                    <a class="badge rounded bg-primary px-4 visitweb"
                                       href="<?php echo e(tenant_url_with_protocol(optional($data->domain)->domain)); ?>" target="_blank"><?php echo e(__('Visit Website')); ?></a>
                                    <a class="badge rounded bg-danger px-4" href="<?php echo e($url.'/token-login/'.$hash_token); ?>" target="_blank"><?php echo e(__('Login as Super Admin')); ?></a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="custom_domain_wrap mt-4">
                <h4 class="custom_domain_title"><?php echo e(__('Recent Orders')); ?></h4>
                <div class="payment custom_domain_table mt-4">
                    <table class="table table-bordered recent_payment_table">
                        <thead>
                        <th><?php echo e(__('ID')); ?></th>
                        <th><?php echo e(__('Order Name')); ?></th>
                        <th><?php echo e(__('Package Name')); ?></th>
                        <th><?php echo e(__('Amount')); ?></th>
                        <th><?php echo e(__('Payment Status')); ?></th>
                        <th><?php echo e(__('Start Date')); ?></th>
                        <th><?php echo e(__('Expire Date')); ?></th>
                        <th><?php echo e(__('Renew Taken')); ?></th>
                        </thead>
                        <tbody class="w-100">
                        <?php $__currentLoopData = $recent_logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($key +1); ?></td>
                                <td><?php echo e($data?->domain?->domain ?? __('Unsuccessful Transaction')); ?></td>
                                <td><?php echo e($data->package_name); ?></td>
                                <td><?php echo e(amount_with_currency_symbol($data->package_price)); ?></td>
                                <td><?php echo e($data->payment_status); ?></td>
                                <td><?php echo e(date('d-m-Y', strtotime($data->start_date))); ?></td>
                                <td><?php echo e($data->expire_date != null ? date('d-m-Y', strtotime($data->expire_date)) : __('Lifetime')); ?></td>
                                <td><?php echo e($data->renew_status); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Assign Subscription Modal -->
    <div class="modal fade" id="user_add_subscription" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo e(__('Create Shop')); ?></h5>
                    <button type="button" class="close rounded" data-bs-dismiss="modal"><span>×</span></button>
                </div>

                <form action="<?php echo e(route('landlord.frontend.order.payment.form')); ?>" id="user_add_subscription_form" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <div class="modal-body">
                        <input type="hidden" name="subs_user_id" id="subs_user_id" value="<?php echo e($user->id); ?>">
                        <input type="hidden" name="package_id" id="subs_pack_id">
                        <input type="hidden" name="name" id="name" value="<?php echo e($auth_user->name); ?>">
                        <input type="hidden" name="email" id="email" value="<?php echo e($auth_user->email); ?>">
                        <input type="hidden" name="payment_gateway" value="manual_payment" class="payment_gateway_passing_clicking_name">

                        <div class="form-group">
                            <label for="subdomain"><?php echo e(__('Subdomain')); ?></label>
                            <select class="form-select subdomain" id="subdomain" name="subdomain">
                                <option value="" selected disabled><?php echo e(__('Select a subdomain')); ?></option>
                                    <?php $__currentLoopData = $user->tenant_details ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tenant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($tenant->payment_log->package->type == \App\Enums\PricePlanTypEnums::LIFETIME) continue; ?>
                                        <option value="<?php echo e($tenant->id); ?>"><?php echo e(optional($tenant->domain)->domain); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <option value="custom_domain__dd"><?php echo e(__('Add new subdomain')); ?></option>;
                            </select>
                        </div>

                        <div class="form-group custom_subdomain_wrapper mt-3">
                            <label for="custom-subdomain"><?php echo e(__('Add new subdomain')); ?></label>
                            <input class="form--control custom_subdomain" id="custom-subdomain" type="text" autocomplete="off" value="<?php echo e(old('subdomain')); ?>"
                                   placeholder="<?php echo e(__('Subdomain')); ?>" style="border:0;border-bottom: 1px solid #595959;width: 100%">
                            <div id="subdomain-wrap"></div>
                        </div>

                        <div class="form-group mt-3">
                            <?php
                                $price_plan = \App\Models\PricePlan::where('status', \App\Enums\StatusEnums::PUBLISH)->get();
                            ?>
                            <label for=""><?php echo e(__('Select A Package')); ?></label>
                            <select class="form-control package_id_selector" name="package">
                                <option value=""><?php echo e(__('Select Package')); ?></option>
                                <?php $__currentLoopData = $price_plan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $price): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($price->id); ?>" data-id="<?php echo e($price->id); ?>" data-title="<?php echo e($price->title); ?>">
                                        <?php echo e($price->title); ?> <?php echo e('('.amount_with_currency_symbol($price->price).')'); ?> - <?php echo e(\App\Enums\PricePlanTypEnums::getText($price->type)); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="form-group mt-3" style="display: none">
                            <?php
                                $themes = getAllThemeSlug();
                            ?>
                            <label for="custom-theme"><?php echo e(__('Add Theme')); ?></label>
                            <select class="form-select text-capitalize" name="theme_slug" id="custom-theme">
                                <?php $__currentLoopData = $themes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $theme): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($theme); ?>" <?php echo e($theme === get_static_option('default_theme') ? 'selected' : ''); ?>><?php echo e($theme); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="form-group mt-3">
                            <?php echo \App\Helpers\PaymentGatewayRenderHelper::renderPaymentGatewayForForm(); ?>

                        </div>

                        <div class="form-group single-input d-none manual_transaction_id mt-4">
                            <?php
                                $payment_gateways = \App\Models\PaymentGateway::where(['status' => \App\Enums\StatusEnums::PUBLISH, 'name' => 'manual_payment'])->first();
                            ?>
                            <?php if(!empty($payment_gateways)): ?>
                                <p class="alert alert-info "><?php echo e(json_decode($payment_gateways->credentials)->description ?? ''); ?></p>
                            <?php endif; ?>

                            <input type="text" name="trasaction_id"
                                   class="form-control form--control mt-2"
                                   placeholder="<?php echo e(__('Transaction ID')); ?>">

                            <input type="file" name="trasaction_attachment"
                                   class="form-control form--control mt-2"
                                   placeholder="<?php echo e(__('Transaction Attachment')); ?>" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
                        <button type="button" class="btn btn-primary" data-bs-target="#final_result"><?php echo e(__('Submit')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="final_result" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo e(__('Confirm Details')); ?></h5>
                    <button type="button" class="close rounded" data-bs-dismiss="modal"><span>×</span></button>
                </div>

                    <div class="modal-body">
                        <div class="confirm-details text-center">
                            <div class="confirm-details--icon"><i class="las la-check"></i></div>
                            <h4 class="confirm-details--title mt-3"><?php echo e(__('New Purchase')); ?></h4>

                            <div class="row">
                                <div class="col-6">
                                    <p class="confirm-details--para mt-3">
                                        <span><?php echo e(__('Shop Name:')); ?></span>
                                        <span class="shop_name">Null</span>
                                    </p>
                                    <p class="confirm-details--para mt-3">
                                        <span><?php echo e(__('Package Name:')); ?></span>
                                        <span class="package_name">Null</span>
                                    </p>
                                    <p class="confirm-details--para mt-3">
                                        <span><?php echo e(__('Theme:')); ?></span>
                                        <span class="theme"></span>
                                    </p>
                                </div>

                                <div class="col-6">
                                    <p class="confirm-details--para mt-3">
                                        <span><?php echo e(__('Price:')); ?></span>
                                        <span class="price"></span>
                                    </p>
                                    <p class="confirm-details--para mt-3">
                                        <span><?php echo e(__('Validity:')); ?></span>
                                        <span class="validity"></span>
                                    </p>
                                    <p class="confirm-details--para mt-3">
                                        <span><?php echo e(__('Payment Gateway:')); ?></span>
                                        <span class="payment_gateway"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
                        <button type="button" class="btn btn-primary" id="final-submit"><?php echo e(__('Submit')); ?></button>
                    </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.custom-js.landloard-unique-subdomain-check','data' => ['name' => 'custom_subdomain']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('custom-js.landloard-unique-subdomain-check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('custom_subdomain')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    <script>
        const final_detail = {
            theme: `<?php echo e(get_static_option('default_theme')); ?>`
        };

        $(document).on('change','.package_id_selector',function (){
            let el = $(this);
            let form = $('.user_add_subscription_form');
            $('#subs_pack_id').val(el.val());
        });

        let custom_subdomain_wrapper = $('.custom_subdomain_wrapper');
        custom_subdomain_wrapper.hide();
        $(document).on('change', '#subdomain', function (e){
            let el = $(this);
            let subdomain_type = el.val();

            if(subdomain_type === 'custom_domain__dd')
            {
                custom_subdomain_wrapper.slideDown();
                custom_subdomain_wrapper.find('#custom-subdomain').attr('name', 'custom_subdomain');
                final_detail.subdomain = undefined;
            } else {
                custom_subdomain_wrapper.slideUp();
                custom_subdomain_wrapper.removeAttr('#custom-subdomain').attr('name', 'custom_subdomain');
                final_detail.subdomain = $('#subdomain').val();
                final_detail.renew_status = true;
            }
        });

        $(document).on('change','#custom-subdomain',function () {
            final_detail.subdomain = $(this).val();
            final_detail.renew_status = false;
        });

        $(document).on('change', '#subdomain', function (){
            let el = $(this).parent().parent().find(".form-group #custom-theme");
            let subdomain = $(this).val();

                $.ajax({
                    url: '<?php echo e(route('landlord.admin.tenant.check.subdomain.theme')); ?>',
                    type: 'POST',
                    data: {
                        _token : '<?php echo e(csrf_token()); ?>',
                        subdomain : subdomain
                    },
                    success: function (res) {
                        if(res.theme_slug !== '')
                        {
                            el.find(`option`).attr('selected', false);
                            el.find(`option[value="${res.theme_slug}"]`).attr('selected', true);
                            final_detail.theme = res.theme_slug
                        }

                        let custom_theme_wrapper = $('#custom-theme').parent();
                        custom_theme_wrapper.hide();
                        if (res.new_tenant)
                        {
                            custom_theme_wrapper.show();
                        }
                    }
                });
        });

        $(document).on('change', '#custom-theme', function () {
            theme_selected_first = true;
            final_detail.theme = $(this).val();
        });

        $(document).on('submit', '#user_add_subscription_form', function () {
            $(this).find('button[type=submit]').attr('disabled', true);
        });

        const customFormParent = $('.payment_gateway_extra_field_information_wrap');
        customFormParent.children().hide();

        $(document).on('click', '.payment_getway_image ul li', function () {
            let gateway = $(this).data('gateway');
            let manual_transaction_div = $('.manual_transaction_id');

            customFormParent.children().hide();
            if (gateway === 'manual_payment') {
                manual_transaction_div.removeClass('d-none');
            } else {
                manual_transaction_div.addClass('d-none');

                let wrapper = customFormParent.find('#'+gateway+'-parent-wrapper');
                if (wrapper.length > 0)
                {
                    wrapper.fadeIn();
                }
            }

            let gateway_name = $(this).data('gateway');
            $(this).addClass('selected').siblings().removeClass('selected');
            $('.payment-gateway-wrapper').find(('input')).val(gateway_name);
            $('.payment_gateway_passing_clicking_name').val(gateway_name);
            final_detail.payment_gateway = gateway;
        });

        $(document).on('change', 'select[name="package"]', function () {
            let el = $(this);
            let package_id = el.val();
            let package_name = el.find(':selected').text().trim();
            let subdomain = final_detail.subdomain;

            $.ajax({
                url: '<?php echo e(route('landlord.frontend.package.check')); ?>',
                type: 'POST',
                data: {
                    _token : '<?php echo e(csrf_token()); ?>',
                    package_id : package_id,
                    subdomain: subdomain
                },
                success: function (data) {
                    let payment_gateway_wrapper = $('.payment-gateway-wrapper');
                    let selected_payment_gateway = $('input[name="selected_payment_gateway"]');
                    let manual_transaction_id = $('.manual_transaction_id');

                    if(data.price <= 0)
                    {
                        payment_gateway_wrapper.hide();
                        if(selected_payment_gateway.val() === 'manual_payment')
                        {
                            manual_transaction_id.addClass('d-none');
                        }
                    } else {
                        payment_gateway_wrapper.slideDown();
                        if(selected_payment_gateway.val() === 'manual_payment')
                        {
                            manual_transaction_id.removeClass('d-none');
                        }
                    }

                    $('#custom-theme').html(data.theme_list);
                    final_detail.package_id = package_id;
                    final_detail.package_name = package_name;
                    final_detail.price = data.price;
                    final_detail.validity = data.validity;
                    final_detail.payment_gateway = selected_payment_gateway.val();

                    if (data.theme !== null)
                    {
                        final_detail.theme = data.theme;
                    }
                }
            });
        });

        const modal_id = '#final_result';
        $(document).on('click' ,'button[data-bs-target="'+modal_id+'"]', function () {
            if (final_detail.subdomain !== undefined && final_detail.package_id !== undefined)
            {
                if (final_detail.price > 0 && final_detail.payment_gateway === undefined)
                {
                    toastr.error(`<?php echo e(__('Please provide all the required information in the provided fields.')); ?>`);
                    return;
                }

                if (!final_detail.renew_status && final_detail.theme === undefined)
                {
                    toastr.error(`<?php echo e(__('Please provide all the required information in the provided fields.')); ?>`);
                    return;
                }
            } else {
                toastr.error(`<?php echo e(__('Please provide all the required information in the provided fields.')); ?>`);
                return;
            }



            const modal = $(modal_id).find('.modal-body');
            $('#user_add_subscription').modal('hide');
            $(modal_id).modal('show');

            modal.find('.confirm-details--title').text(final_detail.renew_status ? `<?php echo e(__('Renew Plan')); ?>` : `<?php echo e(__('New Purchase')); ?>`);
            modal.find('.shop_name').text(final_detail.subdomain);
            modal.find('.package_name').text(final_detail.package_name);
            modal.find('.theme').text(final_detail.theme);
            modal.find('.price').text(final_detail.price);
            modal.find('.validity').text(final_detail.validity);
            modal.find('.payment_gateway').text(final_detail.payment_gateway.replace('_',' '));
        });

        $(document).on('click', '#final-submit', () => {
            $('#user_add_subscription_form').submit();
        });

        $('.close-bars, .body-overlay').on('click', function () {
            $('.dashboard-close, .dashboard-close-main, .body-overlay').removeClass('active');
        });
        $('.sidebar-icon').on('click', function () {
            $('.dashboard-close, .dashboard-close-main, .body-overlay').addClass('active');
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('landlord.frontend.user.dashboard.user-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\nazmart\core\resources\views/landlord/frontend/user/dashboard/user-home.blade.php ENDPATH**/ ?>