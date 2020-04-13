@component('mail::message')
# Invoice Paid

Thanks for the purchase.

Here is your receipt

<table class="table table-striped table-inverse table-responsive">
    <thead class="thead-inverse">
        <tr>
            <th>Product name</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
        </thead>
        <tbody>
            
            @foreach ($order->items as $item)
                <tr>
                    <td scope="row">{{$item->name}}</td>
                    <td>{{$item->quantity}}</td>
                    <td>{{$item->price}}</td>
                </tr>
            @endforeach

        </tbody>
</table>

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
