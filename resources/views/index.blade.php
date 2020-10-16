@extends('layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Laravel Demo</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('customer.create') }}"> Create New User</a>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered datatable-colvis-multi">
        <tr>
            <th>No</th>
            <th>Email</th>
            <th>First Name</th>
            <th>Mobile Number</th>
            <th>Country</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($userData as $uData)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $uData->email }}</td>
            <td>{{ $uData->name }}</td>
            <td>{{ $uData->phone }}</td>
            <td>{{ $uData->country }}</td>
            <td>
                <form action="{{ route('customer.destroy',$uData->id) }}" method="POST">
                   
                    <a class="btn btn-primary" href="{{ route('customer.edit',$uData->id) }}">Edit</a>
                    <!-- SUPPORT ABOVE VERSION 5.5 -->
                    {{-- @csrf
                    @method('DELETE') --}} 
                    
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                  
      
                    <button type="submit" class="btn btn-danger">Remove</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
    {!! $userData->links() !!}

@endsection 