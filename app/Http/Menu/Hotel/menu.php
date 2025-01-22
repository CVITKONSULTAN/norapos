<?php 
    Menu::create('admin-sidebar-hotel', function ($menu) {
            
            $enabled_modules = !empty(session('business.enabled_modules')) ? session('business.enabled_modules') : [];
            //Home
            $menu->url(action('HomeController@index'), __('home.home'), ['icon' => 'fa fas fa-tachometer-alt', 'active' => request()->segment(1) == 'home'])->order(5);

            //User management dropdown
            if (auth()->user()->can('user.view') || auth()->user()->can('user.create') || auth()->user()->can('roles.view')) {
                $menu->dropdown(
                    "Manajemen Pengguna",
                    function ($sub) {
                        if (auth()->user()->can('user.view')) {
                            $sub->url(
                                action('ManageUserController@index'),
                                __('user.users'),
                                ['icon' => 'fa fas fa-user', 'active' => request()->segment(1) == 'users']
                            );
                        }
                        if (auth()->user()->can('roles.view')) {
                            $sub->url(
                                action('RoleController@index'),
                                "Role",
                                ['icon' => 'fa fas fa-briefcase', 'active' => request()->segment(1) == 'roles']
                            );
                        }
                    },
                    ['icon' => 'fa fas fa-users']
                )->order(10);
            }

            //Contacts dropdown
            if (auth()->user()->can('supplier.view') || auth()->user()->can('customer.view')) {
                $menu->dropdown(
                    __('contact.contacts'),
                    function ($sub) {
                        if (auth()->user()->can('customer.view')) {
                            $sub->url(
                                action('ContactController@index', ['type' => 'customer']),
                                __('report.customer'),
                                ['icon' => 'fa fas fa-star', 'active' => request()->input('type') == 'customer']
                            );
                            $sub->url(
                                action('CustomerGroupController@index'),
                                __('lang_v1.customer_groups'),
                                ['icon' => 'fa fas fa-users', 'active' => request()->segment(1) == 'customer-group']
                            );
                        }
                    },
                    ['icon' => 'fa fas fa-address-book', 'id' => "tour_step4"]
                )->order(15);
            }

            //Absensi dropdown
            $menu->dropdown(
                "Absensi",
                function ($sub) {
                    if (auth()->user()->can('absensi.view_all')) {
                        $sub->url(
                            route('absensi.list.all'),
                            "Data Pertanggal",
                            ['active' => request()->is('absensi/list/all')]
                        );
                    }
                    if (auth()->user()->can('absensi.view') || auth()->user()->can('absensi.view_all')) {
                        $sub->url(
                            route('absensi.list'),
                            "Daftar Absensi",
                            ['icon' => 'fa fas fa-star', 'active' => request()->is('absensi/list')]
                        );
                    }
                    if (auth()->user()->can('absensi.create')) {
                        $sub->url(
                            route('absensi.create'),
                            "Tambah",
                            ['icon' => 'fa fas fa-star', 'active' => request()->is('absensi')]
                        );
                    }
                },
                ['icon' => 'fa fas fa-user']
            )->order(15);

            //Shift Log dropdown
            if( 
                auth()->user()->checkReceptionist() ||
                auth()->user()->checkAdmin() ||
                auth()->user()->checkHRD()
            ){
                $menu->dropdown(
                    "Shift Log",
                    function ($sub) {
                        $sub->url(
                            route('shift.index'),
                            "Daftar data",
                            [
                                'icon' => 'fa fas fa-list', 
                                'active' => 
                                    request()->segment(1) == 'log-shift-receptionist' && 
                                    request()->segment(2) == ''
                                ]
                        );
                    },
                    ['icon' => 'fa fa-clock']
                )->order(15);
            }

            
            if( auth()->user()->checkAdmin() ){
                
                //Reservasi
                $menu->dropdown(
                    "Reservasi",
                    function ($sub) {
                        $sub->url(
                            '/reservasi',
                            "Reservasi",
                            [
                                'icon' => 'fa fas fa-list', 
                                'active' => 
                                    request()->segment(1) == 'reservasi' && 
                                    request()->segment(2) == ''
                                ]
                        );
                    },
                    ['icon' => 'fa fa-list-alt', 'id' => 'tour_step5']
                )->order(20);

                //Card log
                $menu->dropdown(
                    "Card Log",
                    function ($sub) {
                        $sub->url(
                            '/card',
                            "Card Log",
                            [
                                'icon' => 'fa fas fa-list', 
                                'active' => 
                                    request()->segment(1) == 'card' && 
                                    request()->segment(2) == ''
                                ]
                        );
                    },
                    ['icon' => 'fa fa-credit-card', 'id' => 'tour_step5']
                )->order(20);

            }

            //Products dropdown
            if (
                auth()->user()->can('product.view') || auth()->user()->can('product.create') ||
                auth()->user()->can('brand.view') || auth()->user()->can('unit.view') ||
                auth()->user()->can('category.view') || auth()->user()->can('brand.create') ||
                auth()->user()->can('unit.create') || auth()->user()->can('category.create')
            ) {
                $menu->dropdown(
                    "Layanan & Fasilitas",
                    function ($sub) {
                        if (auth()->user()->can('product.view')) {
                            $sub->url(
                                action('ProductController@index'),
                                "Room",
                                ['icon' => 'fa fas fa-list', 'active' => request()->segment(1) == 'products' && request()->segment(2) == '']
                            );
                        }
                    },
                    ['icon' => 'fa fas fa-cubes', 'id' => 'tour_step5']
                )->order(20);
            }

            //Sell dropdown
            if (auth()->user()->can('sell.view') || auth()->user()->can('sell.create') || auth()->user()->can('direct_sell.access') ||  auth()->user()->can('view_own_sell_only')) {
                $menu->dropdown(
                    "Transaksi",
                    function ($sub) use ($enabled_modules) {
                        if (auth()->user()->can('direct_sell.access') ||  auth()->user()->can('view_own_sell_only')) {
                            $sub->url(
                                action('SellController@index'),
                                "Daftar Transaksi",
                                ['icon' => 'fa fas fa-list', 'active' => request()->segment(1) == 'sells' && request()->segment(2) == null]
                            );
                        }
                    },
                    ['icon' => 'fa fas fa-arrow-circle-up', 'id' => 'tour_step7']
                )->order(30);
            }

            //Expense dropdown
            if (in_array('expenses', $enabled_modules) && (auth()->user()->can('expense.access') || auth()->user()->can('view_own_expense'))) {
                $menu->dropdown(
                    "Pengeluaran",
                    function ($sub) {
                        $sub->url(
                            action('ExpenseController@index'),
                            "Daftar Pengeluaran",
                            ['icon' => 'fa fas fa-list', 'active' => request()->segment(1) == 'expenses' && request()->segment(2) == null]
                        );
                        $sub->url(
                            action('ExpenseController@create'),
                            "Tambah Pengeluaran",
                            ['icon' => 'fa fas fa-plus-circle', 'active' => request()->segment(1) == 'expenses' && request()->segment(2) == 'create']
                        );
                        $sub->url(
                            action('ExpenseCategoryController@index'),
                            "Kategori Pengeluaran",
                            ['icon' => 'fa fas fa-circle', 'active' => request()->segment(1) == 'expense-categories']
                        );
                    },
                    ['icon' => 'fa fas fa-minus-circle']
                )->order(45);
            }

            //Reports dropdown
            if (auth()->user()->can('purchase_n_sell_report.view') || auth()->user()->can('contacts_report.view')
                || auth()->user()->can('stock_report.view') || auth()->user()->can('tax_report.view')
                || auth()->user()->can('trending_product_report.view') || auth()->user()->can('sales_representative.view') || auth()->user()->can('register_report.view')
                || auth()->user()->can('expense_report.view')) {
                $menu->dropdown(
                    "Laporan Transaksi",
                    function ($sub) use ($enabled_modules) {
                        if (auth()->user()->can('profit_loss_report.view')) {
                            $sub->url(
                                action('ReportController@getProfitLoss'),
                                __('report.profit_loss'),
                                ['icon' => 'fa fas fa-file-invoice-dollar', 'active' => request()->segment(2) == 'profit-loss']
                            );
                        }
                        

                        if (auth()->user()->can('purchase_n_sell_report.view')) {
                            

                            $sub->url(
                                action('ReportController@getproductSellReport'),
                                "Laporan Transaksi",
                                ['icon' => 'fa fas fa-arrow-circle-up', 'active' => request()->segment(2) == 'product-sell-report']
                            );

                        }
                        if (in_array('expenses', $enabled_modules) && auth()->user()->can('expense_report.view')) {
                            $sub->url(
                                action('ReportController@getExpenseReport'),
                                "Laporan Catatan Pengeluaran",
                                ['icon' => 'fa fas fa-search-minus', 'active' => request()->segment(2) == 'expense-report']
                            );
                        }
                    },
                    ['icon' => 'fa fas fa-chart-bar', 'id' => 'tour_step8']
                )->order(55);
            }

            //Settings Dropdown
            if (auth()->user()->can('business_settings.access') ||
                auth()->user()->can('barcode_settings.access') ||
                auth()->user()->can('invoice_settings.access') ||
                auth()->user()->can('tax_rate.view') ||
                auth()->user()->can('tax_rate.create') ||
                auth()->user()->can('access_package_subscriptions')) {
                $menu->dropdown(
                    __('business.settings'),
                    function ($sub) use ($enabled_modules) {
                        if (auth()->user()->can('business_settings.access')) {
                            $sub->url(
                                action('BusinessController@getBusinessSettings'),
                                __('business.business_settings'),
                                ['icon' => 'fa fas fa-cogs', 'active' => request()->segment(1) == 'business', 'id' => "tour_step2"]
                            );
                            $sub->url(
                                action('BusinessLocationController@index'),
                                __('business.business_locations'),
                                ['icon' => 'fa fas fa-map-marker', 'active' => request()->segment(1) == 'business-location']
                            );
                        }
                        if (auth()->user()->can('invoice_settings.access')) {
                            $sub->url(
                                action('InvoiceSchemeController@index'),
                                __('invoice.invoice_settings'),
                                ['icon' => 'fa fas fa-file', 'active' => in_array(request()->segment(1), ['invoice-schemes', 'invoice-layouts'])]
                            );
                        }
                        if (auth()->user()->can('barcode_settings.access')) {
                            $sub->url(
                                action('BarcodeController@index'),
                                __('barcode.barcode_settings'),
                                ['icon' => 'fa fas fa-barcode', 'active' => request()->segment(1) == 'barcodes']
                            );
                        }
                        if (auth()->user()->can('access_printers')) {
                            $sub->url(
                                action('PrinterController@index'),
                                __('printer.receipt_printers'),
                                ['icon' => 'fa fas fa-share-alt', 'active' => request()->segment(1) == 'printers']
                            );
                        }

                        if (auth()->user()->can('tax_rate.view') || auth()->user()->can('tax_rate.create')) {
                            $sub->url(
                                action('TaxRateController@index'),
                                __('tax_rate.tax_rates'),
                                ['icon' => 'fa fas fa-bolt', 'active' => request()->segment(1) == 'tax-rates']
                            );
                        }

                        if (in_array('tables', $enabled_modules) && auth()->user()->can('access_tables')) {
                            $sub->url(
                                action('Restaurant\TableController@index'),
                                __('restaurant.tables'),
                                ['icon' => 'fa fas fa-table', 'active' => request()->segment(1) == 'modules' && request()->segment(2) == 'tables']
                            );
                        }

                        if (in_array('modifiers', $enabled_modules) && (auth()->user()->can('product.view') || auth()->user()->can('product.create'))) {
                            $sub->url(
                                action('Restaurant\ModifierSetsController@index'),
                                __('restaurant.modifiers'),
                                ['icon' => 'fa fas fa-pizza-slice', 'active' => request()->segment(1) == 'modules' && request()->segment(2) == 'modifiers']
                            );
                        }

                        if (in_array('types_of_service', $enabled_modules) && auth()->user()->can('access_types_of_service')) {
                            $sub->url(
                                action('TypesOfServiceController@index'),
                                __('lang_v1.types_of_service'),
                                ['icon' => 'fa fas fa-user-circle', 'active' => request()->segment(1) == 'types-of-service']
                            );
                        }
                    },
                    ['icon' => 'fa fas fa-cog', 'id' => 'tour_step3']
                )->order(85);
            }
    });
?>