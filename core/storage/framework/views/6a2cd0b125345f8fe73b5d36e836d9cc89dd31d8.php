
 <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <title><?php echo e(__('Payment Success For')); ?> <?php echo e(get_static_option('site_title')); ?></title>
    <style>
        *{
            font-family: 'Montserrat', sans-serif;
        }
        body {
            background-color: #fdfdfd;
        }
        .mail-container {
            max-width: 650px;
            margin: 50px auto;
            text-align: center;
        }

        .mail-container .logo-wrapper {
            padding: 20px 0 20px;
            border-bottom: 5px solid <?php echo e(get_static_option('site_color')); ?>;
        }
        table {
            margin: 0 auto;
        }
        table {

            border-collapse: collapse;
            width: 100%;
        }

        table td, table th {
            border: 1px solid rgba(0,0,0,.05);
            padding: 10px 20px;
            background-color: #fafafa;
            text-align: left;
            font-size: 14px;
        }

        table tr:nth-child(even){background-color: #f2f2f2;}

        table tr:hover {background-color: #ddd;}

        table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: <?php echo e(get_static_option('site_color')); ?>;
            color: white;
        }
        footer {
            margin: 20px 0;
            font-size: 14px;
        }
        .main-content-wrap {
            background-color: #fff;
            box-shadow: 0 0 15px 0 rgba(0,0,0,.05);
            padding: 30px;
        }

        .main-content-wrap p {
            margin: 0;
            text-align: left;
            font-size: 14px;
            line-height: 26px;
        }

        .main-content-wrap p:first-child {
            margin-bottom: 10px;
        }

        .main-content-wrap .price-wrap {
            font-size: 60px;
            line-height: 70px;
            font-weight: 600;
            margin: 40px 0;
        }
        table {
            margin-bottom: 30px;
        }
        .logo-wrapper img{
            max-width: 200px;
        }

        .renew_heading{
            font-size: 20px;
        }
    </style>
</head>
<body>
<div class="mail-container">
    <div class="logo-wrapper">
        <a href="<?php echo e(url('/')); ?>">

            <h4><?php echo e(get_static_option('site_title')); ?></h4>
        </a>
    </div>
    <div class="main-content-wrap">
        <p><?php echo e(__('Hello')); ?></p>

        <?php if($user_type == 'user'): ?>
            <?php if(!is_null($package->renew_status)): ?>
                <p class="renew_heading"><strong><?php echo e(__('Package Renewed')); ?> <?php echo e($package->name ?? ''); ?> <?php echo e(__('was successful. Package ID')); ?> #<?php echo e($package->id); ?></strong> </p>
            <?php endif; ?>
            <p><?php echo e(__('A payment from')); ?> <?php echo e($package->name); ?> <?php echo e(__('was successful. Package ID')); ?> #<?php echo e($package->id); ?> ,<?php echo e(__('package Name')); ?> "<?php echo e($package->package_name ?? ''); ?>" <?php echo e(__('Paid Via')); ?> <?php echo e(ucfirst(str_replace('_',' ',$package->package_gateway))); ?></p>
        <?php endif; ?>

        <?php if($user_type == 'admin'): ?>
            <?php if(!is_null($package->renew_status)): ?>
                <p class="renew_heading"> <strong><?php echo e(__('Package Renewed')); ?><?php echo e($package->name ?? ''); ?> <?php echo e(__('was successful. Package ID')); ?> #<?php echo e($package->id); ?></strong>  </p>
            <?php endif; ?>
            <p><?php echo e(__('You get payment from')); ?> <?php echo e($package->name); ?> <?php echo e(__('For Package ID') .'#'); ?> <?php echo e($package->id); ?>, <?php echo e(__('package Name')); ?> <?php echo e('"'.$package->package_name ?? ''.'"'); ?> <?php echo e(__('paid via')); ?> <?php echo e(ucfirst(str_replace('_',' ',$package->package_gateway))); ?></p>
        <?php endif; ?>


        <?php if($extra == 'custom_sub'): ?>
           <h4 class="renew_heading"> <strong><?php echo e(__('You have been assinged a subscription please complete your payment (Please contact to the administrator)')); ?> </strong></h4>
        <?php endif; ?>


        <div class="price-wrap"><?php echo e(amount_with_currency_symbol($package->package_price)); ?></div>
        <table>

            <tr>
                <td><strong><?php echo e(__('Package Name')); ?></strong></td>
                <td><?php echo e($package->package_name); ?></td>
            </tr>

            <tr>
                <td><strong><?php echo e(__('Amount')); ?></strong></td>
                <td><?php echo e(amount_with_currency_symbol($package->package_price)); ?></td>
            </tr>

            <?php if(!empty($package->start_date) && !empty($package->expire_date)): ?>
                <tr>
                    <td><strong><?php echo e(__('Package Start Date :')); ?></strong></td>
                    <td><?php echo e($package->start_date ?? ''); ?></td>
                </tr>
                <tr>
                    <td><strong><?php echo e(__('Package Expire Date :')); ?></strong></td>
                    <td><?php echo e($package->expire_date?->format('d-m-Y H:m:s') ?? ''); ?></td>
                </tr>
            <?php endif; ?>

            <?php if($user_type == 'user'): ?>

                <tr>
                    <td><strong><?php echo e(__('Your Name :')); ?></strong></td>
                    <td><?php echo e(optional($package->user)->name ?? ''); ?></td>
                </tr>


                <tr>
                    <td><strong><?php echo e(__('Email :')); ?></strong></td>
                    <td><?php echo e(optional($package->user)->email ?? ''); ?></td>
                </tr>

                <tr>
                    <td><strong><?php echo e(__('Your Country :')); ?></strong></td>
                    <td><?php echo e(optional($package->user)->country); ?></td>
                </tr>

                <tr>
                    <td><strong><?php echo e(__('Your Domain :')); ?></strong></td>
                    <td><?php echo e($package->tenant_id .'.'. current(config('tenancy.central_domains'))); ?></td>
                </tr>

                <tr>
                    <td><strong><?php echo e(__('Your Site Url :')); ?></strong></td>
                    <td>
                        <a href="<?php echo e(tenant_url_with_protocol($package->tenant_id .'.'. current(config('tenancy.central_domains')) ?? '' )); ?>" target="_blank">
                            <?php echo e(__('Click to visit your site')); ?>

                        </a>
                    </td>
                </tr>

                <tr>
                    <td><strong><?php echo e(__('Your Site Admin Panel URL :')); ?></strong></td>
                    <td>
                        <a href="<?php echo e(tenant_url_with_protocol($package->tenant_id .'.'. current(config('tenancy.central_domains')) .'/admin' ?? '' )); ?>" target="_blank">
                            <?php echo e(__('Click to visit your site admin panel')); ?>

                        </a>
                    </td>
                </tr>
            <?php endif; ?>

        </table>
    </div>
    <footer>
        <?php echo get_footer_copyright_text(); ?>

    </footer>
</div>
</body>
</html>

<?php /**PATH C:\laragon\www\nazmart\core\resources\views/emails/order.blade.php ENDPATH**/ ?>