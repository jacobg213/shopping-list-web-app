@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span>To buy:</span>
                    <button class="pull-right" onclick="restore_deleted()">Restore last removed</button>
                </div>

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
                    <button id="remove_all">Remove all</button>
                    <button id="submit_item" class="pull-right">Add to list</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Initialize Firebase
    var config = {
        apiKey: "AIzaSyD5LkxJYlnXxbb1MrRYBljpRU7H2oFqDwk",
        authDomain: "shopping-list-f3b3f.firebaseapp.com",
        databaseURL: "https://shopping-list-f3b3f.firebaseio.com",
        projectId: "shopping-list-f3b3f",
        storageBucket: "shopping-list-f3b3f.appspot.com",
        messagingSenderId: "141470586772"
    };
    firebase.initializeApp(config);
    var database = firebase.database().ref().child('items');
    database.on('value', function(snapshot) {
        var list = $('#items');
        list.empty();
        var i = 1;
        for(var item in snapshot.val())
        {
            list.append("<div id='item-div-" + i + "' class='row margin'><li><span>" + snapshot.val()[item].name + "</span><i>, x<b>" + snapshot.val()[item].quantity + "</b></i><button class='pull-right' id='item-" + i + "' data-id='" + item + "' onClick='delete_item(" + i + ")'>Remove item</button></li></div>");
            i++;
        }
    });

    $(document).ready(function() {
        $('#submit_item').click(function () {
            var name = $('#name').val();
            if(name == '' || name == undefined)
            {
                alert('Name is required');
                return false;
            }

            var qty = $('#qty').val();
            if(qty =='' || qty == undefined || name == ' ' || qty == ' ' || parseInt(qty) < 0 )
            {
                qty = 0;
            }
            else
            {
                qty = parseInt(qty);
            }
            var item = {
                name: name,
                quantity: qty
            };
            database.push(item);
            return false;
        });

        $('#remove_all').click(function () {
            var sure = confirm('Are you sure? This cannot be undone!');
            if (sure) {
                database.remove();
            }
        });
    });

    var deleted;

    function delete_item(i) {
        var id = $('#item-' + i).attr('data-id');
        deleted = $('#item-div-'+i);
        database.child(id).remove();
    }

    function restore_deleted () {
        if(deleted != null && deleted != undefined && deleted != '')
        {
            var name = deleted.find('span').text();
            var qty = parseInt(deleted.find('b').text());
            var item = {
                name: name,
                quantity: qty
            };
            database.push(item);
        }
    }
</script>
@endsection