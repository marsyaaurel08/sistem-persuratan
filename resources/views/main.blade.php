@extends('layout.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row g-2">
        <!-- Card 1 -->
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6">
            <div class="card stretch stretch-full p-2">
                <div class="card-body p-2">
                    <div class="d-flex align-items-start justify-content-between mb-2">
                        <div class="d-flex gap-2 align-items-center">
                            <div class="avatar-text avatar-sm bg-gray-200">
                                <i class="feather-dollar-sign"></i>
                            </div>
                            <div>
                                <div class="fs-6 fw-bold text-dark"><span class="counter">45</span>/<span
                                        class="counter">76</span></div>
                                <h3 class="fs-12 fw-semibold text-truncate-1-line">Invoices Awaiting Payment</h3>
                            </div>
                        </div>
                        <a href="javascript:void(0);"><i class="feather-more-vertical"></i></a>
                    </div>
                    <div class="pt-1">
                        <div class="d-flex align-items-center justify-content-between">
                            <a href="javascript:void(0);"
                                class="fs-11 fw-medium text-muted text-truncate-1-line">Invoices</a>
                            <div class="text-end">
                                <span class="fs-12 text-dark">$5,569</span>
                                <span class="fs-10 text-muted">(56%)</span>
                            </div>
                        </div>
                        <div class="progress mt-1 ht-2">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 56%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6">
            <div class="card stretch stretch-full p-2">
                <div class="card-body p-2">
                    <div class="d-flex align-items-start justify-content-between mb-2">
                        <div class="d-flex gap-2 align-items-center">
                            <div class="avatar-text avatar-sm bg-gray-200">
                                <i class="feather-cast"></i>
                            </div>
                            <div>
                                <div class="fs-6 fw-bold text-dark"><span class="counter">48</span>/<span
                                        class="counter">86</span></div>
                                <h3 class="fs-12 fw-semibold text-truncate-1-line">Converted Leads</h3>
                            </div>
                        </div>
                        <a href="javascript:void(0);"><i class="feather-more-vertical"></i></a>
                    </div>
                    <div class="pt-1">
                        <div class="d-flex align-items-center justify-content-between">
                            <a href="javascript:void(0);" class="fs-11 fw-medium text-muted text-truncate-1-line">Converted
                                Leads</a>
                            <div class="text-end">
                                <span class="fs-12 text-dark">52 Completed</span>
                                <span class="fs-10 text-muted">(63%)</span>
                            </div>
                        </div>
                        <div class="progress mt-1 ht-2">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 63%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6">
            <div class="card stretch stretch-full p-2">
                <div class="card-body p-2">
                    <div class="d-flex align-items-start justify-content-between mb-2">
                        <div class="d-flex gap-2 align-items-center">
                            <div class="avatar-text avatar-sm bg-gray-200">
                                <i class="feather-users"></i>
                            </div>
                            <div>
                                <div class="fs-6 fw-bold text-dark"><span class="counter">32</span>/<span
                                        class="counter">50</span></div>
                                <h3 class="fs-12 fw-semibold text-truncate-1-line">New Customers</h3>
                            </div>
                        </div>
                        <a href="javascript:void(0);"><i class="feather-more-vertical"></i></a>
                    </div>
                    <div class="pt-1">
                        <div class="d-flex align-items-center justify-content-between">
                            <a href="javascript:void(0);" class="fs-11 fw-medium text-muted text-truncate-1-line">New
                                Customers</a>
                            <div class="text-end">
                                <span class="fs-12 text-dark">32</span>
                                <span class="fs-10 text-muted">(64%)</span>
                            </div>
                        </div>
                        <div class="progress mt-1 ht-2">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 64%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6">
            <div class="card stretch stretch-full p-2">
                <div class="card-body p-2">
                    <div class="d-flex align-items-start justify-content-between mb-2">
                        <div class="d-flex gap-2 align-items-center">
                            <div class="avatar-text avatar-sm bg-gray-200">
                                <i class="feather-shopping-cart"></i>
                            </div>
                            <div>
                                <div class="fs-6 fw-bold text-dark"><span class="counter">28</span>/<span
                                        class="counter">40</span></div>
                                <h3 class="fs-12 fw-semibold text-truncate-1-line">Orders Pending</h3>
                            </div>
                        </div>
                        <a href="javascript:void(0);"><i class="feather-more-vertical"></i></a>
                    </div>
                    <div class="pt-1">
                        <div class="d-flex align-items-center justify-content-between">
                            <a href="javascript:void(0);" class="fs-11 fw-medium text-muted text-truncate-1-line">Orders
                                Pending</a>
                            <div class="text-end">
                                <span class="fs-12 text-dark">28</span>
                                <span class="fs-10 text-muted">(70%)</span>
                            </div>
                        </div>
                        <div class="progress mt-1 ht-2">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 70%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection