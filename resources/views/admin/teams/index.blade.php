@extends('admin.app')

@section('title', 'টিম ম্যানেজমেন্ট')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">টিম সদস্য তালিকা</h6>
                        <a href="{{ route('admin.teams.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> নতুন সদস্য যোগ করুন
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ক্রমিক</th>
                                        <th>ছবি</th>
                                        <th>নাম</th>
                                        <th>পদবি</th>
                                        <th>অর্ডার</th>
                                        <th>অ্যাকশন</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($teams as $key => $team)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            @if($team->photo)
                                                <img src="{{ asset('storage/'.$team->photo) }}" alt="{{ $team->name }}" width="50" height="50" class="rounded-circle">
                                            @else
                                                <img src="{{ asset('backend/img/undraw_profile.svg') }}" alt="No Image" width="50" height="50" class="rounded-circle">
                                            @endif
                                        </td>
                                        <td>{{ $team->name }}</td>
                                        <td>{{ $team->designation }}</td>
                                        <td>{{ $team->order }}</td>
                                        <td>
                                            <a href="{{ route('admin.teams.edit', $team->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.teams.destroy', $team->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('আপনি কি নিশ্চিত?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection