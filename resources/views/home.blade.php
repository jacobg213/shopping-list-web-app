@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">To buy:</div>

                <div class="panel-body">
                <ul id="items">

                </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">Actions</div>
                <div class="panel-body">
                    <form id="add_item">
                        <h4>Add new item</h4>
                        <div class="form-group">
                            <input id="name" title="Name" type="text" name="name" placeholder="Name">
                            <input id="qty" title="Quantity" type="number" name="quantity" placeholder="Quantity">
                        </div>
                    </form>
                    <button id="submit_item">Add to list</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
