@props(['items'])

<table class="table-auto shadow-lg bg-white my-4">
    <thead>
    <tr>
        @if(Auth::user())
            <th class="bg-blue-100 border text-left px-8 py-4">User</th>
        @endif
        <th class="bg-blue-100 border text-left px-8 py-4">Original Url</th>
        <th class="bg-blue-100 border text-left px-8 py-4">Shortened Url</th>
        <th class="bg-blue-100 border text-left px-8 py-4">Clicks</th>
    </tr>
    </thead>


    <tbody>

    @foreach($items as $item)
        <tr>
            @if(Auth::user())
                <td class="border px-8 py-4">{{$item->user->email}}</td>
            @endif
            <td class="border px-8 py-4">
                <a href="{{route('urls.show', ['url'=>$item])}}">{{$item->original_url}} </a></td>
            <td class="border px-8 py-4"><a href="/{{$item->shortened_url}}">{{$item->shortened_url}}</a></td>
            <td class="border px-8 py-4">{{count($item->clicks)}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
