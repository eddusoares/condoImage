@php
    $subscribe = isSubscribe(auth()->user()->id);
    $imageCount = auth()->user()->image_count;
@endphp
@extends($activeTemplate . 'layouts.master')

@push('style')
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue . 'css/override-dashboard.css') }}">
@endpush
@section('content')
    <!-- Start Dashboard -->
    <div class="body-wrapper">


        <div class="table-content">
            <div class="row gy-4 mb-3 align-items-center">
                <div class="col-lg-12">
                    @if (auth()->user()->user_type == 2 && auth()->user()->kv == 0)
                        <div class="alert alert-warning radius--20">
                            <div class="kyc-noty d-flex justify-content-between align-items-center" role="alert">
                                <h5 class="alert-heading mb-0">@lang('KYC Verification required')</h5>
                                <hr>
                                <p class="mb-0">
                                    <a href="{{ route('user.kyc.form') }}" class="btn button btn--md ">
                                        @lang('Click Here to Verify')</a>
                                </p>
                            </div>
                        </div>
                    @elseif(auth()->user()->user_type == 2 && auth()->user()->kv == 2)
                        <div class="alert alert-warning radius--20">
                            <div class="kyc-noty kyc-noty-pending d-flex justify-content-between align-items-center"
                                role="alert">
                                <h5 class="alert-heading mb-0">@lang('KYC Verification pending')</h5>
                                <hr>
                                <p class="mb-0"> <a href="{{ route('user.kyc.data') }}"
                                        class="btn button btn--md ">@lang('See KYC Data')</a></p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                <div class="dash-card">
                    <a href="#" class="d-flex justify-content-between">
                        <div>
                            <div class="title">
                                <p>@lang('Balance')</p>
                            </div>
                            <div class="content">
                                <span class="text-uppercase">{{ $general->cur_sym }}{{ showAmount($mainBalance) }}</span>
                            </div>

                        </div>
                        <div class="icon1">
                            <i class="fas fa-wallet"></i>
                        </div>
                    </a>
                </div>
            </div>


            @if (auth()->user()->user_type == 2)
                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                    <div class="dash-card">
                        <a href="#" class="d-flex justify-content-between">
                            <div>
                                <div class="title">
                                    <p>@lang('Withdrawals')</p>
                                </div>
                                <div class="content">
                                    <span
                                        class="text-uppercase">{{ $general->cur_sym }}{{ showAmount($totalWithdrawals) }}</span>
                                </div>

                            </div>
                            <div class="icon1">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </a>
                    </div>
                </div>

                       <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                <div class="dash-card">
                    <a href="#" class="d-flex justify-content-between">
                        <div>
                            <div class="title">
                                <p>@lang('Pending Withdrawals Count')</p>
                            </div>
                            <div class="content">
                                <span class="text-uppercase">{{ $pendingWithdrawalsCount }}</span>
                            </div>

                        </div>
                        <div class="icon1">
                            <i class="far fa-pause-circle"></i>
                        </div>
                    </a>
                </div>
            </div>
            @else
                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                    <div class="dash-card">
                        <a href="#" class="d-flex justify-content-between">
                            <div>
                                <div class="title">
                                    <p>@lang('Deposits')</p>
                                </div>
                                <div class="content">
                                    <span
                                        class="text-uppercase">{{ $general->cur_sym }}{{ showAmount($totalDeposits) }}</span>
                                </div>

                            </div>
                            <div class="icon1">
                                <i class="fas fa-money-bill"></i>
                            </div>
                        </a>
                    </div>
                </div>

                  <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                    <div class="dash-card">
                        <a href="#" class="d-flex justify-content-between">
                            <div>
                                <div class="title">
                                    <p>@lang('Pending Deposits Count')</p>
                                </div>
                                <div class="content">
                                    <span class="text-uppercase">{{ $pendingDepositsCount }}</span>
                                </div>

                            </div>
                            <div class="icon1">
                                <i class="fas fa-pause-circle"></i>
                            </div>
                        </a>
                    </div>
                </div>
            @endif
          

     

            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                <div class="dash-card">
                    <a href="#" class="d-flex justify-content-between">
                        <div>
                            <div class="title">
                                <p>@lang('Total Building')</p>
                            </div>
                            <div class="content">
                                <span class="text-uppercase">{{ $totalBuildings }}</span>
                            </div>

                        </div>
                        <div class="icon1">
                            <i class="fas fa-city"></i>
                        </div>
                    </a>
                </div>
            </div>

        </div>

        <div class="row pe-0">
            @if (auth()->user()->user_type == 2)
                <div class="col-xl-12 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">@lang('Withdrawals Report') @lang('(This year)')</h5>
                            <div id="withdraw-chart"></div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-xl-12 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">@lang('Deposit Report') @lang('(This year)')</h5>
                            <div id="deposit-chart"></div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    </div>
    <!-- End Dashboard -->
@endsection

@push('script-lib')
    <!-- apexcharts js -->
    <script src="{{ asset($activeTemplateTrue . 'js/apexcharts.min.js') }}"></script>
    <!-- wow js -->
    <script src="{{ asset($activeTemplateTrue . 'js/wow.min.js') }}"></script>
@endpush

@push('script')
    <script src="{{ asset('assets/admin/js/apexcharts.min.js') }}"></script>
    @if (auth()->user()->user_type == 2)
        <script>
            "use strict";

            // [ withdraw-chart ] start
            (function() {
                var options = {
                    series: [{
                        name: "Withdrawals Count",
                        data: @json($withdrawalsChart['values'])
                    }],
                    chart: {
                        height: '310px',
                        type: 'area',
                        zoom: {
                            enabled: false
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    colors: ['#00adad'],
                    labels: @json($withdrawalsChart['labels']),
                    xaxis: {
                        type: 'date',
                    },
                    yaxis: {
                        opposite: true
                    },
                    legend: {
                        horizontalAlign: 'left'
                    }
                };

                var chart = new ApexCharts(document.querySelector("#withdraw-chart"), options);
                chart.render();
            })();
        </script>
    @else
        <script>
            // [ deposit-chart ] start
            (function() {
                var options = {
                    series: [{
                        name: "Deposits Count",
                        data: @json($depositsChart['values'])
                    }],
                    chart: {
                        height: '310px',
                        type: 'area',
                        zoom: {
                            enabled: false
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    colors: ['#00adad'],
                    labels: @json($depositsChart['labels']),
                    xaxis: {
                        type: 'date',
                    },
                    yaxis: {
                        opposite: true
                    },
                    legend: {
                        horizontalAlign: 'left'
                    }
                };

                var chart = new ApexCharts(document.querySelector("#deposit-chart"), options);
                chart.render();
            })();
        </script>
    @endif


@endpush
