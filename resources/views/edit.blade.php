@extends('layout')
   
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit User</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('customer.index') }}"> Back</a>
            </div>
        </div>
    </div>
   
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  
    <form action="{{ route('customer.update',$userData->id) }}" method="POST">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
   
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" value="{{ $userData->name }}" class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Email ID:</strong>
                    <input type="text" class="form-control" name="email" value ="{{ $userData->email }}" placeholder="Email ID">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Phone Number:</strong>
                    <input type="number" class="form-control" name="phone" placeholder="Phone Number" value ="{{ $userData->phone }}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Country:</strong>
                <select name="country">
                    <option value=" ">--Select Option--</option>
                    <option value="India" {{ ($userData->country== "India" ? "selected":"") }}>India</option>
                    <option value="US" {{ ($userData->country=="US" ? "selected":"") }}>US</option>
                    <option value="Brazil" {{ ($userData->country  == "Brazil" ? "selected":"") }}>Brazil</option>
                    <option value="Canada" {{ ($userData->country  == "Canada" ? "selected":"") }}>Canada</option>
                </select>
            </div>
        </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Comments:</strong>
                    <textarea rows="3" name="comments" >{{ $userData->comments }}</textarea>
                </div>
            </div>

       
        </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
   
    </form>
@endsection