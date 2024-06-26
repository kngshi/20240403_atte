<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Atte</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/user-attendance.css') }}" />
</head>

<body>
<header class="header">
    <div class="header__inner">
      <a class="header__logo" href="/">
        Atte
      </a>
    <nav>
        <ul class="header-nav">
            <li class="header-nav__item">
                <a class="header-nav__link" href="/user-index">ユーザー 一覧</a>
            </li>
            <li class="header-nav__item">
                <a class="header-nav__link" href="/user-attendance">ユーザー別 勤怠一覧</a>
            </li>
            <div class="mt-3_space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                <x-responsive-nav-link :href="route('logout')"
                    onclick="event.preventDefault();
                                this.closest('form').submit();"
                    class="header-nav__link text-black !important underline-none !important" >
                    {{ __('ログアウト') }}
                </x-responsive-nav-link>
                </form>
            </div>
        </ul>
    </nav>
    </div>
</header>
<main>
    <div class="contact-form__content">
        <div class="contact-form__heading">
        @if ($previousDate)
        <a href="{{ route('attendance', ['date' => $previousDate]) }}" class="date-tag">&lt; </a>
        @endif
        <span class="currentDate">{{$currentDate}}</span>
        @if ($nextDate)
        <a href="{{ route('attendance', ['date' => $nextDate]) }}" class="date-tag">&gt;</a>
        @endif
    </div>

    <table class="admin__table">
        <tr class="admin__row">
            <th class="admin__label">名前</th>
            <th class="admin__label">勤務開始</th>
            <th class="admin__label">勤務終了</th>
            <th class="admin__label">休憩時間</th>
            <th class="admin__label">勤務時間</th>
        </tr>
        @foreach($times as $time)
        <tr class="admin__row">
            <td class="admin__data">{{Auth::user()->name}}</td>
            <td class="admin__data">{{$time->work_start}}</td>
            <td class="admin__data">{{$time->work_end}}</td>
            <td class="admin__data">{{$time->restFormattedDiff}}</td>
            <td class="admin__data">{{$time->workFormattedDiff}}</td>
        </tr>
        @endforeach
    </table>
    {{ $times->links('vendor.pagination.default', ['date' => $currentDate]) }}
    </div>
</main>
<footer>
    <small>Atte,inc.</small>
</footer>
</body>

<style>
    .pagination {
        display: flex;
        margin-top: 10px;
        text-align: center; 
    }
</style>

</html>