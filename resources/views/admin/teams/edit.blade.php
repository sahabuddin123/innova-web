@extends('admin.app')

@section('title', 'টিম সদস্য সম্পাদনা')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">টিম সদস্য সম্পাদনা করুন</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.teams.update', $team->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">নাম (বাংলা)</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $team->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="designation">পদবি (বাংলা)</label>
                                <input type="text" class="form-control" id="designation" name="designation" value="{{ $team->designation }}" required>
                            </div>
                            <div class="form-group">
                                <label for="photo">ছবি</label>
                                @if($team->photo)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/'.$team->photo) }}" alt="{{ $team->name }}" width="100" height="100" class="rounded">
                                    </div>
                                @endif
                                <input type="file" class="form-control-file" id="photo" name="photo" accept="image/*">
                            </div>
                            <div class="form-group">
                                <label for="bio_bn">বায়ো (বাংলা)</label>
                                <textarea class="form-control" id="bio_bn" name="bio_bn" rows="3">{{ $team->bio_bn }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="order">অর্ডার নম্বর</label>
                                <input type="number" class="form-control" id="order" name="order" value="{{ $team->order }}">
                            </div>
                            <button type="submit" class="btn btn-primary">আপডেট করুন</button>
                            <a href="{{ route('admin.teams.index') }}" class="btn btn-secondary">বাতিল</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection