@component('mail::message')
    # Link Visits Report

    @component('mail::table')
        | Link Name  | Total Visitors  |
        | :--------- | :------------- |
        @foreach ($user->links as $link)
            | {{ $link->title }} | {{ $link->total_visitors }} |
        @endforeach
    @endcomponent

    Thanks,
    {{ config('app.name') }}
@endcomponent
