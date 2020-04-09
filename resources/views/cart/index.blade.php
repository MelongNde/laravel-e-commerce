@extends('layouts.app')
@section('content')
    <h2>Your cart</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ( $cartItems as $item)
                    <tr>
                    <td scope='row'>{{$item->name}}</td>
                        <td>
                            {{-- {{$item->price}} --}}

                            {{Cart::session(auth()->id())->get($item->id)->getPriceSum()}}
                        </td>
                        <td>
                        <form action="{{route('cart.update', $item->id)}}">
                                <input name="quantity" class="" type="number" value="{{$item->quantity}}">
                                <button class="btn btn-primary" type="submit">Save</button>
                        </form>
                        </td>
                        <td>
                            <a href="{{route('cart.destroy', $item->id)}}">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Total price:  {{Cart::session(auth()->id())->getTotal()}} FCFA</h3>

        <a name="" id="" class="btn btn-primary" href="{{route('cart.checkout')}}" role="button">Proceed to checkout</a>
@endsection
