@extends('layouts.app')
@section('content')
<store-detail cellar-data='{{$store->cellars}}' store-data='{{ $store }}' fruit-data='{{$store->fruits}}' customer-data='{{$store->customers}}' seller-data='{{$store->sellers}}' daysale-data='{{$store->daysales}}'></store-detail>
@endsection