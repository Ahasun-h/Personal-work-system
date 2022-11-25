<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <img class="sidebar-brand-full" width="118" height="46" alt="Dashboard Logo" src="{{ asset('dashboard/image/logo_full.png') }}">
        <img class="sidebar-brand-narrow" width="46" height="46" alt="Dashboard Logo" src="{{ asset('dashboard/image/logo.png') }}">
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">
                <span class="nav-icon lnr lnr-home"></span>
                Dashboard

            </a>
        </li>

        <li class="nav-title">Accounts</li>
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="javascript:void(0)">
                <i class='nav-icon bx bx-calculator'></i>
                Account Setting
            </a>
            <ul class="nav-group-items">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('bank.index') }}" target="_top">
                        <i class="nav-icon bx bx-minus"></i>
                        Bank
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('branch.index') }}" target="_top">
                        <i class="nav-icon bx bx-minus"></i>
                        Brnach
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('account.index') }}" target="_top">
                        <i class="nav-icon bx bx-minus"></i>
                        Account
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="javascript:void(0)">
                <i class='nav-icon bx bx-dollar'></i>
                Transaction
            </a>
            <ul class="nav-group-items">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('expense-or-withdraw.index') }}">
                        <i class="nav-icon bx bx-minus"></i>
                        Expense | Withdraw
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('income-or-deposit.index') }}">
                        <i class="nav-icon bx bx-minus"></i>
                        Income | Deposit
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('fund-transfer.index') }}">
                        <i class="nav-icon bx bx-minus"></i>
                        Fund Transfer
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('account.balance-sheet') }}">
                <i class='nav-icon bx bx-line-chart'></i>
                Balance Sheet
            </a>
        </li>
        <li class="nav-title">Setting</li>


        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="{{ route('setting') }}">
                <i class='nav-icon bx bx-cog'></i>
                setting
            </a>
        </li>



        {{--<li class="nav-title">Extras</li>--}}
        {{--<li class="nav-group">--}}
            {{--<a class="nav-link nav-group-toggle" href="#">--}}
                {{--<svg class="nav-icon">--}}
                    {{--<use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-star"></use>--}}
                {{--</svg>--}}
                {{--Pages--}}
            {{--</a>--}}
            {{--<ul class="nav-group-items">--}}
                {{--<li class="nav-item"><a class="nav-link" href="login.html" target="_top">--}}
                        {{--<svg class="nav-icon">--}}
                            {{--<use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-account-logout"></use>--}}
                        {{--</svg>--}}
                        {{--Login--}}
                    {{--</a>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</li>--}}
    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
