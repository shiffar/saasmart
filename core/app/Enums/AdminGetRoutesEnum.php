<?php

namespace App\Enums;

enum AdminGetRoutesEnum
{
    public static function landlordAdminRoutes():  array
    {
        return [
            'landlord.admin.home' => 'dashboard',
            'landlord.admin.health' => 'site health',
            'landlord.admin.change.password' => 'change password',
            'landlord.admin.pages' => 'all pages',
            'landlord.admin.pages.create' => 'create page',
            'landlord.admin.theme' => 'all theme',
            'landlord.admin.theme.settings' => 'theme settings',
            'landlord.admin.price.plan' => 'all price plan',
            'landlord.admin.price.plan.create' => 'create price plan',
            'landlord.admin.price.plan.settings' => 'price plan settings',
            'landlord.admin.tenant.website.issues' => 'website issues',
            'landlord.admin.support.ticket.all' => 'all tickets',
            'landlord.admin.support.ticket.new' => 'new ticket',
            'landlord.admin.support.ticket.page.settings' => 'page settings',
            'landlord.admin.support.ticket.department' => 'ticket department',
            'landlord.admin.testimonial' => 'testimonial',
            'landlord.admin.brands' => 'brands',
            'landlord.admin.contact.message.all' => 'all messages',
            'landlord.admin.widgets' => 'widgets',
            'landlord.admin.highlight' => 'highlight settings',
            'landlord.admin.breadcrumb' => 'breadcrumb settings',
            'landlord.admin.form.builder.all' => 'all forms',
            'landlord.admin.form.builder.contact' => 'contact form index',
            'landlord.admin.topbar.settings' => 'topbar settings',
            'landlord.admin.menu' => 'menu builder',
            'landlord.admin.all.user' => 'all user',
            'landlord.admin.new.user' => 'new user',
            'landlord.admin.all.admin.role' => 'all admin role',
            'landlord.admin.role.new' => 'new admin role index',
            'landlord.admin.tenant' => 'all tenants',
            'landlord.admin.tenant.all' => 'all tenants list',
            'landlord.admin.tenant.new' => 'new tenant',
            'landlord.admin.tenant.settings' => 'account settings',
            'landlord.admin.tenant.failed.index' => 'failed tenants',
            'landlord.admin.package.order.manage.all' => 'all orders',
            'landlord.admin.package.order.success.page' => 'order success payment',
            'landlord.admin.package.order.cancel.page' => 'order cancel payment',
            'landlord.admin.package.order.page' => 'order page',
            'landlord.admin.package.order.report' => 'order report',
            'landlord.admin.payment.logs' => 'all payment logs',
            'landlord.admin.payment.report' => 'payment report',
            'landlord.admin.invoice.settings' => 'invoice settings',
            'landlord.admin.custom.domain.requests.all.pending' => 'all pending custom domain requests',
            'landlord.admin.custom.domain.requests.all' => 'all custom domain requests',
            'landlord.admin.custom.domain.requests.settings' => 'custom domain settings',
            'landlord.admin.general.basic.settings' => 'basic settings',
            'landlord.admin.general.page.settings' => 'page settings',
            'landlord.admin.general.site.identity' => 'site identity',
            'landlord.admin.general.color.settings' => 'color settings',
            'landlord.admin.general.typography.settings' => 'typography settings',
            'landlord.admin.general.seo.settings' => 'seo settings',
            'landlord.admin.general.gdpr.settings' => 'gdpr settings',
            'landlord.admin.general.payment.settings' => 'payment settings',
            'landlord.admin.general.third.party.script.settings' => 'third party script settings',
            'landlord.admin.general.smtp.settings' => 'smtp settings',
            'landlord.admin.general.ssl.settings' => 'ssl settings',
            'landlord.admin.general.custom.css.settings' => 'custom css settings',
            'landlord.admin.general.custom.js.settings' => 'custom js settings',
            'landlord.admin.general.database.upgrade.settings' => 'database upgrade',
            'landlord.admin.general.cache.settings' => 'cache settings',
            'landlord.admin.general.license.settings' => 'license settings',
            'landlord.admin.general.software.update.settings' => 'software update check settings',
            'landlord.admin.payment.settings.paypal' => 'paypal settings',
            'landlord.admin.payment.settings.paytm' => 'paytm settings',
            'landlord.admin.payment.settings.stripe' => 'stripe settings',
            'landlord.admin.payment.settings.razorpay' => 'razorpay settings',
            'landlord.admin.payment.settings.paystack' => 'paystack settings',
            'landlord.admin.payment.settings.mollie' => 'mollie settings',
            'landlord.admin.payment.settings.midtrans' => 'midtrans settings',
            'landlord.admin.payment.settings.cashfree' => 'cashfree settings',
            'landlord.admin.payment.settings.instamojo' => 'instamojo settings',
            'landlord.admin.payment.settings.marcadopago' => 'marcadopago settings',
            'landlord.admin.payment.settings.zitopay' => 'zitopay settings',
            'landlord.admin.payment.settings.squareup' => 'squareup settings',
            'landlord.admin.payment.settings.cinetpay' => 'cinetpay settings',
            'landlord.admin.payment.settings.paytabs' => 'paytabs settings',
            'landlord.admin.payment.settings.billplz' => 'billplz settings',
            'landlord.admin.payment.settings.toyyibpay' => 'toyyibpay settings',
            'landlord.admin.payment.settings.flutterwave' => 'flutterwave settings',
            'landlord.admin.payment.settings.payfast' => 'payfast settings',
            'landlord.admin.payment.settings.manual_payment' => 'manual payment settings',
            'landlord.admin.payment.settings.cod' => 'cod settings',
            'landlord.admin.languages' => 'languages',
            'landlord.admin.404.page.settings' => 'error 404 page settings',
            'landlord.admin.maintains.page.settings' => 'maintains page settings',
            'landlord.admin.blog' => 'all blogs',
            'landlord.admin.blog.new' => 'new blog',
            'landlord.admin.blog.settings' => 'blog settings',
            'landlord.admin.blog.category' => 'blog category',
        ];
    }
}
