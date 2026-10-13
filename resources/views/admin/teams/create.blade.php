@extends('admin.app')

@section('title', 'নতুন টিম সদস্য')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">নতুন টিম সদস্য যোগ করুন</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.teams.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">নাম (বাংলা)</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="designation">পদবি (বাংলা)</label>
                                <input type="text" class="form-control" id="designation" name="designation" required>
                            </div>
                            <div class="form-group">
                                <label for="photo">ছবি</label>
                                <input type="file" class="form-control-file" id="photo" name="photo" accept="image/*">
                            </div>
                            <div class="form-group">
                                <label for="bio_bn">বায়ো (বাংলা)</label>
                                <textarea class="form-control" id="bio_bn" name="bio_bn" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="order">অর্ডার নম্বর</label>
                                <input type="number" class="form-control" id="order" name="order" value="0">
                            </div>
                            <button type="submit" class="btn btn-primary">সংরক্ষণ করুন</button>
                            <a href="{{ route('admin.teams.index') }}" class="btn btn-secondary">বাতিল</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection